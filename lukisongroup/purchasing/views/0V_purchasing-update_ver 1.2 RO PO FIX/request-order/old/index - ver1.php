
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Json;
use lukisongroup\master\models\Unitbarang;
use kartik\daterange\DateRangePicker;

use lukisongroup\hrd\models\Employe;
use lukisongroup\purchasing\models\Requestorderstatus;
use lukisongroup\purchasing\models\Rodetail;

$this->title = 'Request Order';
$this->params['breadcrumbs'][] = $this->title;

$this->sideCorp = 'ESM Request Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_esm';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'List Permintaan Barang');      /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;               /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


/*
 * Declaration Componen User Permission
 * Function getPermission
 * Modul Name[1=RO]
*/
function getPermission(){
	return Yii::$app->getUserOpt->Modul_akses(1); 
}

/*
 * Tombol Modul Create
 * permission crate Ro
*/
function tombolCreate(){
	if(getPermission()->mdlpermission){
		if(getPermission()->mdlpermission->BTN_CREATE==1){
			$title1 = Yii::t('app', 'approved');
			$options1 = [ 'id'=>'ro-create',	
						  'data-toggle'=>"modal",
						  'data-target'=>"#new-ro",											
						  'class' => 'btn btn-warning',												  
						//'data-confirm'=>'Anda yakin ingin menghapus RO ini?',
			]; 
			$icon1 = '<span class="fa fa-plus fa-lg"></span>';
			$label1 = $icon1 . ' ' . $title1;
			$url1 = Url::toRoute(['/purchasing/request-order/create']);
			//$options1['tabindex'] = '-1';
			$content = Html::a($label1,$url1, $options1);
			return $content;								
		}else{
			$title1 = Yii::t('app', 'approved');
			$options1 = [ 'id'=>'ro-create',						  									
						  'class' => 'btn btn-warning',										  
						  'data-confirm'=>'Anda yakin ingin menghapus RO ini?',
			]; 
			$icon1 = '<span class="fa fa-plus fa-lg"></span>';
			$label1 = $icon1 . ' ' . $title1;
			$url1 = Url::toRoute(['/purchasing/request-order/create']);
			//$options1['tabindex'] = '-1';
			$content = Html::a($label1,$url1, $options1);
			return $content;
		}
	}		
}

/*
 * Tombol Modul Barang
 * No Permission
*/
function tombolBarang(){
	$title = Yii::t('app', 'Barang');
	$options = ['id'=>'ro-barang',	
				'data-toggle'=>"modal",
				'data-target'=>"#check-barang",							
				'class' => 'btn btn-default'
	]; 
	$icon = '<span class="fa fa-plus fa-lg"></span>';
	$label = $icon . ' ' . $title;
	$url = Url::toRoute(['/purchasing/request-order/create']);
	$content = Html::a($label,$url, $options);
	return $content;		
}

/*
 * Tombol Modul Barang Kategori
 * No Permission
*/
function tombolKategori(){
	$title = Yii::t('app', 'Kategori');
	$options = ['id'=>'ro-kategori',	
				'data-toggle'=>"modal",
				'data-target'=>"#check-kategori",							
				'class' => 'btn btn-success'
	]; 
	$icon = '<span class="glyphicon glyphicon-search"></span>';
	$label = $icon . ' ' . $title;
	$url = Url::toRoute(['/purchasing/request-order/create']);
	$content = Html::a($label,$url, $options);
	return $content;		
}


/*
 * Tombol Modul View
 * permission View [BTN_VIEW==1]
 * Check By User login
*/
function tombolView($url, $model){
	if(getPermission()->mdlpermission){	
		if(getPermission()->mdlpermission->BTN_VIEW==1){
			$title = Yii::t('app', 'View');
			$options = [ 'id'=>'ro-view']; 
			$icon = '<span class="glyphicon glyphicon-zoom-in"></span>';
			$label = $icon . ' ' . $title;
			$url = Url::toRoute(['/purchasing/request-order/view','kd'=>$model->KD_RO]);
			$options['tabindex'] = '-1';
			return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;	
		}
	}
} 


		
?>

