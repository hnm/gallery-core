<?php
namespace gallery\core\ei;

use rocket\impl\ei\component\command\IndependentEiCommandAdapter;
use rocket\ei\component\command\control\OverallControlComponent;
use rocket\ei\util\Eiu;
use n2n\impl\web\ui\view\html\HtmlView;
use rocket\ei\manage\control\ControlButton;
use rocket\ei\manage\control\IconType;
use n2n\web\http\controller\Controller;

class ImageCommentEiCommand extends IndependentEiCommandAdapter implements OverallControlComponent {
	const CONTROL_KEY = 'image-comment';
	
	public function getOverallControlOptions(\n2n\l10n\N2nLocale $n2nLocale) {
		return [self::CONTROL_KEY => 'Comment Images'];
	}

	/**
	 * {@inheritDoc}
	 * @see \rocket\ei\component\command\control\OverallControlComponent::createOverallControls()
	 */
	public function createOverallControls(Eiu $eiu, HtmlView $view): array {
		$dtc = $eiu->dtc('gallery-core');
		$cb = new ControlButton($dtc->t('comment_images_txt'));
		$cb->setIconType(IconType::ICON_COMMENT);
		
		return [$eiu->frame()->controlFactory($this)->createJhtml($cb)];
	}

	/**
	 * {@inheritDoc}
	 * @see \rocket\ei\component\command\EiCommand::lookupController()
	 */
	public function lookupController(Eiu $eiu): Controller {
		return $eiu->lookup(ImageCommentController::class);
	}

	/**
	 * {@inheritDoc}
	 * @see \rocket\ei\component\IndependentEiComponent::__construct()
	 */
	public function __construct() {
		// TODO Auto-generated method stub
		
	}

	
}