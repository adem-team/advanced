<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'lukisongroup';


use kartik\affix\Affix;
	$content ='Progress';
	$items = [
		[
			'url' => '#cara-install-1',
			'label' => 'CARA INSTALL APLIKASI',
			'icon' => 'play-circle',
			'content' => '',
			'items' => [
				['url' => '#sec-1-1', 'label' => 'PENJELASAN', 'content' => $penjelasan],
				['url' => '#sec-1-1', 'label' => 'DOWNLOAD APLIKASI', 'content' => $linkDownload],
				['url' => '#sec-1-2', 'label' => 'CARA INSTALL', 'content' => $installapp]
			],
		],
	];
?>


<div class="content">
	<div class="content">				
		 <div class="row">
			<div class="col-md-12">						
				<h4 class="page-head-line">DOWNLOAD APLIKASI</h4>				
				<div  class="col-md-3 col-lg-3">					
					<div>			
						<?= Affix::widget([
							'items' => $items, 
							'type' => 'menu'
						]);?>		
					</div>	
				</div>
				<div  class="col-md-9 col-sm-9 col-lg-9 ">
					<?php
						//echo $this->render('doc');
					?>
				</div>
					
					<div class="col-xs-12 col-md-6" style="font-family: verdana, arial, sans-serif ;font-size: 9pt";>
						<?= Affix::widget([
							'items' => $items, 
								'type' => 'body'
						]);?>
					</div>
				</div>
			
		</div>				 	
	</div>				
</div>
