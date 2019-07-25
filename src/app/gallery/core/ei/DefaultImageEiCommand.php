<?php
namespace gallery\core\ei;

use n2n\web\http\controller\ControllerAdapter;
use n2n\impl\web\ui\view\html\HtmlView;
use n2n\l10n\DynamicTextCollection;
use n2n\l10n\N2nLocale;
use n2n\web\http\controller\Controller;
use n2n\util\uri\Path;
use n2n\util\type\CastUtils;
use gallery\core\bo\GalleryImage;
use rocket\impl\ei\component\command\IndependentEiCommandAdapter;
use n2n\core\container\N2nContext;
use rocket\ei\component\command\control\EntryGuiControlComponent;
use rocket\ei\util\Eiu;
use rocket\si\control\SiButton;
use rocket\ei\manage\gui\control\HrefControl;
use rocket\si\control\SiIconType;
use rocket\ei\util\EiuCtrl;

class DefaultImageEiCommand extends IndependentEiCommandAdapter implements EntryGuiControlComponent {
	const CONTROL_EDIT_KEY = 'default';
	
	/**
	 * {@inheritDoc}
	 * @see \rocket\ei\component\command\EiCommand::lookupController()
	 */
	public function lookupController(Eiu $eiu): Controller {
		return $eiu->lookup(DefaultImageController::class);	
	}
	
	/**
	 * {@inheritDoc}
	 * @see \rocket\ei\component\command\control\EntryGuiControlComponent::getEntryGuiControlOptions()
	 */
	public function getEntryGuiControlOptions(N2nContext $n2nContext, N2nLocale $n2nLocale): array {
		return array(self::CONTROL_KEY => 'Default');
	}
	
	public function createEntryGuiControls(Eiu $eiu): array {
		$hrefControls = array();
	
		$galleryImage = $eiu->entry()->getLiveEntry()->getEntityObj();
		CastUtils::assertTrue($galleryImage instanceof GalleryImage);
		
		$controlType = SiButton::TYPE_DEFAULT;
		
		if ($galleryImage->getGallery()->getDefaultGalleryImage() === $galleryImage) {
			$controlType = SiButton::TYPE_WARNING;
		}
		
		$dtc = new DynamicTextCollection('gallery', $view->getN2nLocale());
		
		$label = $dtc->t('common_edit_label');
		$tooltip = $dtc->t('ei_impl_edit_entry_tooltip', array('entry' => $eiu->frame()->getGenericLabel()));
		$hrefControls[] = HrefControl::create($eiu->frame()->getEiFrame(), $this, 
				(new Path(array($eiu->entry()->getLiveIdRep())))->toUrl(),
				new SiButton($label, $tooltip, true, $controlType, SiIconType::ICON_IMAGE));
		
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
