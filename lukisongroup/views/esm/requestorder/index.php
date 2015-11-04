
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use lukisongroup\models\hrd\Employe;
use lukisongroup\models\esm\ro\Requestorderstatus;
use lukisongroup\models\esm\ro\Rodetail;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\models\esm\ro\RequestorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Request Order';
$this->params['breadcrumbs'][] = $this->title;

$this->sideCorp = 'ESM Request Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_esm';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Permintaan Barang');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

?>


<!-- aside class="main-sidebar">
    < ?php
		/*variable Dropdown*/
		use lukisongroup\models\system\side_menu\M1000;
		use kartik\sidenav\SideNav;
		$side_menu=\yii\helpers\Json::decode(M1000::find()->findMenu('esm')->one()->jval);		
		if (!Yii::$app->user->isGuest) {
			echo SideNav::widget([
				'items' => $side_menu,
				'encodeLabels' => false,
				//'heading' => $heading,
				'type' => SideNav::TYPE_DEFAULT,
				'options' => ['class' => 'sidebar-nav'],
			]);
		};
    ?>
</aside -->

<div class="requestorder-index" style="padding:10px;">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>

    <?php 
	$empId = Yii::$app->user->identity->EMP_ID;
	$dt = Employe::find()->where(['EMP_ID'=>$empId])->all();
	$jbtan = $dt[0]['JOBGRADE_ID'];
	
	
	$gridColumns = [
		['class' => 'yii\grid\SerialColumn'],
		'KD_RO',
		'nmemp',
		'KD_CORP',
		
			[
				'format' => 'raw',
				'value' => function ($model) {
					$rodetail = new Rodetail();
					$dt = Rodetail::find()->where(['KD_RO'=>$model->KD_RO])->andWhere('STATUS <> 3')->count();
					$cn = Rodetail::find()->where(['KD_RO'=>$model->KD_RO, 'STATUS'=>1])->count();
					
					if ($model->STATUS == 1) {
						return Html::a('<i class="fa fa-check"></i> &nbsp;&nbsp;&nbsp;'.$cn.' Dari '.$dt, ['proses','kd'=>$model->KD_RO],['class'=>'btn btn-success btn-sm', 'title'=>'Detail']);
					} else if ($model->STATUS == 0) {
						return Html::a('<i class="fa fa-navicon"></i> &nbsp;&nbsp;&nbsp;&nbsp;Proses', ['proses','kd'=>$model->KD_RO],['class'=>'btn btn-danger btn-sm', 'title'=>'Detail']);
					} 
				},
			], 
			
		[
			'class' => 'yii\grid\ActionColumn',
			'template' => '{link} {edit} {delete} {cetak}',
			'buttons' => [
				'link' => function ($url,$model) { return Html::a('', ['view','kd'=>$model->KD_RO],['class'=>'fa fa-info-circle fa-lg', 'title'=>'Detail']);},
				'edit' => function ($url,$model) { return Html::a('', ['buatro','id'=>$model->KD_RO],['class'=>'fa fa-pencil-square-o fa-lg', 'title'=>'Ubah RO']); },
				'delete' => function ($url,$model) { if($model->STATUS == 0){ return Html::a('', ['hapusro','id'=>$model->KD_RO],['class'=>'fa fa-trash-o fa-lg', 'title'=>'Hapus RO','data-confirm'=>'Anda yakin ingin menghapus RO ini?']); } },
				'cetak' => function ($url,$model) { return Html::a('', ['cetakpdf','kd'=>$model->KD_RO],[ 'class'=>'fa fa-print fa-lg', 'target' => '_blank', 'title'=>'Cetak RO', 'data-pjax' => '0',]);},
			],
		],
	];
	
	/*
if($jbtan == 'MGR'){
} else { 
	$gridColumns = [
		['class' => 'yii\grid\SerialColumn'],
		'KD_RO',
		'nmemp',
		'KD_CORP',
		[
			'class' => 'yii\grid\ActionColumn',
			'template' => '{link} {edit} {delete} {cetak}',
			'buttons' => [
				'link' => function ($url,$model) { return Html::a('', ['view','kd'=>$model->KD_RO],['class'=>'fa fa-info-circle fa-lg', 'title'=>'Detail']);},
				'edit' => function ($url,$model) { return Html::a('', ['buatro','id'=>$model->KD_RO],['class'=>'fa fa-pencil-square-o fa-lg', 'title'=>'Ubah RO']); },
				'delete' => function ($url,$model) { return Html::a('', ['hapusro','id'=>$model->KD_RO],['class'=>'fa fa-trash-o fa-lg', 'title'=>'Hapus RO','data-confirm'=>'Anda yakin ingin menghapus RO ini?']); },
				'cetak' => function ($url,$model) { return Html::a('', ['cetakpdf','kd'=>$model->KD_RO],[ 'class'=>'fa fa-print fa-lg', 'target' => '_blank', 'title'=>'Cetak RO', 'data-pjax' => '0',]);},
			],
		],
	];
}	
	*/
	
		echo GridView::widget([
			'dataProvider'=> $dataProvider,
			'filterModel' => $searchModel,
			'columns' => $gridColumns,
			'rowOptions' => function ($model, $index, $widget, $grid) use($empId){
				
				$ro = new Requestorderstatus();
				$reqro = Requestorderstatus::find()->where(['KD_RO' => $model->KD_RO,'ID_USER' => $empId])->one();
				
				if(count($reqro) != 0){
					if($reqro->STATUS == 0){
						return ['class' => 'danger'];
					}else{
						return [];
					}
				}
			},			
			
			'pjax'=>true,
			'toolbar' => [
				'{export}',
			],
			'panel' => [
				'heading'=>'<h3 class="panel-title">'. Html::encode($this->title).'</h3>',
				'type'=>'warning',
				'before'=>Html::a('<i class="fa fa-plus fa-fw"></i> Permintaan Barang (RO)', ['create'], ['class' => 'btn btn-warning',
					'data' => [
						'confirm' => 'Anda yakin ingin membuat permintaan barang baru?',
						'method' => 'post',
					],
				]),
				'showFooter'=>false,
			],		
			
			'export' =>['target' => GridView::TARGET_BLANK],
			'exportConfig' => [
				GridView::PDF => [ 'filename' => 'permintaan-barang-'.date('ymdHis') ],
				GridView::EXCEL => [ 'filename' => 'permintaan-barang-'.date('ymdHis') ],
			],
		]);
		
	?>

</div>
