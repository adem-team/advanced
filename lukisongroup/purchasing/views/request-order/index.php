
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use lukisongroup\master\models\Unitbarang;


use lukisongroup\hrd\models\Employe;
use lukisongroup\purchasing\models\Requestorderstatus;
use lukisongroup\purchasing\models\Rodetail;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\models\esm\ro\RequestorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Request Order';
$this->params['breadcrumbs'][] = $this->title;

$this->sideCorp = 'ESM Request Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_esm';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'List Permintaan Barang');         	 /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;               /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


//$empId = Yii::$app->user->identity->EMP_ID;
			/* $dt = Employe::find()->where(['EMP_ID'=>$empId])->all();
			$jbtan = $dt[0]['JOBGRADE_ID'];		 */	
			$gridColumns = [
				[
					'attribute'=>'parentro.KD_RO',
					//'mergeHeader'=>true,
					'group'=>true,
				],
				[
					'label'=>'Tanggal Pembuatan',
					'attribute'=>'parentro.CREATED_AT',
					//'mergeHeader'=>true,
					'group'=>true,
				],				
				[
					'label'=>'Nama Barang',
					'attribute'=>'NM_BARANG',
					//'mergeHeader'=>true,
				],
				[
					'label'=>'Jumlah Permintaan',
					'attribute'=>'RQTY',
					//'mergeHeader'=>true,
				],
				[
					'attribute'=>'UNIT',
					'value'=>function ($model, $key, $index, $widget) { 
						$masterUnit = Unitbarang::find()->where(['KD_UNIT'=>$model->UNIT])->one();
						return $masterUnit->NM_UNIT;
					},
				],
				
				[
					'format' => 'raw',
					'mergeHeader'=>true,
					'hAlign'=>'center',
					'value' => function ($model) {
						//$rodetail = new Rodetail();
						$dt = Rodetail::find()->where(['KD_RO'=>$model->KD_RO])->andWhere('STATUS <> 3')->count(); //ptr.nov Count RO
						$cn = Rodetail::find()->where(['KD_RO'=>$model->KD_RO, 'STATUS'=>1])->count(); //ptr.nov Count RO Disetujui
						
						if ($model->STATUS == 1) {
							return Html::a('<i class="fa fa-check"></i> &nbsp;&nbsp;&nbsp;'.$cn.' Dari '.$dt, ['proses','kd'=>$model->KD_RO],['class'=>'btn btn-success btn-sm', 'title'=>'Detail']);
						} else if ($model->STATUS == 0) {
							return Html::a('<i class="fa fa-navicon"></i> &nbsp;&nbsp;&nbsp;&nbsp;Proses', ['proses','kd'=>$model->KD_RO],['class'=>'btn btn-danger btn-sm', 'title'=>'Detail']);
						} 
					},
				],  
				[
					'class' => 'yii\grid\ActionColumn',
					'template' => '{tambah} {link} {edit} {delete} {cetak}',
					'buttons' => [
						'tambah' => function ($url,$model) { return Html::a('', ['add','kd'=>$model->KD_RO],['class'=>'fa fa-plus fa-fw', 'title'=>'Add']);},
						'link' => function ($url,$model) { return Html::a('', ['view','kd'=>$model->KD_RO],['class'=>'fa fa-info-circle fa-lg', 'title'=>'Detail']);},
						'edit' => function ($url,$model) { return Html::a('', ['buatro','id'=>$model->KD_RO],['class'=>'fa fa-pencil-square-o fa-lg', 'title'=>'Ubah RO']); },
						'delete' => function ($url,$model) { if($model->STATUS == 0){ return Html::a('', ['hapusro','id'=>$model->KD_RO],['class'=>'fa fa-trash-o fa-lg', 'title'=>'Hapus RO','data-confirm'=>'Anda yakin ingin menghapus RO ini?']); } },
						'cetak' => function ($url,$model) { return Html::a('', ['cetakpdf','kd'=>$model->KD_RO],[ 'class'=>'fa fa-print fa-lg', 'target' => '_blank', 'title'=>'Cetak RO', 'data-pjax' => '0',]);},
				],
		],	
				
			];

?>

<div class="" style="padding:10px;>
	

			<h1><?php // Html::encode($this->title) ?></h1>
			<hr/>

			<?php 		
				echo GridView::widget([
					'dataProvider'=> $dataProvider,
					//'filterModel' => $searchModel,
					'columns' => $gridColumns,
					/* 'rowOptions' => function ($model, $index, $widget, $grid) use($empId){
						
						$ro = new Requestorderstatus();
						$reqro = Requestorderstatus::find()->where(['KD_RO' => $model->KD_RO,'ID_USER' => $empId])->one();
						
						if(count($reqro) != 0){
							if($reqro->STATUS == 0){
								return ['class' => 'danger'];
							}else{
								return [];
							}
						}
					},			 */
					
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
					
					'options'=>['enableRowClick'=>true],
				]);
				
			?>

	
</div>