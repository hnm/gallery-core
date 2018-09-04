<?php
	use gallery\core\model\GalleryState;
	use gallery\core\bo\GalleryImage;
	use n2n\impl\web\ui\view\html\HtmlView;
	
	$view = HtmlView::view($this);
	$html = HtmlView::html($view);
	$request = HtmlView::request($view);
	
	$galleryState = $view->lookup(GalleryState::class);
	$view->assert($galleryState instanceof GalleryState);
	
	$galleryConfig = $galleryState->getGalleryConfig();
	
	$gallery = $view->getParam('gallery', false);
	if (null === $gallery) {
		$gallery = $galleryState->getCurrentGallery();
	}
	$galleryT = $gallery->t($view->getN2nLocale());
	
	$meta = $html->meta();
	$useTemplate = $view->getParam('useTemplate', false, true);
	
	if ($useTemplate) {
		$view->useTemplate($galleryConfig->getTemplateViewId());
	}
?>
<?php if ($galleryState->hasCurrentGalleryGroup()): ?>
	<?php $view->import($galleryConfig->getBreadCrumbsViewId()) ?>
<?php elseif ($galleryState->hasRootUrl()): ?>
	<?php $html->linkToController(null, 'zurück') ?>
<?php endif ?>

<p class="gallery-lead">
	<?php $html->out($galleryT->getDescription()) ?>
</p>

<div class="gallery-image-container">
	<?php foreach ($gallery->getGalleryImages() as $galleryImage): $galleryImage instanceof  GalleryImage ?>
		<?php $galleryImageT = $galleryImage->t($view->getN2nLocale()) ?>
		<figure class="gallery-image-box">
			<div class="gallery-img-container">
				<?php $html->image($galleryImage->getFileImage(), null, 
						array('class' => 'img-fluid', 'title' => $galleryImageT ? $galleryImageT->getTitle() : null, 'alt' => $galleryImageT ? $galleryImageT->determineAltTag() : null)) ?>
			</div>
		</figure>
	<?php endforeach ?>
</div>