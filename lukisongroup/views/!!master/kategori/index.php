<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->sideCorp = 'Master Data Umum';                  		/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                   		/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Kategori Barang');	    /* title pada header page */
?>

<div class="kategori-index">

	
<?php 
	$gridColumns = [
		['class' => 'yii\grid\SerialColumn'],

				'NM_KATEGORI',
				'NOTE:ntext',

				['class' => 'yii\grid\ActionColumn'],
	];

	echo Yii::$app->gv->grview($gridColumns,$dataProvider,$searchModel, 'Kategori', 'kategori','');//$this->title);
	
	/*
echo GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
	'pjax'=>true,
    'toolbar' => [
        '{export}',
    ],
	'panel' => [
		'heading'=>'<h3 class="panel-title">'. Html::encode($this->title).'</h3>',
		'type'=>'warning',
		'before'=>Html::a('<i class="fa fa-plus fa-fw"></i> Kategori', ['create'], ['class' => 'btn btn-warning']),
		'showFooter'=>false,
	],		
	
	'export' =>['target' => GridView::TARGET_BLANK],
	'exportConfig' => [
		GridView::PDF => [ 'filename' => 'Kategori-'.date('ymdHis') ],
		GridView::EXCEL => [ 'filename' => 'Kategori-'.date('ymdHis') ],
	],
]);
	*/
	
?>


</div>
