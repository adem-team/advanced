<?php
	use kartik\affix\Affix;
	$content = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.';
	$items = [[
		'url' => '#sec-1',
		'label' => 'Section 1',
		'icon' => 'play-circle',
		'content' => $content,
		'items' => [
			['url' => '#sec-1-1', 'label' => 'Section 1.1', 'content' => $content],
			['url' => '#sec-1-2', 'label' => 'Section 1.2', 'content' => $content],
			['url' => '#sec-1-3', 'label' => 'Section 1.3', 'content' => $content],
			['url' => '#sec-1-4', 'label' => 'Section 1.4', 'content' => $content],
			['url' => '#sec-1-5', 'label' => 'Section 1.5', 'content' => $content],
		],
	],
	[
		'url' => '#sec-2',
		'label' => 'Section 2',
		'icon' => 'play-circle',
		'content' => $content,
		'items' => [
			['url' => '#sec-2-1', 'label' => 'Section 2.1', 'content' => $content],
			['url' => '#sec-2-2', 'label' => 'Section 2.2', 'content' => $content],
			['url' => '#sec-2-3', 'label' => 'Section 2.3', 'content' => $content],
			['url' => '#sec-2-4', 'label' => 'Section 2.4', 'content' => $content],
			['url' => '#sec-2-5', 'label' => 'Section 2.5', 'content' => $content],
		],
	]];
	
	
	
?>	


<div class="content" style="font-family: verdana, arial, sans-serif ;font-size: 9pt";>

	<div class="row">
		<div class="col-xs-12 col-md-3">			
			<?= Affix::widget([
				'items' => $items, 
				'type' => 'menu'
			]);?>		
		</div>	
		<div class="col-xs-12 col-md-9">
			<?= Affix::widget([
				'items' => $items, 
				'type' => 'body'
			]);?>
		</div>
	</div>
</div>
