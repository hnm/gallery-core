<?php
namespace gallery\core\model;

use gallery\core\bo\GalleryGroup;
use n2n\context\RequestScoped;
use n2n\util\col\ArrayUtils;
use n2n\util\ex\IllegalStateException;
use n2n\util\uri\Url;
use gallery\core\bo\Gallery;
use n2n\l10n\N2nLocale;
use gallery\core\config\GalleryConfig;

class GalleryState implements RequestScoped {
	private $galleryDao;
	private $galleryConfig;
	
	private $rootUrl;
	private $rootGalleryGroup;
	private $galleryGroups;
	private $currentGalleryGroup;
	private $currentGallery;
		
	private $childGalleryGroups = array();
	private $childGalleries = array();
	
	private $title = null;
	private $galleryNums = [];
	
	private function _init(GalleryDao $galleryDao, GalleryConfig $galleryConfig) {
		$this->galleryDao = $galleryDao;
		$this->galleryConfig = $galleryConfig;
	}
	
	public function initGalleryGroupPath(string $pathPart = null,
			GalleryGroup $rootGalleryGroup = null, Url $rootUrl) {
		$this->galleryGroups = [];
		$this->rootGalleryGroup = $rootGalleryGroup;
		if ($pathPart === null) {
			if (null !== $rootGalleryGroup) {
				$this->galleryGroups[] = $rootGalleryGroup;
			}
		} else {
			$this->galleryGroups = $this->galleryDao->getGalleryGroupPathByPathPart($pathPart, $rootGalleryGroup);
		}
		
		$this->currentGalleryGroup = ArrayUtils::end($this->galleryGroups);
		$this->rootUrl = $rootUrl;
		
		$this->childGalleries = [];
		if ($this->hasCurrentGalleryGroup()) {
			$this->childGalleries = $this->getCurrentGalleryGroup()->getGalleries();
		}
		
		$this->childGalleryGroups = $this->galleryDao->getChildrenOfGalleryGroup($this->currentGalleryGroup);
		
		foreach ($this->childGalleryGroups as $childGalleryGroup) {
			$this->galleryNums[$childGalleryGroup->getId()] = $this->galleryDao->getNumGalleries($childGalleryGroup);
		}
	}
	
	public function initAllGalleries(Url $rootUrl) {
		$this->rootUrl = $rootUrl;
		
		$this->childGalleries = $this->galleryDao->getGalleries();
	}
	
	public function initGalleryByPathPart(string $pathPart, Url $rootUrl = null) {
		$this->currentGallery = $this->galleryDao->getGalleryByPathPart($pathPart, $this->currentGalleryGroup);
		
		if ($rootUrl !== null) {
			$this->rootUrl = $rootUrl;
		}
		
		return $this->currentGallery !== null;
	}
	
	public function initGallery(Gallery $gallery) {
		$this->currentGallery = $gallery;
		
		return true;
	}
	
	/**
	 * @return GalleryGroup
	 */
	public function getCurrentGalleryGroup() {
		IllegalStateException::assertTrue($this->currentGalleryGroup !== null);
		return $this->currentGalleryGroup;
	}
	
	/**
	 * @return boolean
	 */
	public function hasCurrentGalleryGroup() {
		return $this->currentGalleryGroup !== null;
	}
	
	/**
	 * @return Gallery
	 */
	public function getCurrentGallery() {
		IllegalStateException::assertTrue($this->currentGallery !== null);
		return $this->currentGallery;
	}
	
	/**
	 * @return boolean
	 */
	public function hasCurrentGallery() {
		return $this->currentGallery !== null;
	}
	
	
	/**
	 * @return boolean
	 */
	public function hasRootUrl() {
		return $this->rootUrl !==  null;
	}
	
	/**
	 * 
	 * @return GalleryGroup[]
	 */
	public function getChildGalleryGroups() {
		return $this->childGalleryGroups;
	}
	
	/**
	 * 
	 * @return Gallery[]
	 */
	public function getChildGalleries() {
		return $this->childGalleries;
	}
	
	public function getTitle(N2nLocale $n2nLocale) {
		if ($this->currentGallery !== null) {
			return $this->currentGallery->t($n2nLocale)->getName();
		}

		if ($this->hasCurrentGalleryGroup() && $this->currentGalleryGroup->equals($this->rootGalleryGroup)) {
			return null;
		}
		
		if ($this->title !== null) {
			return $this->title;
		}
		
		if ($this->currentGalleryGroup !== null) {
			return $this->currentGalleryGroup->t($n2nLocale)->getTitle();
		}
		
		return null;
	}
	
	public function getNumGalleries(GalleryGroup $galleryGroup) {
		IllegalStateException::assertTrue(isset($this->galleryNums[$galleryGroup->getId()]));
		
		return $this->galleryNums[$galleryGroup->getId()];
	}
	
	public function getDetailPaths(N2nLocale $n2nLocale, Gallery $gallery = null) {
		$paths = array();
		if ($this->currentGalleryGroup !== null) {
			array_push($paths, $this->currentGalleryGroup->t($n2nLocale)->getPathPart());
		}
		
		if ($gallery !== null) {
			array_push($paths, $gallery->t($n2nLocale)->getPathPart());
		}
		
		return $paths;
	}
	/**
	 *
	 * @return Breadcrumb []
	 */
	public function getBreadcrumbs(N2nLocale $n2nLocale) {
		if ($this->rootUrl === null 
				|| !($this->hasCurrentGalleryGroup() || $this->hasCurrentGallery())
				/* || ($this->hasCurrentGalleryGroup() && !$this->hasCurrentGallery() 
						&& $this->getCurrentGalleryGroup()->equals($this->rootGalleryGroup) */) {
			return array();
		}
		
		$breadCrumbs = array();
		if (null === $this->rootGalleryGroup) {
			$breadCrumbs[] = new Breadcrumb($this->rootUrl, $this->galleryConfig->getDtc()->t('overview_txt'));
		}
		
		if ($this->hasCurrentGalleryGroup()) {
			foreach ($this->galleryGroups as $gallerygroup) {
				$url = $this->rootUrl;
				if (!$gallerygroup->equals($this->rootGalleryGroup)) {
					$url = $url->extR(array($gallerygroup->t($n2nLocale)->getPathPart()));
				}
				
				$breadCrumb = new Breadcrumb($url, $gallerygroup->t($n2nLocale)->getTitle());
				
				if ($gallerygroup->equals($this->currentGalleryGroup) && !$this->hasCurrentGallery()) {
					$breadCrumb->setActive(true);
				}
				
				$breadCrumbs[] = $breadCrumb;
			}
		}
		
		if ($this->hasCurrentGallery()) {
			$breadcrumb = new Breadcrumb($this->rootUrl->ext(
					array($this->currentGallery->t($n2nLocale)->getPathPart())), 
					$this->currentGallery->t($n2nLocale)->getName());
			$breadcrumb->setActive(true);
			$breadCrumbs[] = $breadcrumb;
		}

		return $breadCrumbs;
	}
	
	public function getGalleryConfig() {
		return $this->galleryConfig;
	}
}