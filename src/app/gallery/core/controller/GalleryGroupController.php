<?php
namespace gallery\core\controller;
use n2n\reflection\annotation\AnnoInit;
use n2n\web\http\annotation\AnnoPath;
use gallery\core\bo\GalleryGroup;
use gallery\core\model\GalleryDao;
use gallery\core\model\GalleryState;
use n2n\web\http\PageNotFoundException;
use n2n\web\http\Response;

class GalleryGroupController extends GalleryControllerAdapter {
	private static function _annos(AnnoInit $ai) {
		$ai->m('gallery', new AnnoPath('galleryGroupPathPart:*/galleryPathPart:*'));
	}
	
	private $rootGalleryGroup;
	private $galleryDao;
	private $galleryState;
	
	private function _init(GalleryDao $galleryDao, GalleryState $galleryState) {
		$this->galleryDao = $galleryDao;
		$this->galleryState = $galleryState;
	}
	
	public function index($galleryGroupPathPart = null) {
		$this->galleryState->initGalleryGroupPath($galleryGroupPathPart, 
				$this->getRootGalleryGroup(), $this->getUrlToController());
		
		if ($galleryGroupPathPart !== null) {
			if (!$this->galleryState->hasCurrentGalleryGroup() 
					|| $this->galleryState->getCurrentGalleryGroup()->equals($this->getRootGalleryGroup())) {
				throw new PageNotFoundException('Invalid gallery group path part');
			}
			
			$bestPathPart = $this->galleryState->getCurrentGalleryGroup()->t($this->getRequest()->getN2nLocale())->getPathPart();
			if ($bestPathPart !== $galleryGroupPathPart) {
				$this->redirectToController(array($bestPathPart), null, Response::STATUS_301_MOVED_PERMANENTLY);
				return;
			}
		}
		
		$this->forwardViewWithDtc($this->galleryConfig->getGalleryGroupViewId());
	}
	
	public function gallery($galleryGroupPathPart, $galleryPathPart, GalleryController $galleryController) {
		$this->galleryState->initGalleryGroupPath($galleryGroupPathPart, $this->rootGalleryGroup,
				$this->getUrlToController());
		
 		if (!$this->galleryState->initGalleryByPathPart($galleryPathPart)) {
 			throw new PageNotFoundException();
 		}
		
 		$galleryController->setGallery($this->galleryState->getCurrentGallery());
		$this->delegate($galleryController);
	}
	
	public function setRootGalleryGroup(GalleryGroup $rootGalleryGroup = null) {
		$this->rootGalleryGroup = $rootGalleryGroup;
	}
	
	public function getRootGalleryGroup() {
		return $this->rootGalleryGroup;
	}

}
