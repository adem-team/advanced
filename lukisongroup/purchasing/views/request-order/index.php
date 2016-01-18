
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Json;
use yii\web\Request;
use kartik\daterange\DateRangePicker;

use lukisongroup\purchasing\models\ro\Requestorderstatus;
use lukisongroup\purchasing\models\ro\Rodetail;

use lukisongroup\master\models\Unitbarang;
use lukisongroup\hrd\models\Employe;
use lukisongroup\hrd\models\Dept;


$this->title = 'Request Order';
$this->params['breadcrumbs'][] = $this->title;

$this->sideCorp = 'Request Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'mdefault';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
//$this->title = Yii::t('app', 'List Permintaan Barang');      /* title pada header page */
//$this->params['breadcrumbs'][] = $this->title;               /* belum di gunakan karena sudah ada list sidemenu, on plan next*/
	
	/*
	 * Declaration Componen User Permission
	 * Function getPermission
	 * Modul Name[1=RO]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses(1)){
			return Yii::$app->getUserOpt->Modul_akses(1);
		}else{		
			return false;
		}	 
	}
	//print_r(getPermission());
	/*
	 * Declaration Componen User Permission
	 * Function profile_user
	*/
	function getPermissionEmp(){
		if (Yii::$app->getUserOpt->profile_user()){
			return Yii::$app->getUserOpt->profile_user()->emp;
		}else{		
			return false;
		}	 
	}
	//print_r(getPermissionEmp());
	
	/*
	 * Tombol Modul Create
	 * permission crate Ro
	*/
	function tombolCreate(){
		if(getPermission()){
			if(getPermission()->BTN_CREATE==1){
				$title1 = Yii::t('app', 'New');
				$options1 = [ 'id'=>'ro-create',	
							  'data-toggle'=>"modal",
							  'data-target'=>"#new-ro",											
							  'class' => 'btn btn-warning btn-xs',
				]; 
				$icon1 = '<span class="fa fa-plus fa-xs"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['/purchasing/request-order/create']);
				//$options1['tabindex'] = '-1';
				$content = Html::a($label1,$url1, $options1);
				return $content;								
			}else{
				$title1 = Yii::t('app', 'New');
				$options1 = [ 'id'=>'ro-create',						  									
							  'class' => 'btn btn-warning',										  
							  'data-confirm'=>'Permission Failed !',
				]; 
				$icon1 = '<span class="fa fa-plus fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['#']);
				//$options1['tabindex'] = '-1';
				$content = Html::a($label1,$url1, $options1);
				return $content;
			}; 
		}else{
				$title1 = Yii::t('app', 'New');
				$options1 = [ 'id'=>'ro-create',						  									
							  'class' => 'btn btn-warning',										  
							  'data-confirm'=>'Permission Failed !',
				]; 
				$icon1 = '<span class="fa fa-plus fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['#']);
				//$options1['tabindex'] = '-1';
				$content = Html::a($label1,$url1, $options1);
				return $content;
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
				'data-target'=>"#check-barang ",							
				'class' => 'btn btn-default  btn-xs'
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
				'class' => 'btn btn-default  btn-xs'
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
		if(getPermission()){	
			if(getPermission()->BTN_VIEW==1){
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
		if(getPermission()){								
			if(getPermissionEmp()->EMP_ID == $model->ID_USER AND getPermission()->BTN_EDIT==1){
				 if($model->STATUS == 0){ // 0=process 101=Approved
					$title = Yii::t('app', 'Edit Detail');
					$options = [ //'id'=>'ro-edit',
								//'data-toggle'=>"modal",
								//'data-target'=>"#add-ro",
								//'data-confirm'=>'Anda yakin ingin menghapus RO ini?',
					]; 
					$icon = '<span class="fa fa-pencil-square-o fa-lg"></span>';
					$label = $icon . ' ' . $title;
					$url = Url::toRoute(['/purchasing/request-order/edit','kd'=>$model->KD_RO]);
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
		if(getPermission()){
			if(getPermissionEmp()->EMP_ID == $model->ID_USER AND getPermission()->BTN_DELETE==1){
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
	 * 1. Hanya User login dengan permission modul RO=1 dengan BTN_SIGN1==1 dan Permission Jabatan SVP keatas yang bisa melakukan Approval (Tanpa Kecuali)
	 * 2. Action APPROVAL Akan close atau tidak bisa di lakukan jika sudah Approved | status Approved =101 | Permission sign1
	*/
	function tombolReview($url, $model){
		if(getPermission()){
			//Permission Jabatan
			$a=getPermissionEmp()->JOBGRADE_ID;
			$b=getPermission()->BTN_SIGN1;
			//if(getPermissionEmp()->JOBGRADE_ID == 'S' OR getPermissionEmp()->JOBGRADE_ID == 'M' OR getPermissionEmp()->JOBGRADE_ID == 'SM' AND getPermission()->BTN_SIGN1==1 ){
			if($a == 'SEVP' OR $a == 'EVP' OR $a == 'SVP' OR $a == 'VP' OR $a == 'AVP' OR $a == 'SM' OR $a == 'M' OR $a == 'AM' OR $a == 'S' AND $b==1 ){
				 if($model->STATUS == 0 || $model->STATUS == 1 ){ // 0=process 101=Approved
					$title = Yii::t('app', 'Review');
					$options = [ //'id'=>'ro-approved',
								//'data-method' => 'post',
								 //'data-pjax'=>true,
								 //'data'=>$model->KD_RO,
								 //'data-pjax' => '0',
								 //'data-toggle-active' => $model->KD_RO
								//'data-confirm'=>'Anda yakin ingin menghapus RO ini?',
					]; 
					$icon = '<span class="glyphicon glyphicon-ok"></span>';
					$label = $icon . ' ' . $title;
					$url = Url::toRoute(['/purchasing/request-order/review','kd'=>$model->KD_RO]);
					$options['tabindex'] = '-1';
					return '<li>' . Html::a($label, $url , $options) . '</li>' . PHP_EOL;
				}
			}
		}	
	}
	
	//Pjax::end();
	/*
	 * STATUS Prosess Request Order
	 * 1. PROCESS	=0 		| Pertama RO di buat
	 * 2. PENDING	=1		| Ro Tertunda
	 * 3. APPROVED	=101	| Ro Sudah Di Approved
	 * 4. COMPLETED	=10		| Ro Sudah selesai | RO->PO->RCVD
	 * 5. DELETE	=3 		| Ro Di hapus oleh pembuat petama, jika belum di Approved
	 * 6. REJECT	=4		| Ro tidak di setujui oleh Atasan manager keatas
	 * 7. UNKNOWN	<>		| Ro tidak valid
	*/
	function statusProcessRo($model){
		if($model->STATUS==0){
			return Html::a('<i class="glyphicon glyphicon-retweet"></i> PROCESS', '#',['class'=>'btn btn-warning btn-xs', 'style'=>['width'=>'100px'],'title'=>'Detail']);
		}elseif ($model->STATUS==1){
			return Html::a('<i class="glyphicon glyphicon-time"></i> PENDING', '#',['class'=>'btn btn-warning btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==101){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> APPROVED', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==10){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> COMPLETED', '#',['class'=>'btn btn-info btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==3){
			return Html::a('<i class="glyphicon glyphicon-remove"></i> DELETE', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);						
		}elseif ($model->STATUS==4){
			return Html::a('<i class="glyphicon glyphicon-thumbs-down"></i> REJECT', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}else{
			return Html::a('<i class="glyphicon glyphicon-question-sign"></i> UNKNOWN', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);	
		};		
	}

$Combo_Dept = ArrayHelper::map(Dept::find()->orderBy('SORT')->asArray()->all(), 'DEP_NM','DEP_NM');
?>
<div style="padding:10px;">
	
	<?php 		
		echo GridView::widget([
			'id'=>'ro-grd-index',
			'dataProvider'=> $dataProvider,
			'filterModel' => $searchModel,
			'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.3); align:center'],
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
					/*No Urut*/
					[
						'class'=>'kartik\grid\SerialColumn',
						'contentOptions'=>['class'=>'kartik-sheet-style'],
						'width'=>'10px',
						'header'=>'No.',
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'10px',
								'font-family'=>'verdana, arial, sans-serif',
								'font-size'=>'9pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>'center',
								'width'=>'10px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
							]
						], 		
					],
					/*KD_RO*/
					[
						'attribute'=>'KD_RO',
						'label'=>'Kode SO',
						'hAlign'=>'left',
						'vAlign'=>'middle',
						//'group'=>true,
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'130px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>'left',
								'width'=>'130px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
							]
						], 		
					],
					/*CREATE_AT Tanggal Pembuatan*/
					[
						'attribute'=>'CREATED_AT',
						'label'=>'Create At',
						'hAlign'=>'left',			
						'vAlign'=>'middle',
						'value'=>function($model){
							/*
							 * max String Disply
							 * @author ptrnov <piter@lukison.com>
							*/
							return substr($model->CREATED_AT, 0, 10);
						},
						'filterType'=> \kartik\grid\GridView::FILTER_DATE_RANGE,
									'filterWidgetOptions' =>([
										'attribute' =>'CREATED_AT',
										'presetDropdown'=>TRUE,
										'convertFormat'=>true,
										'pluginOptions'=>[
											'id'=>'tglpo',
											'format'=>'Y/m/d',
											'separator' => ' - ',
											'opens'=>'right'
										]									
						]),
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'90px',
								'font-family'=>'verdana, arial, sans-serif',
								'font-size'=>'9pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>'left',
								'width'=>'90px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt'	
							]
						], 		
					],	
					/*Department*/	
					[
						'attribute'=>'dept.DEP_NM',
						'label'=>'Department',
						'filter' => $Combo_Dept,
						'hAlign'=>'left',
						'vAlign'=>'middle',
						//'group'=>true,
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'200px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>'left',
								'width'=>'200px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
							]
						], 		
					],					
					/*DIBUAT*/	
					[
						'attribute'=>'SIG1_NM',
						'label'=>'Created',
						'hAlign'=>'left',
						'vAlign'=>'middle',
						//'group'=>true,
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'130px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>'left',
								'width'=>'130px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
							]
						], 		
					],					
					/*DIPERIKSA*/	
					[
						'attribute'=>'SIG2_NM',
						'label'=>'Checked',
						'hAlign'=>'left',
						'vAlign'=>'middle',
						//'group'=>true,
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'130px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>'left',
								'width'=>'130px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
							]
						], 		
					],
					/*DISETUJUI*/	
					[
						'attribute'=>'SIG2_NM',
						'label'=>'Approved',
						'hAlign'=>'left',
						'vAlign'=>'middle',
						//'group'=>true,
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'130px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>'left',
								'width'=>'130px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
							]
						], 		
					],					
					[
						'class'=>'kartik\grid\ActionColumn',
						'dropdown' => true,
						'template' => '{view}{tambahEdit}{delete}{review}',
						'dropdownOptions'=>['class'=>'pull-right dropup'],									
						//'headerOptions'=>['class'=>'kartik-sheet-style'],											
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
							'review' => function ($url, $model) {
											return tombolReview($url, $model);
										},
						],
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'150px',
								'font-family'=>'verdana, arial, sans-serif',
								'font-size'=>'9pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>'center',
								'width'=>'150px',
								'height'=>'10px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
							]
						],
					],								
					[
						'label'=>'Notification',
						'mergeHeader'=>true,
						'format' => 'raw',						
						'hAlign'=>'center',
						'value' => function ($model) {
										return statusProcessRo($model);
						},
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'150px',
								'font-family'=>'verdana, arial, sans-serif',
								'font-size'=>'9pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>'center',
								'width'=>'150px',
								'height'=>'10px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
							]
						],							
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
				'heading'=>"<span class='fa fa-cart-arrow-down fa-md'><b> LIST REQUEST ORDER</b></span>",
			],				
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
			//'header' => '<h4 class="modal-title">Entry Request Order</h4>',
			'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Entry Request Order</h4></div>',
			'size' => 'modal-md',
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(131, 160, 245, 0.5)',
			]
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
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1);'
			]
		]);
		Modal::end();
		
		$this->registerJs("
			$(document).on('click', '[data-toggle-active]', function(e){
			e.preventDefault();

			var id = $(this).data('toggle-active');

			$.ajax({
				url: '/purchasing/request-order/approved&id=' + id,
				type: 'POST',
				success: function(result) {

					if (result == 1)
					{
						// Success
						$.pjax.reload({container:'#grid-pjax'});
					} else {
						// Fail
					}
				}
				});

			});
		",$this::POS_READY);
		 
	?>
</div>