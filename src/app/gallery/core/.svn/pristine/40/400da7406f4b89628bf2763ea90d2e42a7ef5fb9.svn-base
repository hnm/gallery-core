<?php
namespace gallery\core\bo;

use n2n\persistence\orm\CascadeType;
use n2n\persistence\orm\annotation\AnnoOneToMany;
use n2n\persistence\orm\annotation\AnnoOrderBy;
use n2n\persistence\orm\annotation\AnnoTable;
use n2n\reflection\annotation\AnnoInit;
use n2n\reflection\ObjectAdapter;
use n2n\persistence\orm\annotation\AnnoEntityListeners;
use n2n\web\http\orm\ResponseCacheClearer;
use rocket\impl\ei\component\prop\translation\Translator;
use n2n\l10n\N2nLocale;
use n2n\reflection\CastUtils;
use gallery\core\bo\Gallery;
use n2n\io\managed\File;
use gallery\core\bo\GalleryGroupT;
use n2n\persistence\orm\annotation\AnnoManagedFile;

class GalleryGroup extends ObjectAdapter {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoTable('gallery_core_gallery_group'), new AnnoEntityListeners(ResponseCacheClearer::getClass()));
		$ai->p('galleries', new AnnoOneToMany(Gallery::getClass(), 'galleryGroup', CascadeType::ALL), new AnnoOrderBy(array('orderIndex' => 'ASC')));
		$ai->p('defaultImage', new AnnoManagedFile());
		$ai->p('galleryGroupTs', new AnnoOneToMany(GalleryGroupT::getClass(), 'galleryGroup', CascadeType::ALL, null, true));
	}

	private $id;
	private $galleries;
	private $defaultImage;
	private $online = true;
	private $lft;
	private $rgt;
	private $galleryGroupTs;

	public function __construct() {
		$this->galleries = new \ArrayObject();
	}

	/**
	 * @return Gallery []
	 */
	public function getOnlineGalleries() {
		$onlineGalleries = array();
		foreach ($this->galleries as $gallery) {
			CastUtils::assertTrue($gallery instanceof Gallery);
			if (!$gallery->isOnline()) continue;
			$onlineGalleries[] = $gallery;
		}
		return $onlineGalleries;
	}

	public function equals($o) {
		return $o instanceof GalleryGroup && $o->getId() === $this->id;
	}

	/**
	 * @param N2nLocale[] ...$n2nLocales
	 * @return GalleryGroupT
	 */
	public function t(...$n2nLocales) {
		$n2nLocales[] = N2nLocale::getDefault();
		$n2nLocales[] = N2nLocale::getFallback();
		return Translator::requireAny($this->galleryGroupTs, ...$n2nLocales);
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId(int $id = null) {
		$this->id = $id;
	}

	/**
	 * @return Gallery []
	 */
	public function getGalleries() {
		return $this->galleries;
	}

	public function setGalleries($galleries) {
		$this->galleries = $galleries;
	}

	/**
	 * @return File
	 */
	public function getDefaultImage() {
		return $this->defaultImage;
	}

	/**
	 * @param File $defaultImage
	 */
	public function setDefaultImage(File $defaultImage = null) {
		$this->defaultImage = $defaultImage;
	}

	/**
	 * @return bool
	 */
	public function isOnline() {
		return $this->online;
	}

	/**
	 * @param bool $online
	 */
	public function setOnline(bool $online = null) {
		$this->online = (bool) $online;
	}

	/**
	 * @return int
	 */
	public function getLft() {
		return $this->lft;
	}

	/**
	 * @param int $lft
	 */
	public function setLft(int $lft = null) {
		$this->lft = $lft;
	}

	/**
	 * @return int
	 */
	public function getRgt() {
		return $this->rgt;
	}

	/**
	 * @param int $rgt
	 */
	public function setRgt(int $rgt = null) {
		$this->rgt = $rgt;
	}

	/**
	 * @return GalleryGroupT []
	 */
	public function getGalleryGroupTs() {
		return $this->galleryGroupTs;
	}

	/**
	 * @param \ArrayObject $galleryGroupTs
	 */
	public function setGalleryGroupTs(\ArrayObject $galleryGroupTs) {
		$this->galleryGroupTs = $galleryGroupTs;
	}
	
	public function hasContent() {
		return $this->lft + 1 < $this->rgt || count($this->galleries) > 0;
	}
	
	public function getNumGalleries() {
		return count($this->galleries);
	}
}