<div class="" style="padding:10px;">
	<?php 		
		echo GridView::widget([
			'id'=>'ro-grd-index',
			'dataProvider'=> $dataProvider,
			'filterModel' => $searchModel,
			/* 
				'beforeHeader'=>[
					[
						'columns'=>[
							['content'=>'List Permintaan Barang & Jasa', 'options'=>['colspan'=>4, 'class'=>'text-center success']], 
							['content'=>'Action Status ', 'options'=>['colspan'=>6, 'class'=>'text-center warning']], 
						],
						'options'=>['class'=>'skip-export'] // remove this row from export
					]
				], 
			*/
			'columns' => [
					[
						'class'=>'kartik\grid\SerialColumn',
						'contentOptions'=>['class'=>'kartik-sheet-style'],
						'width'=>'20px',
						'header'=>'No.',
						'headerOptions'=>['class'=>'kartik-sheet-style']
					],							 
					[
						'attribute'=>'KD_RO',
						//'mergeHeader'=>true,
						'hAlign'=>'left',
						'vAlign'=>'middle',
						'group'=>true
					],
					[
						'label'=>'Tanggal Pembuatan',
						'attribute'=>'CREATED_AT',
						'hAlign'=>'left',
						'vAlign'=>'middle',
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
						])
					],													
					[
						'label'=>'Pengajuan',
						'group'=>true,
						'attribute'=>'EMP_NM',
						'hAlign'=>'left',
						'vAlign'=>'middle'							
					],					 
					[
						'class'=>'kartik\grid\ActionColumn',
						'dropdown' => true,
						'template' => '{view}{tambahEdit}{delete}{approved}',
						'dropdownOptions'=>['class'=>'pull-right'],									
						'headerOptions'=>['class'=>'kartik-sheet-style'],											
						'buttons' => [
							/* View RO | Permissian All */
							'view' => function ($url, $model) {
										return tombolView($url, $model);
									  },
									/* function ($url, $model) {	
									$profile=Yii::$app->getUserOpt->Modul_akses(1); //Modul Name[1=RO]
									if($profile->mdlpermission){	
										if($profile->mdlpermission->BTN_VIEW==1){
											$title = Yii::t('app', 'View');
											$options = [ 'id'=>'ro-view']; 
											$icon = '<span class="glyphicon glyphicon-zoom-in"></span>';
											$label = $icon . ' ' . $title;
											$url = Url::toRoute(['/purchasing/request-order/view','kd'=>$model->KD_RO]);
											$options['tabindex'] = '-1';
											return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;	
										}
									} */
							//},
							
							/* View RO | Permissian Status 0; 0=process | User created = user login  */
							'tambahEdit' => function ($url, $model) {
										//$profile=Yii::$app->getUserOpt->Profile_user();	/*user/employe Login Val*/	
										$profile=Yii::$app->getUserOpt->Modul_akses(1); //Modul Name[1=RO]
										if($profile->mdlpermission){								
											if($profile->emp->EMP_ID == $model->ID_USER AND $profile->mdlpermission->BTN_EDIT==1){
												 if($model->STATUS == 0){ // 0=process 1=Approved
													$title = Yii::t('app', 'Edit Detail');
													$options = [ 'id'=>'ro-edit',
																'data-toggle'=>"modal",
																'data-target'=>"#add-ro",
																//'data-confirm'=>'Anda yakin ingin menghapus RO ini?',
													]; 
													$icon = '<span class="fa fa-pencil-square-o fa-lg"></span>';
													$label = $icon . ' ' . $title;
													$url = Url::toRoute(['/purchasing/request-order/tambah','kd'=>$model->KD_RO]);
													$options['tabindex'] = '-1';
													return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
												}
											}
										}
							},
							
							/* Delete RO | Permissian Status 0; 0=process | User created = user login */
							'delete' => function ($url, $model) {
										//$profile=Yii::$app->getUserOpt->Profile_user();	/*user/employe Login Val*/	
										$profile=Yii::$app->getUserOpt->Modul_akses(1); //Modul Name[1=RO]
										if($profile->mdlpermission){
											if($profile->emp->EMP_ID == $model->ID_USER AND $profile->mdlpermission->BTN_DELETE==1){
												if($model->STATUS == 0){ // 0=process 1=Approved
													$title = Yii::t('app', 'Delete');
													$options = [ 'id'=>'ro-delete',															
																'data-confirm'=>'Anda yakin ingin menghapus RO ini?',
													]; 
													$icon = '<span class="fa fa-trash-o fa-lg"></span>';
													$label = $icon . ' ' . $title;
													$url = Url::toRoute(['/purchasing/request-order/hapusro','kd'=>$model->KD_RO]);
													$options['tabindex'] = '-1';
													return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
												}
											}
										}
							},
							
							/* Approved RO | Permissian Status 0; 0=process | Dept = Dept login | GF >= M */
							'approved' => function ($url, $model) {
										//$profile=Yii::$app->getUserOpt->Profile_user();
										$profile=Yii::$app->getUserOpt->Modul_akses(1); //Modul Name[1=RO]
										if($profile->mdlpermission){
											//Permission Jabatan
											if($profile->emp->JOBGRADE_ID == 'M' OR $profile->emp->JOBGRADE_ID == 'SM' AND $profile->mdlpermission->BTN_SIGN1==1 ){
												 if($model->STATUS == 0){ // 0=process 1=Approved
													$title = Yii::t('app', 'approved');
													$options = [ 'id'=>'ro-approved',															
																//'data-confirm'=>'Anda yakin ingin menghapus RO ini?',
													]; 
													$icon = '<span class="glyphicon glyphicon-ok"></span>';
													$label = $icon . ' ' . $title;
													$url = Url::toRoute(['/purchasing/request-order/proses','kd'=>$model->KD_RO]);
													$options['tabindex'] = '-1';
													return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
												}
											}
										}
							},
						],
						
					],								
					[
						'label'=>'Notify',
						'mergeHeader'=>true,
						'format' => 'raw',						
						'hAlign'=>'center',
						'value' => function ($model) {
							//$rodetail = new Rodetail();
							$dt = Rodetail::find()->where(['KD_RO'=>$model->KD_RO])->andWhere('STATUS <> 3')->count(); //ptr.nov Count RO
							$cn = Rodetail::find()->where(['KD_RO'=>$model->KD_RO, 'STATUS'=>1])->count(); //ptr.nov Count RO Disetujui
							$profile=Yii::$app->getUserOpt->Profile_user();			
							if ($model->STATUS == 0) {
								return Html::label('<i class="fa fa-navicon"></i>&nbsp;Proses','',['class'=>'btn btn-warning btn-xs', 'title'=>'Detail']);
							} else if ($model->STATUS == 101) {
								return Html::label('<i class="fa fa-check"></i> &nbsp;'.$cn.' Dari '.$dt,'',['class'=>'btn btn-success btn-xs', 'title'=>'Detail']);
							}								
						},
					], 							
					
			],			
			'pjax'=>true,
			'pjaxSettings'=>[
				'options'=>[
					'enablePushState'=>false,
					'id'=>'ro-grd-index',
				   ],						  
			],
			'hover'=>true, //cursor select
			'responsive'=>true,
			'responsiveWrap'=>true,
			'bordered'=>true,
			'striped'=>'4px',
			'autoXlFormat'=>true,
			'export' => false,					
			'toolbar'=> [
					['content'=>tombolCreate().tombolBarang().tombolKategori()],
					//'{export}',
					'{toggleData}',
				],
			'panel'=>[
				'type'=>GridView::TYPE_PRIMARY,
				'heading'=>"Request Order",
			],	
			
			/* 'export' =>['target' => GridView::TARGET_BLANK],
			'exportConfig' => [
				GridView::PDF => [ 'filename' => 'permintaan-barang-'.date('ymdHis') ],
				GridView::EXCEL => [ 'filename' => 'permintaan-barang-'.date('ymdHis') ],
			],
			
			'options'=>['enableRowClick'=>true] */
		]);				
	?>
</div>

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
