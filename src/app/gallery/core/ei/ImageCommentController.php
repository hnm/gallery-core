<?php
namespace gallery\core\ei;

use n2n\web\http\controller\ControllerAdapter;
use rocket\ei\util\EiuCtrl;
use n2n\web\dispatch\Dispatchable;
use n2n\reflection\annotation\AnnoInit;
use n2n\web\dispatch\annotation\AnnoDispObjectArray;
use rocket\ei\util\entry\form\EiuEntryForm;
use n2n\web\dispatch\map\bind\BindingDefinition;

class ImageCommentController extends ControllerAdapter {
	
	public function index(EiuCtrl $eiuCtrl) {
		$eiuFrame = $eiuCtrl->eiu()->frame();
		$eiuEntries = $eiuFrame->lookupEntries();
		
		$commentForm = new CommentForm();
		foreach ($eiuEntries as $eiuEntry) {
			$commentForm->eiuEntryForms[] = $eiuEntry->newEntryForm();
		}
		
		if ($this->dispatch($commentForm, 'save')) {
			$eiuCtrl->redirectToOverview();
			return;
		}
		
		$this->forward('imageComment.html', ['commentForm' => $commentForm]);
	}
}

class CommentForm implements Dispatchable {
	private static function _annos(AnnoInit $ai) {
		$ai->p('eiuEntryForms', new AnnoDispObjectArray());
	}
	
	/**
	 * @var EiuEntryForm[]
	 */
	public $eiuEntryForms = [];
	
	private function _validation(BindingDefinition $bd) {
	}
	
	public function save() {
		$result = true;
		
		foreach ($this->eiuEntryForms as $eiuEntryForm) {
			if (!$eiuEntryForm->buildEiuEntry()->getEiEntry()->validate()) {
				$result = false;
			}
		}
		
		if (!$result) return false;
		
		foreach ($this->eiuEntryForms as $eiuEntryForm) {
			$eiuEntryForm->buildEiuEntry()->getEiEntry()->save();
		}
	}
}
