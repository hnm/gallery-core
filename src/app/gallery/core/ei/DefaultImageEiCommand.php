<?php
namespace gallery\core\ei;

use n2n\web\http\controller\ControllerAdapter;
use n2n\impl\web\ui\view\html\HtmlView;
use n2n\l10n\DynamicTextCollection;
use n2n\l10n\N2nLocale;
use n2n\web\http\controller\Controller;
use n2n\util\uri\Path;
use n2n\reflection\CastUtils;
use gallery\core\bo\GalleryImage;
use rocket\impl\ei\component\command\IndependentEiCommandAdapter;
use n2n\core\container\N2nContext;
use rocket\ei\manage\control\EntryControlComponent;
use rocket\ei\util\model\Eiu;
use rocket\ei\manage\control\ControlButton;
use rocket\ei\manage\control\HrefControl;
use rocket\ei\manage\control\IconType;
use rocket\ei\util\model\EiuCtrl;

class DefaultImageEiCommand extends IndependentEiCommandAdapter implements EntryControlComponent {
	const CONTROL_KEY = 'default';
	
	/**
	 * {@inheritDoc}
	 * @see \rocket\spec\ei\component\command\EiCommand::lookupController()
	 */
	public function lookupController(Eiu $eiu): Controller {
		return $eiu->lookup(DefaultImageController::class);	
	}
	
	/**
	 * {@inheritDoc}
	 * @see \rocket\spec\ei\manage\control\EntryControlComponent::createEntryHrefControls()
	 */
	public function getEntryControlOptions(N2nContext $n2nContext, N2nLocale $n2nLocale): array {
		return array(self::CONTROL_KEY => 'Default');
	}
	
	public function createEntryControls(Eiu $eiu, HtmlView $view): array {
		$hrefControls = array();
	
		$galleryImage = $eiu->entry()->getLiveEntry()->getEntityObj();
		CastUtils::assertTrue($galleryImage instanceof GalleryImage);
		
		$controlType = ControlButton::TYPE_DEFAULT;
		
		if ($galleryImage->getGallery()->getDefaultGalleryImage() === $galleryImage) {
			$controlType = ControlButton::TYPE_WARNING;
		}
		
		$dtc = new DynamicTextCollection('gallery', $view->getN2nLocale());
		
		$label = $dtc->t('common_edit_label');
		$tooltip = $dtc->t('ei_impl_edit_entry_tooltip', array('entry' => $eiu->frame()->getGenericLabel()));
		$hrefControls[] = HrefControl::create($eiu->frame()->getEiFrame(), $this, 
				(new Path(array($eiu->entry()->getLiveIdRep())))->toUrl(),
				new ControlButton($label, $tooltip, true, $controlType, IconType::ICON_IMAGE));
		
		return $hrefControls;
	}

}


class DefaultImageController extends ControllerAdapter {
	
	public function index(EiuCtrl $eiuCtrl, $idRep) {
		$eiSelection = $eiuCtrl->lookupEiSelection($idRep);
		
		$galleryImage = $eiSelection->getLiveObject();
		CastUtils::assertTrue($galleryImage instanceof GalleryImage);
		
		$galleryImage->getGallery()->setDefaultGalleryImage($galleryImage);
		
		$eiuCtrl->redirectToOverview();
	}
	
}