<?php
	use n2n\impl\web\ui\view\html\HtmlView;
	use n2n\core\N2N;
	
	$view = HtmlView::view($view);
	$html = HtmlView::html($view);
?>
<!doctype html>
<html class="no-js" lang="<?php $html->out($view->getN2nLocale()->getLanguageId()) ?>">
	<?php $html->headStart() ?>
		<!-- internet page created by hnm.ch -->
		<meta charset="<?php $html->out(N2N::CHARSET) ?>" />
	<?php $html->headEnd() ?>
	<?php $html->bodyStart() ?>
		<?php $view->importContentView() ?>
	<?php $html->bodyEnd() ?>
</html>