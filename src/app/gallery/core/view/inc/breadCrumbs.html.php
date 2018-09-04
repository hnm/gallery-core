<?php
	use gallery\core\model\GalleryState;
	use n2n\impl\web\ui\view\html\HtmlView;
	use n2n\reflection\CastUtils;
	use gallery\core\model\Breadcrumb;
	
	$view = HtmlView::view($this);
	$html = HtmlView::html($view);

	$galleryState = $view->lookup(GalleryState::class);
	$view->assert($galleryState instanceof GalleryState);
	
	$breadCrumbs = $galleryState->getBreadcrumbs($view->getN2nLocale());
	if (empty($breadCrumbs)) return;
?>
<ol class="breadcrumb">
	<?php foreach($breadCrumbs as $breadCrumb): CastUtils::assertTrue($breadCrumb instanceof Breadcrumb) ?>
  		<li class="breadcrumb-item<?php $html->out($breadCrumb->isActive() ? ' active' : '') ?>">
  			<?php if ($breadCrumb->isActive()): ?>
  				<?php $html->out($breadCrumb->getLabel()) ?>
  			<?php else: ?>
	  			<?php $html->link($breadCrumb->getUrl(), $breadCrumb->getLabel()) ?>
  			<?php endif ?>
  		</li>
	<?php endforeach ?>
</ol>