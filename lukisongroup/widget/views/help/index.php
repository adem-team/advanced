<?php
	use kartik\affix\Affix;
	$content ='Progress';
	$items = [	
		[
			'url' => '#Introduction-0',
			'label' => 'Enterprise Resource Planning.',
			'icon' => 'play-circle',
			//'content' => $introduction,
			'items' => [
				['url' => '#sec-0-1', 'label' => 'Introduction ERP', 'content' => $introduction],
				['url' => '#sec-0-2', 'label' => '', 'content' =>'--- END ---'],
			],
		],
		
		[
			'url' => '#Purchasing-1',
			'label' => 'Purchase Modul',
			'icon' => 'play-circle',
			'content' => '',
			'items' => [
				['url' => '#sec-1-1', 'label' => 'Buat PO', 'content' => $pur_penjelasan],
				['url' => '#sec-1-2', 'label' => 'Hak Akses', 'content' => $pur_permission],
				['url' => '#sec-1-3', 'label' => 'Request Order', 'content' => $ro_tutorial],
				['url' => '#sec-1-4', 'label' => 'Sales Order', 'content' => $so_tutorial],
				['url' => '#sec-1-5', 'label' => 'PO Normal', 'content' => $po_normal_tutorial],
				['url' => '#sec-1-6', 'label' => 'PO Plus', 'content' => $po_plus_tutorial],
			],
		],
		[
			'url' => '#sec-2',
			'label' => 'Data Master',
			'icon' => 'play-circle',
			'content' => $content,
			'items' => [
				['url' => '#sec-2-1', 'label' => 'Customer', 'content' => $customer],
				['url' => '#sec-2-2', 'label' => 'Product', 'content' => $product],
				['url' => '#sec-2-3', 'label' => 'Term', 'content' => $term],
				['url' => '#sec-2-4', 'label' => 'Section 2.4', 'content' => $content],
				['url' => '#sec-2-5', 'label' => 'Section 2.5', 'content' => $content],
			],
		],
		[
			'url' => '#Purchasing-1',
			'label' => 'Human Resource Management',
			'icon' => 'play-circle',
			'content' => '',
			'items' => [
				['url' => '#sec-1-1', 'label' => 'Penjelasan', 'content' => $hrm_penjelasan],
				['url' => '#sec-1-2', 'label' => 'Personalia', 'content' => $content],
				['url' => '#sec-1-3', 'label' => 'Rekrutmen', 'content' => $content],
				['url' => '#sec-1-4', 'label' => 'Absensi', 'content' => $content],
				['url' => '#sec-1-5', 'label' => 'Payroll', 'content' => $content],
				['url' => '#sec-1-6', 'label' => 'Modul HRM', 'content' => $content],
			],
		],
	];
?>	


<div class="content" style="font-family: verdana, arial, sans-serif ;font-size: 9pt";>
	<div class="row">
		<div class="col-md-12">
			<h4 class="text-center"><b>LUKISONGROUP GUIDEBOOK</b></h4>
			<hr/>			
		</div>
	</div>
	<div class="row">
		<div class="col-xs-0 col-md-3">			
			<?= Affix::widget([
				'items' => $items, 
				'type' => 'menu'
			]);?>		
		</div>	
		<div class="col-xs-12 col-md-9" style="font-family: verdana, arial, sans-serif ;font-size: 9pt";>
			<?= Affix::widget([
				'items' => $items, 
					'type' => 'body'
			]);?>
		</div>
	</div>
</div>
