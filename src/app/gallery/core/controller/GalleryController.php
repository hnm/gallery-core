<?php
namespace gallery\core\controller;

use gallery\core\bo\Gallery;
use gallery\core\model\GalleryState;
use n2n\web\http\PageNotFoundException;

class GalleryController extends GalleryControllerAdapter {
	private $gallery;
	
	public function getGallery() {
		return $this->gallery;
	}

	public function setGallery(Gallery $gallery) {
		$this->gallery = $gallery;
	}

	public function index(GalleryState $galleryState) {
		if ($this->gallery === null) throw new PageNotFoundException('No gallery given');
		
		if (!$galleryState->initGallery($this->gallery)) {
			throw new PageNotFoundException('Invalid galery given');
		}	
		
		$this->forwardViewWithDtc($this->galleryConfig->getGalleryViewId(), array('gallery' => $this->gallery));
	}
}
