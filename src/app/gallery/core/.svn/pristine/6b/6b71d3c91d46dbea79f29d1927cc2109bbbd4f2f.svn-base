<?php
namespace gallery\core\config;

use n2n\context\RequestScoped;
use n2n\l10n\DynamicTextCollection;
use n2n\core\container\N2nContext;

class GalleryConfig implements RequestScoped {
	private $templateViewId = '\gallery\core\view\galleryTemplate.html';
	private $galleryGroupViewId = '\gallery\core\view\galleryGroup.html';
	private $galleryViewId = '\gallery\core\view\gallery.html';
	private $breadCrumbsViewId = '\gallery\core\view\breadCrumbs.html';
	private $dtc;
	
	private function _init(DynamicTextCollection $dtc, N2nContext $n2nContext) {
		$this->dtc = $dtc;
		if ($n2nContext->getModuleManager()->containsModuleNs('bstmpl')) {
			$this->templateViewId = '\bstmpl\view\bsTemplate.html';
		}
	}
	
	public function getDtc() {
		return $this->dtc;
	}
	
	public function setDtc(DynamicTextCollection $dtc) {
		$this->dtc = $dtc;
	}
	
	public function getTemplateViewId() {
		return $this->templateViewId;
	}
	
	public function setTemplateViewId(string $templateViewId) {
		$this->templateViewId = $templateViewId;
	}
	
	public function getGalleryGroupViewId() {
		return $this->galleryGroupViewId;
	}
	
	public function setGalleryGroupViewId(string $galleryGroupViewId) {
		$this->galleryGroupViewId = $galleryGroupViewId;
	}
	
	public function getGalleryViewId() {
		return $this->galleryViewId;
	}
	
	public function setGalleryViewId(string $galleryViewId) {
		$this->galleryViewId = $galleryViewId;
	}
	
	public function getBreadCrumbsViewId() {
		return $this->breadCrumbsViewId;
	}

	public function setBreadCrumbsViewId(string $breadCrumbsViewId) {
		$this->breadCrumbsViewId = $breadCrumbsViewId;
	}

	
	
}