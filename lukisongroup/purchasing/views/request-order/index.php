
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

use lukisongroup\master\models\Unitbarang;
use kartik\daterange\DateRangePicker;

use lukisongroup\hrd\models\Employe;
use lukisongroup\purchasing\models\Requestorderstatus;
use lukisongroup\purchasing\models\Rodetail;
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

			
?>

<div class="" style="padding:10px;>
	

			<h1><?php // Html::encode($this->title) ?></h1>
			<hr/>

			<?php 		
				echo GridView::widget([
					'id'=>'ro',
					'dataProvider'=> $dataProvider,
					'filterModel' => $searchModel,
					'beforeHeader'=>[
						[
							'columns'=>[
								['content'=>'Request Order', 'options'=>['colspan'=>2, 'class'=>'text-center success']], 
								['content'=>'List Request Order', 'options'=>['colspan'=>6, 'class'=>'text-center warning']], 
							],
							'options'=>['class'=>'skip-export'] // remove this row from export
						]
					],
					'columns' => [
							[
								'class' => 'yii\grid\SerialColumn'
							],
							[
								'label'=>'Status',
								'format' => 'raw',
								'mergeHeader'=>true,
								'hAlign'=>'center',
								'value' => function ($model) {
									//$rodetail = new Rodetail();
									$dt = Rodetail::find()->where(['KD_RO'=>$model->KD_RO])->andWhere('STATUS <> 3')->count(); //ptr.nov Count RO
									$cn = Rodetail::find()->where(['KD_RO'=>$model->KD_RO, 'STATUS'=>1])->count(); //ptr.nov Count RO Disetujui
									$profile=Yii::$app->getUserOpt->Profile_user();			
									if ($model->STATUS == 1) {											
										return Html::a('<i class="fa fa-check"></i> &nbsp;&nbsp;&nbsp;'.$cn.' Dari '.$dt, ['proses','kd'=>$model->KD_RO],['class'=>'btn btn-success btn-sm', 'title'=>'Detail']);
									} else if ($model->STATUS == 0) {
										if($profile->emp->JOBGRADE_ID == 'M' OR $profile->emp->JOBGRADE_ID == 'SM' ){
											return Html::a('<i class="fa fa-navicon"></i> &nbsp;&nbsp;&nbsp;&nbsp;Proses', ['proses','kd'=>$model->KD_RO],['class'=>'btn btn-danger btn-sm', 'title'=>'Detail']);
										}else{
											return Html::a('<i class="fa fa-navicon"></i> &nbsp;&nbsp;&nbsp;&nbsp;Proses', ['#'],['class'=>'btn btn-danger btn-sm', 'title'=>'Detail','data-confirm'=>'Permission Confirm !, Contact your Leader?']);
										}
									} 
								},
							],  
							[
								'attribute'=>'KD_RO',
								//'mergeHeader'=>true,
								'group'=>true,
							],
							[
								'label'=>'Tanggal Pembuatan',
								'attribute'=>'CREATED_AT',
								//'mergeHeader'=>true,
								'group'=>true,								
								'filterType'=> \kartik\grid\GridView::FILTER_DATE_RANGE,
								'filterWidgetOptions' =>([
									'attribute' =>'parentro.CREATED_AT',
									'presetDropdown'=>TRUE,
									'convertFormat'=>true,
									'pluginOptions'=>[
										'id'=>'tglro',
										'format'=>'Y/m/d',
										'separator' => 'TO',
										'opens'=>'left'
									]									
								]),
							],			
												
							[
								'label'=>'CREATED_BY',
								'attribute'=>'EMP_NM'
							],							
							[
								'header'=>'Action',	
								'class' =>'yii\grid\ActionColumn',
								'template' => '{tambah} {link} {edit} {cetak} {delete}',
								'buttons' => [									
									'tambah' => function ($url,$model) { 
												return  Html::a('<i class="fa fa-plus fa-lg"></i> ','/purchasing/request-order/tambah?kd='. $model->KD_RO,[
																'data-toggle'=>"modal",
																'data-target'=>"#add-ro"						
														]);
									},
									'link' => function ($url,$model) { 
												return Html::a('', ['view','kd'=>$model->KD_RO],['class'=>'fa fa-info-circle fa-lg', 'title'=>'Detail']);
											},
									//'edit' => function ($url,$model) { return Html::a('', ['buatro','id'=>$model->KD_RO],['class'=>'fa fa-pencil-square-o fa-lg', 'title'=>'Ubah RO']); },
									'cetak' => function ($url,$model) {
											    return Html::a('', ['cetakpdf','kd'=>$model->KD_RO],[ 'class'=>'fa fa-print fa-lg', 'target' => '_blank', 'title'=>'Cetak RO', 'data-pjax' => '0',]);
											},
									'delete' => function ($url,$model) { 
													if($model->STATUS == 0){ 
														return Html::a('', ['hapusro','id'=>$model->KD_RO],['class'=>'fa fa-trash-o fa-lg', 'title'=>'Hapus RO','data-confirm'=>'Anda yakin ingin menghapus RO ini?']); 
													} 
												},
								],
							],	
							
					],
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
					'pjaxSettings'=>[
						'options'=>[
							'enablePushState'=>false,
							'id'=>'ro',
						   ],						  
					],
					'hover'=>true, //cursor select
					'responsive'=>true,
					'responsiveWrap'=>true,
					'bordered'=>true,
					'striped'=>'4px',
					'autoXlFormat'=>true,
					'export' => false,
					/* 'toolbar' => [
						'{export}',
					], */
					'panel' => [
						'heading'=>'<h3 class="panel-title">'. Html::encode($this->title).'</h3>',
						'type'=>'warning',
						/* 'before'=>Html::a('<i class="fa fa-plus fa-fw"></i> Permintaan Barang (RO)', ['create'], ['class' => 'btn btn-warning',
							'data' => [
								'confirm' => 'Anda yakin ingin membuat permintaan barang baru?',
								'method' => 'post',
							], */
						'before'=> Html::a('<i class="fa fa-plus fa-lg"></i> '.Yii::t('app', 'Permintaan Barang (RO)',
						['modelClass' => 'customer',]),'/purchasing/request-order/create',[
							'data-toggle'=>"modal",
								'data-target'=>"#new-ro",							
									'class' => 'btn btn-warning'						
												]),					
						'showFooter'=>false,
					],		
					
					/* 'export' =>['target' => GridView::TARGET_BLANK],
					'exportConfig' => [
						GridView::PDF => [ 'filename' => 'permintaan-barang-'.date('ymdHis') ],
						GridView::EXCEL => [ 'filename' => 'permintaan-barang-'.date('ymdHis') ],
					],
					
					'options'=>['enableRowClick'=>true] */
				]);				
			?>

	<?php
		$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
			$('#new-ro').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title') 
				var href = button.attr('href') 
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)					
					});
				}),			
		",$this::POS_READY);
		
		Modal::begin([
			'id' => 'new-ro',
			'header' => '<h4 class="modal-title">Entry Request Order</h4>',
			'size' => 'modal-md',
		]);
		Modal::end();
		
		$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
			$('#add-ro').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title') 
				var href = button.attr('href') 
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)					
					});
				}),			
		",$this::POS_READY);
		
		Modal::begin([
			'id' => 'add-ro',
			'header' => '<h4 class="modal-title">Entry Request Order</h4>',
			'size' => 'modal-lg',
		]);
		Modal::end();
	
	?>
</div>