<?php
namespace gallery\core\controller;

use gallery\core\model\GalleryState;

class GalleryListController extends GalleryControllerAdapter {
	public function index(GalleryState $galleryState) {
		$galleryState->initAllGalleries($this->getUrlToController());
		$this->forward($this->forwardViewWithDtc($this->galleryConfig->getGalleryGroupViewId()));
	}
}