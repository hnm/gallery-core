<?php
	use n2n\impl\web\ui\view\html\HtmlView;
	use gallery\core\ei\CommentForm;
	use rocket\ei\util\entry\form\EiuEntryForm;
	use n2n\impl\web\dispatch\ui\Form;
	use n2n\web\ui\Raw;
	use rocket\ei\util\gui\EiuHtmlBuilder;

	$view = HtmlView::view($this);
	$html = HtmlView::html($this);
	$formHtml = HtmlView::formHtml($this);
	$request = HtmlView::request($this);
	$eiuHtml = new EiuHtmlBuilder($view);
	
	$view->useTemplate('\rocket\core\view\template.html', 
			array('title' => $view->getL10nText('comment_images_txt')));
	
	$commentForm = $view->getParam('commentForm');
	$view->assert($commentForm instanceof CommentForm);
?>

<?php $formHtml->open($commentForm, Form::ENCTYPE_MULTIPART, null, array('class' => 'rocket-form')) ?>
	
	<?php $formHtml->meta()->arrayProps('eiuEntryForms', function () use ($view, $html, $formHtml, $eiuHtml) { ?>
		<?php $eiuEntryForm = $formHtml->meta()->getMapValue()->getObject() ?>
		<?php $view->assert($eiuEntryForm instanceof EiuEntryForm) ?>
		<?php $eiuEntryGui = $eiuEntryForm->getChosenEiuEntryTypeForm()->getEiuEntryGui() ?>
		<?php $eiuEntry = $eiuEntryGui->getEiuEntry() ?>
		
		<?php $eiuHtml->entryOpen('div', $eiuEntryGui, ['class' => 'rocket-group rocket-simple-group']) ?>
			<label><?php $html->text('image_txt', ['num' => $formHtml->meta()->getArrayKey() + 1 . '.']) ?></label>
			
			<div class="rocket-control row">
				<div class="col-md-3">
					<?php $html->image($eiuEntry->getValue('fileImage'), null, ['class' => 'img-fluid']) ?>
				</div>
				<div class="col-md-9">
					<?php $view->out($eiuEntryForm->setContextPropertyPath($formHtml->meta()->propPath())
								->createView($view, false)) ?>
				</div>
			</div>
		<?php $eiuHtml->entryClose() ?>
	<?php }) ?>
	
	<div class="rocket-zone-commands">
		<div class="rocket-main-commands">
			<?php $formHtml->buttonSubmit('save', 
					new Raw('<i class="fa fa-save"></i><span>' 
							. $html->getL10nText('common_save_and_back_label', null, null, null, 'rocket') . '</span>'), 
					array('class' => 'btn btn-primary rocket-important')) ?>
		</div>
	</div>
	
<?php $formHtml->close() ?>