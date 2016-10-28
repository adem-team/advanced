<?php
use kartik\helpers\Html;	
use kartik\tabs\TabsX;
use ptrnov\fusionchart\Chart;
use ptrnov\fusionchart\ChartAsset;
use yii\helpers\Url;
ChartAsset::register($this);

$_indexSalesMdChart=$this->render('_indexSalesMdChart');
$_indexSalesMdIssue=$this->render('_indexSalesMdIssue',[
	'searchModelIssue' => $searchModelIssue,
	'dataProviderIssue' => $dataProviderIssue
]);	

$items=[
	[
		'label'=>'<i class="fa fa-area-chart fa-md"></i> Chart','content'=>$_indexSalesMdChart,
		'active'=>true,
	],					
	[
		'label'=>'<i class="fa fa-book fa-md"></i> Issue','content'=>$_indexSalesMdIssue,
	],
];

$tabSalesMd= TabsX::widget([
		'id'=>'id-tab-salesmd',
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		//'height'=>TabsX::SIZE_TINY,
		'height'=>'100%',
		//'height'=>'200%',
		'bordered'=>false,
		'encodeLabels'=>false,
		'align'=>TabsX::ALIGN_LEFT,						
	]);											
?>

<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt; padding-top:-150px">			
		<div class="row" >
			<?=$tabSalesMd?>
			
		</div>

</div>
