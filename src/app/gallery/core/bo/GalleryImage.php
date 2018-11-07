<?php
namespace gallery\core\bo;

use n2n\io\managed\File;
use n2n\io\managed\impl\SimpleFileLocator;
use n2n\persistence\orm\annotation\AnnoManyToOne;
use n2n\persistence\orm\annotation\AnnoManagedFile;
use n2n\io\managed\impl\PublicFileManager;
use n2n\reflection\ObjectAdapter;
use n2n\reflection\annotation\AnnoInit;
use n2n\persistence\orm\annotation\AnnoEntityListeners;
use n2n\web\http\orm\ResponseCacheClearer;
use n2n\persistence\orm\annotation\AnnoOneToMany;
use n2n\persistence\orm\CascadeType;
use n2n\l10n\N2nLocale;
use n2n\core\config\AppConfig;
use n2n\util\col\ArrayUtils;
use gallery\core\util\GalleryUtils;
use n2n\util\StringUtils;
use rocket\impl\ei\component\prop\translation\Translator;
use n2n\persistence\orm\annotation\AnnoTable;
use n2n\persistence\orm\annotation\AnnoDateTime;

class GalleryImage extends ObjectAdapter {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoTable('gallery_core_gallery_image'), new AnnoEntityListeners(ResponseCacheClearer::getClass()));
		$ai->p('gallery', new AnnoManyToOne(Gallery::getClass()));
		$ai->p('galleryImageTs', new AnnoOneToMany(GalleryImageT::getClass(), 'galleryImage', CascadeType::ALL, null, true));
		$ai->p('fileImage', new AnnoManagedFile(PublicFileManager::class, 
				new SimpleFileLocator('gallery-image', (new \DateTime())->format('ymd'))));
		$ai->p('lastMod', new AnnoDateTime());
	} 
	
	private $id;
	private $fileImage;
	private $gallery;
	private $galleryImageTs;
	private $orderIndex;
	private $created;
	private $createdBy;
	private $lastMod;
	private $lastModBy;
	
	public function __construct() {
		$this->created = $this->lastMod = new \DateTime();
		$this->galleryImageTs = new \ArrayObject();
	}
	
	private function _prePersist(AppConfig $appConfig) {
		if ($this->galleryImageTs->count() > 1 || $this->fileImage === null || null !== $this->id) {
			return;
		}
		
		$iptc = GalleryUtils::getIPTC($this->getFileImage());
		
		$prettyNameParts = preg_split('/(\.|-|_)/', $this->fileImage->getOriginalName());
		array_pop($prettyNameParts);
		$prettyName = implode(' ', $prettyNameParts);
		
		$title = (isset($iptc[GalleryUtils::IPTC_KEY_TITLE])) ? $iptc[GalleryUtils::IPTC_KEY_TITLE] : $prettyName;
		
		//Don't set the description as pretty name - Moco task 25.10.2018 
		$description = (isset($iptc[GalleryUtils::IPTC_KEY_DESCRIPTION])) ? $iptc[GalleryUtils::IPTC_KEY_DESCRIPTION] : null;
		$tags = isset($iptc[GalleryUtils::IPTC_KEY_KEY_WORDS]) ? StringUtils::reduce($iptc[GalleryUtils::IPTC_KEY_KEY_WORDS], 255) : null;
		
		$gt = null;
		
		if ($this->galleryImageTs->count() === 1) {
			$gt = ArrayUtils::first($this->galleryImageTs);
		} else {
			$gt = new GalleryImageT();
			$this->setCreated(new \DateTime());
			$gt->setGalleryImage($this);
			$n2nLocale = ArrayUtils::first($appConfig->web()->getAllN2nLocales());
			if ($n2nLocale === null) {
				$n2nLocale = N2nLocale::getDefault();
			}
			
			$gt->setN2nLocale($n2nLocale);
		}
		
		if (null === $gt->getTitle()) {
			$gt->setTitle($title);
		}
		
		if (null === $gt->getDescription()) {
			$gt->setDescription($description);
		}
		
		if (null === $gt->getTags()) {
			$gt->setTags($tags);
		}
		
		$this->galleryImageTs->append($gt);
		
		//$this->setCreatedBy($this->loginContext->getCurrentUser()->getId());
		//$this->setLastMod(new \DateTime());
		//$this->setLastModBy($this->loginContext->getCurrentUser()->getId());
		//$this->setOrderIndex($this->determineNextOrderIndex($gallery));
		
		
	}
	
	private function _preUpdate() {
		$this->lastMod = new \DateTime();
	}
	
	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return \n2n\io\managed\File
	 */
	public function getFileImage() {
		return $this->fileImage;
	}

	public function setFileImage(File $fileImage) {
		$this->fileImage = $fileImage;
	}

	/**
	 * @return Gallery
	 */
	public function getGallery() {
		return $this->gallery;
	}

	public function setGallery(Gallery $gallery) {
		$this->gallery = $gallery;
	}
	
	/**
	 * @return GalleryImageT[]
	 */
	public function getGalleryImageTs() {
		return $this->galleryImageTs;
	}

	public function setGalleryImageTs(\ArrayObject $galleryImageTs) {
		$this->galleryImageTs = $galleryImageTs;
	}

	public function getOrderIndex() {
		return $this->orderIndex;
	}

	public function setOrderIndex($orderIndex) {
		$this->orderIndex = $orderIndex;
	}
	
	public function equals($obj) {
		return $obj instanceof GalleryImage && $obj->getId() === $this->id;
	}
	
	public function getCreated() {
		return $this->created;
	}

	public function setCreated(\DateTime $created = null) {
		$this->created = $created;
	}

	public function getLastMod() {
		return $this->lastMod;
	}

	/**
	 * @param N2nLocale[] ...$n2nLocales
	 * @return GalleryImageT
	 */
	public function t(...$n2nLocales) {
		$n2nLocales[] = N2nLocale::getDefault();
		$n2nLocales[] = N2nLocale::getFallback();
		return Translator::requireAny($this->galleryImageTs, ...$n2nLocales);
	}
}
