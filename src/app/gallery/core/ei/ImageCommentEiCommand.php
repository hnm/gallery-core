<?php
namespace gallery\core\ei;

use rocket\impl\ei\component\command\adapter\IndependentEiCommandAdapter;
use rocket\ei\util\Eiu;
use rocket\si\control\SiIconType;
use n2n\web\http\controller\Controller;
use rocket\si\control\SiButton;

class ImageCommentEiCommand extends IndependentEiCommandAdapter {
	const CONTROL_EDIT_KEY = 'image-comment';
	
	protected function prepare() {
	}
	
	public function getOverallControlOptions(\n2n\l10n\N2nLocale $n2nLocale) {
		return [self::CONTROL_KEY => 'Comment Images'];
	}

	public function createOverallControls(Eiu $eiu): array {
		$dtc = $eiu->dtc('gallery-core');
		$cb = new SiButton($dtc->t('comment_images_txt'));
		$cb->setIconType(SiIconType::COMMENT);
		
		return [$eiu->factory()->controls()->createJhtml($cb)];
	}

	/**
	 * {@inheritDoc}
	 * @see \rocket\ei\component\command\EiCommand::lookupController()
	 */
	public function lookupController(Eiu $eiu): Controller {
		return $eiu->lookup(ImageCommentController::class);
	}	
}