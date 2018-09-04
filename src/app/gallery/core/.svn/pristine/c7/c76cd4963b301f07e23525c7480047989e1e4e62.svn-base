<?php
	use gallery\core\bo\Gallery;
	use gallery\core\bo\GalleryGroup;
	use gallery\core\model\GalleryState;
	use n2n\impl\web\ui\view\html\HtmlView;
	use n2n\web\http\nav\Murl;
	
	$view = HtmlView::view($this);
	$html = HtmlView::html($view);
	$request = HtmlView::request($view);
	
	$galleryState = $view->lookup(GalleryState::class);
	$view->assert($galleryState instanceof GalleryState);
	
	$galleryConfig = $galleryState->getGalleryConfig();
	
	$galleryGroupT = null;
	if ($galleryState->hasCurrentGalleryGroup()) {
		$galleryGroup = $galleryState->getCurrentGalleryGroup();
		$galleryGroupT = $galleryGroup->t($view->getN2nLocale());
	}
	
	$this->useTemplate($galleryConfig->getTemplateViewId(), 
			array('title' => $galleryState->getTitle($view->getN2nLocale())));
?>
<?php $view->import($galleryConfig->getBreadCrumbsViewId()) ?>

<?php if ($galleryState->hasCurrentGalleryGroup()): ?>
	<?php if (null !== ($introText = $galleryGroupT->getIntro())): ?>
		<p class="gallery-lead">
			<?php $html->escBr($galleryGroupT->getIntro()) ?>
		</p>
	<?php endif ?>
	<ul class="gallery-list-unstyled">
		<?php foreach ($galleryState->getChildGalleryGroups() as $key => $childGalleryGroup): $childGalleryGroup instanceof GalleryGroup ?>
			<?php $childGalleryGroupT = $childGalleryGroup->t($view->getN2nLocale()) ?>
			<li>
				<?php $introText = $childGalleryGroupT->getIntro() ?>
				<?php $html->linkToController(array($childGalleryGroupT->getPathPart()), 
						$childGalleryGroupT->getTitle()) ?><?php $html->out($introText ? ':' : '') ?>
				<?php $html->out($introText)?>
			</li>
		<?php endforeach ?>
	</ul>
<?php endif ?>

<?php foreach ($galleryState->getChildGalleries() as $key => $gallery): $gallery instanceof Gallery ?>
	<?php $galleryT = $gallery->t($view->getN2nLocale()) ?>
	<div class="gallery">
		<div class="gallery-title-image-holder">
			<div class="gallery-title-image">
				<?php $html->linkToController($galleryState->getDetailPaths($view->getN2nLocale(), $gallery), 
						$html->getImage($galleryT->determineTitleImage(), null, array('class' => 'img-fluid'), false, false)) ?>
			</div>
		</div>
		<div class="gallery-image-info">
			<h2>
				<?php $html->linkStart(Murl::controller()->pathExt($galleryState->getDetailPaths($view->getN2nLocale(), $gallery))) ?>
					<?php $html->out($galleryT->getName()) ?>
				<?php $html->linkEnd() ?>
			</h2>
			<?php if (null !== ($description = $galleryT->getDescription())): ?>
				<p><?php $html->out($description) ?></p>
			<?php endif ?>
			<?php $html->linkToController($galleryState->getDetailPaths($view->getN2nLocale(), $gallery), $html->getText('gallery_link_label'), array('class' => 'btn btn-primary'))?>
		</div>
	</div>
<?php endforeach ?>
