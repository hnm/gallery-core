<?php
namespace gallery\core\bo;

use n2n\persistence\orm\CascadeType;
use n2n\persistence\orm\annotation\AnnoOneToMany;
use n2n\persistence\orm\annotation\AnnoOrderBy;
use n2n\persistence\orm\annotation\AnnoManyToOne;
use n2n\reflection\annotation\AnnoInit;
use n2n\reflection\ObjectAdapter;
use n2n\persistence\orm\annotation\AnnoEntityListeners;
use n2n\web\http\orm\ResponseCacheClearer;
use n2n\persistence\orm\FetchType;
use rocket\impl\ei\component\prop\translation\Translator;
use n2n\l10n\N2nLocale;
use n2n\persistence\orm\annotation\AnnoTable;
use n2n\persistence\orm\annotation\AnnoDateTime;

class Gallery extends ObjectAdapter {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoTable('gallery_core_gallery'), new AnnoEntityListeners(ResponseCacheClearer::getClass()));
		$ai->p('galleryTs', new AnnoOneToMany(GalleryT::getClass(), 'gallery', CascadeType::ALL, null, true));
		$ai->p('galleryImages', new AnnoOneToMany(GalleryImage::getClass(), 'gallery', CascadeType::ALL, null, true),
				new AnnoOrderBy(array('orderIndex' => 'ASC')));
		$ai->p('galleryGroup', new AnnoManyToOne(GalleryGroup::getClass()));
		$ai->p('defaultGalleryImage', new AnnoManyToOne(GalleryImage::getClass(), null, FetchType::EAGER));
		$ai->p('lastMod', new AnnoDateTime());
	}
	
	private $id;
	private $defaultGalleryImage;
	private $galleryImages;
	private $orderIndex;
	private $online = true;
	private $lastMod;
	private $lastModBy;
	private $created;
	private $createdBy;
	private $galleryGroup;
	private $password;
	private $galleryTs;
	
	public function __construct() {
		$this->galleryImages = new \ArrayObject();
		$this->created = $this->lastMod = new \DateTime();
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

	public function getDefaultGalleryImage() {
		return $this->defaultGalleryImage;
	}

	public function setDefaultGalleryImage(GalleryImage $defaultGalleryImage = null) {
		$this->defaultGalleryImage = $defaultGalleryImage;
	}

	/**
	 * @return GalleryImage[]
	 */
	public function getGalleryImages() {
		return $this->galleryImages;
	}

	public function setGalleryImages($galleryImages) {
		$this->galleryImages = $galleryImages;
	}

	public function getOrderIndex() {
		return $this->orderIndex;
	}

	public function setOrderIndex($orderIndex) {
		$this->orderIndex = $orderIndex;
	}

	public function isOnline() {
		return $this->online;
	}

	public function setOnline($online) {
		$this->online = $online;
	}

	public function getLastMod() {
		return $this->lastMod;
	}
	
	public function getLastModBy() {
		return $this->lastModBy;
	}
	
	public function getCreatedBy() {
		return $this->createdBy;
	}

	public function getCreated() {
		return $this->created;
	}

	public function setCreated(\DateTime $created) {
		$this->created = $created;
	}

	public function setCreatedBy($createdBy) {
		$this->createdBy = $createdBy;
	}
	/**
	 * @return GalleryGroup
	 */
	public function getGalleryGroup() {
		return $this->galleryGroup;
	}

	public function setGalleryGroup($galleryGroup = null) {
		$this->galleryGroup = $galleryGroup;
	}
	
	public function getPassword() {
		return $this->password;
	}

	public function setPassword($password) {
		$this->password = $password;
	}
	
	/**
	 * @return GalleryT[]
	 */
	public function getGalleryTs() {
		return $this->galleryTs;
	}

	public function setGalleryTs(\ArrayObject $galleryTs) {
		$this->galleryTs = $galleryTs;
	}

	public function equals($obj) {
		return $obj instanceof Gallery && $obj->getId() === $this->id;
	}
	
	/**
	 * @param N2nLocale[] ...$n2nLocales
	 * @return GalleryT
	 */
	public function t(...$n2nLocales) {
		return Translator::requireAny($this->galleryTs, ...$n2nLocales);
	}
	
	public function hasGalleryImages() {
		return count($this->galleryImages) > 0;
	}
}