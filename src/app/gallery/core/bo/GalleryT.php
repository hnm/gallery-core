<?php
namespace gallery\core\bo;

use n2n\reflection\ObjectAdapter;
use n2n\persistence\orm\annotation\AnnoEntityListeners;
use n2n\reflection\annotation\AnnoInit;
use n2n\persistence\orm\annotation\AnnoManyToOne;
use n2n\web\http\orm\ResponseCacheClearer;
use n2n\l10n\N2nLocale;
use n2n\io\managed\File;
use n2n\persistence\orm\annotation\AnnoManagedFile;
use rocket\impl\ei\component\prop\translation\Translatable;
use n2n\persistence\orm\annotation\AnnoTable;

class GalleryT extends ObjectAdapter implements Translatable {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoTable('gallery_core_gallery_t'), new AnnoEntityListeners(ResponseCacheClearer::getClass()));
		$ai->p('gallery', new AnnoManyToOne(Gallery::getClass()));
		$ai->p('fileTitleImage', new AnnoManagedFile());
	}
	
	private $id;
	private $name;
	private $pathPart;
	private $fileTitleImage;
	private $description;
	private $gallery;
	/**
	 * @var N2nLocale
	 */
	private $n2nLocale;
	
	
	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getPathPart() {
		return $this->pathPart;
	}

	public function setPathPart($pathPart) {
		$this->pathPart = $pathPart;
	}

	public function getFileTitleImage() {
		return $this->fileTitleImage;
	}

	public function setFileTitleImage(File $fileTitleImage = null) {
		$this->fileTitleImage = $fileTitleImage;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return \gallery\core\bo\Gallery
	 */
	public function getGallery() {
		return $this->gallery;
	}

	public function setGallery(Gallery $gallery) {
		$this->gallery = $gallery;
	}

	public function getN2nLocale() {
		return $this->n2nLocale;
		
	}

	public function setN2nLocale(N2nLocale $n2nLocale) {
		$this->n2nLocale = $n2nLocale;
	}
	
	public function determineTitleImage() {
		if (null !== $this->fileTitleImage) return $this->fileTitleImage;
		if (null !== $this->getGallery()->getDefaultGalleryImage()) return $this->getGallery()->getDefaultGalleryImage()->getFileImage();
		
		$images = $this->gallery->getGalleryImages();
		if (count($images) > 0) return $images->offsetGet(0)->getFileImage();
		return null;
	}
}

