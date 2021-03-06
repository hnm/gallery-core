<?php

namespace gallery\core\bo;

use n2n\reflection\ObjectAdapter;
use n2n\l10n\N2nLocale;
use n2n\reflection\annotation\AnnoInit;
use n2n\persistence\orm\annotation\AnnoEntityListeners;
use n2n\web\http\orm\ResponseCacheClearer;
use n2n\persistence\orm\annotation\AnnoManyToOne;
use n2n\persistence\orm\annotation\AnnoManagedFile;
use n2n\io\managed\File;
use rocket\impl\ei\component\prop\translation\Translatable;
use n2n\persistence\orm\annotation\AnnoTable;
use n2n\util\type\CastUtils;

class GalleryGroupT extends ObjectAdapter implements Translatable {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoTable('gallery_core_gallery_group_t'), new AnnoEntityListeners(ResponseCacheClearer::getClass()));
		$ai->p('galleryGroup', new AnnoManyToOne(GalleryGroup::getClass()));
		$ai->p('fileTitleImage', new AnnoManagedFile());
	}
	
	private $id;
	private $title;
	private $pathPart;
	private $intro;
	private $fileTitleImage;
	private $galleryGroup;
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

	public function getPathPart() {
		return $this->pathPart;
	}

	public function setPathPart($pathPart) {
		$this->pathPart = $pathPart;
	}

	public function getIntro() {
		return $this->intro;
	}

	public function setIntro($intro) {
		$this->intro = $intro;
	}

	/**
	 * @return \n2n\io\managed\File
	 */
	public function getFileTitleImage() {
		return $this->fileTitleImage;
	}

	public function setFileTitleImage(File $fileTitleImage = null) {
		$this->fileTitleImage = $fileTitleImage;
	}

	/**
	 * @return \gallery\core\bo\GalleryGroup
	 */
	public function getGalleryGroup() {
		return $this->galleryGroup;
	}

	public function setGalleryGroup(GalleryGroup $galleryGroup) {
		$this->galleryGroup = $galleryGroup;
	}

	public function getN2nLocale() {
		return $this->n2nLocale;
	
	}
	
	public function setN2nLocale(N2nLocale $n2nLocale) {
		$this->n2nLocale = $n2nLocale;
	}
	
	public function determineTitleImage() {
		if (null !== $this->fileTitleImage) return $this->fileTitleImage;
		if (null !== $this->getGalleryGroup()->getDefaultImage()) return  $this->getGalleryGroup()->getDefaultImage();
		
		$galleries = $this->galleryGroup->getGalleries();
		if (count($galleries) > 0) {
			$firstGallery = $galleries->offsetGet(0);
			if (null !== $firstGallery) {
				CastUtils::assertTrue($firstGallery instanceof Gallery);
				if (null !== ($firstGalleryT= $firstGallery->t($this->n2nLocale))) return $firstGalleryT->determineTitleImage();
				if (null !== $galleryImage = $firstGallery->getDefaultGalleryImage()) return $galleryImage->getFileImage();
			}
		}
		return null;
	}
}

