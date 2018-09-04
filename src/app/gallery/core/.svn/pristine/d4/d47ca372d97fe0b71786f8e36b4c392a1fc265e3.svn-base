<?php
namespace gallery\core\bo;

use n2n\persistence\orm\annotation\AnnoEntityListeners;
use n2n\reflection\annotation\AnnoInit;
use n2n\persistence\orm\annotation\AnnoManyToOne;
use n2n\reflection\ObjectAdapter;
use n2n\web\http\orm\ResponseCacheClearer;
use n2n\l10n\N2nLocale;
use rocket\impl\ei\component\prop\translation\Translatable;
use n2n\persistence\orm\annotation\AnnoTable;

class GalleryImageT extends ObjectAdapter implements Translatable {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoTable('gallery_core_gallery_image_t'), new AnnoEntityListeners(ResponseCacheClearer::getClass()));
		$ai->p('galleryImage', new AnnoManyToOne(GalleryImage::getClass()));
	}
	
	private $id;
	private $title;
	private $altTag;
	private $description;
	private $tags;
	private $galleryImage;
	/**
	 * @var N2nLocale
	 */
	private $n2nLocale;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getAltTag() {
		return $this->altTag;
	}

	public function setAltTag($altTag) {
		$this->altTag = $altTag;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getTags() {
		return $this->tags;
	}

	public function setTags($tags) {
		$this->tags = $tags;
	}
	

	/**
	 * @return \gallery\core\bo\GalleryImage
	 */
	public function getGalleryImage() {
		return $this->galleryImage;
	}

	/**
	 * @param GalleryImage $galleryImage
	 */
	public function setGalleryImage(GalleryImage $galleryImage) {
		$this->galleryImage = $galleryImage;
	}

	public function getN2nLocale() {
		return $this->n2nLocale;
		
	}

	public function setN2nLocale(N2nLocale $n2nLocale) {
		$this->n2nLocale = $n2nLocale;
	}
	
	public function determineAltTag() {
		if ($this->altTag) return $this->altTag;
		
		return $this->title;
	}
	
}