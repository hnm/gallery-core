<?php
namespace gallery\core\controller;

use n2n\web\http\controller\ControllerAdapter;
use gallery\core\config\GalleryConfig;

class GalleryControllerAdapter extends ControllerAdapter {
	protected $galleryConfig;
	
	private function _init(GalleryConfig $galleryConfig) {
		$this->galleryConfig = $galleryConfig;
	}
	
	protected function forwardViewWithDtc(string $viewNameExpression, array $params = null) {
		$view = $this->createView($viewNameExpression, $params);
		$view->setDynamicTextCollection($this->galleryConfig->getDtc());
		$this->forwardView($view);
	}
}