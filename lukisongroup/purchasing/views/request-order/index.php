
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
			$title1 = Yii::t('app', 'New');
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
	$icon = '<span class="glyphicon glyphicon-search"></span>';
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
				'class' => 'btn btn-default'
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

/*
 * Tombol Modul Edit -> Check By User login
 * Permission Edit [BTN_VIEW==1] & [Status 0=process 101=Approved]
 * EMP_ID=UserLogin & BTN_EDIT==1 &  Status 0 = Action Edit Show/bisa edit
 * EMP_ID=UserLogin & BTN_EDIT==1 &  Status 0 = Action Edit Hide/tidak bisa edit
 * 1. Hanya User login yang bisa melakukan Edit Request Order yang sudah di Create user tersebut (Tanpa Kecuali)
 * 2. Action EDIT Akan close atau tidak bisa di lakukan jika sudah Approved | status Approved =101 | Permission sign1
*/
function tombolEdit($url, $model){
	if(getPermission()->mdlpermission){								
		if(getPermission()->emp->EMP_ID == $model->ID_USER AND getPermission()->mdlpermission->BTN_EDIT==1){
			 if($model->STATUS == 0){ // 0=process 101=Approved
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
}

/*
 * Tombol Modul Delete -> Check By User login
 * Permission Edit [BTN_DELETE==1] & [Status 0=process 101=Approved]
 * EMP_ID=UserLogin & BTN_DELETE==1 &  Status 0 = Action Edit Show/bisa edit
 * EMP_ID=UserLogin & BTN_DELETE==1 &  Status 0 = Action Edit Hide/tidak bisa edit
 * 1. Hanya User login yang bisa melakukan DELETE Request Order yang sudah di Create user tersebut (Tanpa Kecuali)
 * 2. Action DELETE  Akan close atau tidak bisa di lakukan jika sudah Approved | status Approved =101 | Permission sign1
*/
function tombolDelete($url, $model){
	if(getPermission()->mdlpermission){
		if(getPermission()->emp->EMP_ID == $model->ID_USER AND getPermission()->mdlpermission->BTN_DELETE==1){
			if($model->STATUS == 0){ // 0=process 101=Approved
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
}	

/*
 * Tombol Modul Approval -> Check By User login
 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 101=Approved]
 * EMP_ID=UserLogin & BTN_SIGN1==1 &  Status 0 = Action Edit Show/bisa edit
 * EMP_ID=UserLogin & BTN_SIGN1==1 &  Status 0 = Action Edit Hide/tidak bisa edit
 * 1. Hanya User login dengan permission modul RO=1 dengan BTN_SIGN1==1 dan Permission Jabatan Manager keatas yang bisa melakukan Approval (Tanpa Kecuali)
 * 2. Action APPROVAL Akan close atau tidak bisa di lakukan jika sudah Approved | status Approved =101 | Permission sign1
*/
function tombolApproval($url, $model){
	if(getPermission()->mdlpermission){
		//Permission Jabatan
		if(getPermission()->emp->JOBGRADE_ID == 'M' OR getPermission()->emp->JOBGRADE_ID == 'SM' AND getPermission()->mdlpermission->BTN_SIGN1==1 ){
			 if($model->STATUS == 0){ // 0=process 101=Approved
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
}

/*
 * STATUS Prosess Request Order
 * 1. PROCESS	=0 		| Pertama RO di buat
 * 2. APPROVED	=101	| Ro Sudah Di Approved
 * 3. DELETE	=3 		| Ro Di hapus oleh pembuat petama, jika belum di Approved
 * 4. REJECT	=4		| Ro tidak di setujui oleh Atasan manager keatas
 * 5. UNKNOWN	<>		| Ro tidak valid
*/
function statusProcessRo($model){
	if($model->STATUS==0){
		return Html::a('<i class="glyphicon glyphicon-retweet"></i> PROCESS', '#',['class'=>'btn btn-warning btn-xs', 'style'=>['width'=>'100px'],'title'=>'Detail']);
	}elseif ($model->STATUS==101){
		return Html::a('<i class="glyphicon glyphicon-ok"></i> APPROVED', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
	}elseif ($model->STATUS==3){
		return Html::a('<i class="glyphicon glyphicon-remove"></i> DELETE', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);						
	}elseif ($model->STATUS==4){
		return Html::a('<i class="glyphicon glyphicon-thumbs-down"></i> REJECT', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
	}else{
		return Html::a('<i class="glyphicon glyphicon-question-sign"></i> UNKNOWN', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);	
	};		
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
									
							/* View RO | Permissian Status 0; 0=process | User created = user login  */
							'tambahEdit' => function ($url, $model) {
											return tombolEdit($url, $model);
										},										
							
							/* Delete RO | Permissian Status 0; 0=process | User created = user login */
							'delete' => function ($url, $model) {
											return tombolDelete($url, $model);
										},
							
							/* Approved RO | Permissian Status 0; 0=process | Dept = Dept login | GF >= M */
							'approved' => function ($url, $model) {
											return tombolApproval($url, $model);
										},
						],
						
					],								
					[
						'label'=>'Notification',
						'mergeHeader'=>true,
						'format' => 'raw',						
						'hAlign'=>'center',
						'value' => function ($model) {
										return statusProcessRo($model);
									}							
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
				'type'=>GridView::TYPE_DANGER,
				'heading'=>"List Request Order",
			],				
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
