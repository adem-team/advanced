
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
use kartik\tabs\TabsX;
use yii\widgets\ListView;
use yii\data\ArrayDataProvider;

use lukisongroup\purchasing\models\salesmanorder\SoDetailSearch;

use lukisongroup\purchasing\models\so\Sodetail;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\hrd\models\Employe;
use lukisongroup\hrd\models\Dept;

	/*
	 * Declaration Componen User Permission
	 * Function getPermissionInbox
	 * Modul Name[8=SO2]
	*/
	function getPermissionInbox(){
		if (Yii::$app->getUserOpt->Modul_akses(8)){
			return Yii::$app->getUserOpt->Modul_akses(8);
		}else{
			return false;
		}
	}

	$getPermissionInboxCheeck = getPermissionInbox();

	//print_r(getPermissionInbox());
	/*
	 * Declaration Componen User Permission
	 * Function profile_user
	*/
	function getPermissionInboxEmp(){
		if (Yii::$app->getUserOpt->profile_user()){
			return Yii::$app->getUserOpt->profile_user()->emp;
		}else{
			return false;
		}
	}
	//print_r(getPermissionInboxEmp());

	/*
	 * Tombol Modul Approval -> Check By User login
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 101=Approved]
	 * EMP_ID=UserLogin & BTN_SIGN1==1 &  Status 0 = Action Edit Show/bisa edit
	 * EMP_ID=UserLogin & BTN_SIGN1==1 &  Status 0 = Action Edit Hide/tidak bisa edit
	 * 1. Hanya User login dengan permission modul RO=1 dengan BTN_SIGN1==1 dan Permission Jabatan SVP keatas yang bisa melakukan Approval (Tanpa Kecuali)
	 * 2. Action APPROVAL Akan close atau tidak bisa di lakukan jika sudah Approved | status Approved =101 | Permission sign1
	*/
	function tombolReviewInbox($url, $model){
		//$kd=($model['KD_SO_HEADER']!='' AND $model['KD_SO_DETAIL']=='')?$model['KD_SO_HEADER']:($model['KD_SO_HEADER']!='' AND $model['KD_SO_DETAIL']!='')?$model['KD_SO_HEADER']:$model['KD_SO_DETAIL'];
		if(getPermissionInbox()){
			if(getPermissionInbox()->BTN_REVIEW)
			{
				// $kd=($model['KD_SO_HEADER']=='' AND $model['KD_SO_DETAIL']=='')?$model['ID']:($model['KD_SO_HEADER']!='' AND $model['KD_SO_DETAIL']=='')?$model['KD_SO_HEADER']:$model['KD_SO_HEADER'];
				// $kdstt=($model['KD_SO_HEADER']=='' AND $model['KD_SO_DETAIL']=='')!=''?0:1;
				$kd=($model['SOT_ID']!='' AND $model['SO_ID']=='')?$model['SOT_ID']:$model['SO_ID'];//($model['SOT_ID']=='' AND $model['SO_ID']!='')?$model['SO_ID']:$model['SO_ID'];
				$kdstt=$model['SOT_ID']==''?0:$model['SO_ID']==''?0:1;
				
				$title = Yii::t('app', 'Review');
				$options = [ 'id'=>'so-review-inbox'];
				$icon = '<span class="glyphicon glyphicon-ok"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/purchasing/salesman-order/review','id'=>$kd,'stt'=>$kdstt]);
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
			}
		}
	}

	/*
	 * STATUS FLOW DATA
	 * 1. NEW			= 0 	| SOT2 Create
	 * 2. VALIDATE  	= 101	| ADMIN PROCESS VALIDATE
	 * 3. APPROVED		= 102	| KAM APPROVED
	 * 4. FACTURE		= 103	| ACCOUNTING APPROVED |  Facture Generate (Invoice)
	 * 5. SURAT JALAN 	=104	| Surat Jalan.
	 * 6. Shiping		=105	| Warehouse.
	 * 7. SONE106		=106	| Finish.
	 * 4. REJECT		= 4		| Data tidak di setujui oleh manager atau Atasan  lain
	*/
	function statusProcessSot2($model){
		if($model['STT_PROCESS']==0){
			return Html::a('<i class="glyphicon glyphicon-time"></i> New', '',['class'=>'btn btn-info btn-xs', 'style'=>['width'=>'100px','text-align'=>'left'],'title'=>'New']);
		}elseif($model['STT_PROCESS']==101){
			return Html::a('<i class="glyphicon glyphicon-time"></i> Validate ', '',['class'=>'btn btn-warning btn-xs','style'=>['width'=>'100px','text-align'=>'left'], 'title'=>'Validate']);
		}elseif ($model['STT_PROCESS']==102){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> Approved', '',['class'=>'btn btn-warning btn-xs','style'=>['width'=>'100px','text-align'=>'left'], 'title'=>'Approved']);
		}elseif ($model['STT_PROCESS']==103){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> Invoice', '',['class'=>'btn btn-warning btn-xs','style'=>['width'=>'100px','text-align'=>'left'], 'title'=>'Detail']);
		}elseif($model['STT_PROCESS']==104){
			return Html::a('<i class="glyphicon glyphicon-time"></i> Shiping', '',['class'=>'btn btn-warning btn-xs', 'style'=>['width'=>'100px','text-align'=>'left'],'title'=>'Detail']);
		}elseif ($model['STT_PROCESS']==105){
			return Html::a('<i class="glyphicon glyphicon-time"></i> Finish', '',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px','text-align'=>'left'], 'title'=>'Detail']);
		}elseif ($model['STT_PROCESS']==4){
			return Html::a('<i class="glyphicon glyphicon-remove"></i> Reject', '',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px','text-align'=>'left'], 'title'=>'Detail']);
		};
	}

	$Combo_Dept = ArrayHelper::map(Dept::find()->orderBy('SORT')->asArray()->all(), 'DEP_NM','DEP_NM');
	

	$columnIndexInbox= [
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
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		[
			'class'=>'kartik\grid\ExpandRowColumn',
			'width'=>'50px',
			'header'=>'Detail',
			'value'=>function ($model, $key, $index, $column) {
				return GridView::ROW_COLLAPSED;
			},
			'detail'=>function ($model, $key, $index, $column){
				$searchModelDetailx = new SoDetailSearch([
					// 'TGL'=>$model['TGL'],
					'KODE_REF'=>$model['KODE_REF'],
					'CUST_KD'=>$model['CUST_KD'],
					'USER_ID'=>$model['USER_ID'],
				]);
				$aryProviderSoDetailInbox = $searchModelDetailx->searchDetail1(Yii::$app->request->queryParams);
				return Yii::$app->controller->renderPartial('_indexInboxExpand1',[
					'model'=>$model,
					'aryProviderSoDetailInbox2'=>$aryProviderSoDetailInbox,
					'searchModelDetailx'=>$searchModelDetailx
				]); 
			},
			'collapseTitle'=>'Close Exploler',
			'expandTitle'=>'Click to views detail',
			
			//'headerOptions'=>['class'=>'kartik-sheet-style'] ,
			// 'allowBatchToggle'=>true,
			'expandOneOnly'=>true,
			// 'enableRowClick'=>true,
			//'disabled'=>true,
			'headerOptions'=>[
				'style'=>[
					
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(74, 206, 231, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
				
					'text-align'=>'center',
					'width'=>'10px',
					'height'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*KD_RO*/
		[
			'attribute'=>'KODE_REF',
			'label'=>'Kode SO',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'filter'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'130px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'130px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*CREATE_AT Tanggal Pembuatan*/
		[
			'attribute'=>'TGL_INBOX',
			'label'=>'Create At',
			'hAlign'=>'left',
			'vAlign'=>'middle',			
			//'value'=>function($model){
				/*
				 * max String Disply
				 * @author ptrnov <piter@lukison.com>
				*/
			//	return substr($model->username, 0, 10);
			//},
			'filterType' => GridView::FILTER_DATE,
			'filterOptions'=>[
				'style'=>'id:test',
			 ],
            'filterWidgetOptions' => [					
				'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',					 
                    'autoclose' => true,
                    'todayHighlight' => true,
					//'format' => 'dd-mm-yyyy hh:mm',
					'autoWidget' => false,
					//'todayBtn' => true,
                ]
            ],	
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'90px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'90px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt'
				]
			],
		],
		/*CUSTOMER*/
		[
			'attribute'=>'CUST_NM',
			'label'=>'Customer',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'filterOptions'=>[
				'colspan'=>3,
			  ],
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'190px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'190px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*Chck.IN*/
		[
			'attribute'=>'CHECKIN_TIME',
			'label'=>'Time.In',
			'filter' => false,
			'hAlign'=>'left',
			'vAlign'=>'top',
			'mergeHeader'=>true,
			'value'=>function($model){
				return substr($model['CHECKIN_TIME'], 8, 8);
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*Chck.OUT*/
		[
			'attribute'=>'CHECKOUT_TIME',
			'label'=>'Time.Out',
			'filter' => false,
			'hAlign'=>'left',
			'vAlign'=>'top',
			'mergeHeader'=>true,
			'value'=>function($model){
				return substr($model['CHECKOUT_TIME'], 8, 8);
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*DIBUAT*/
		[
			'attribute'=>'NM_FIRST',
			'label'=>'Created',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'120px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'120px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
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
					'width'=>'120px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'120px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*DISETUJUI*/
		[
			'attribute'=>'SIG3_NM',
			'label'=>'Approved',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'120px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'120px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*Action*/
		[
			'class'=>'kartik\grid\ActionColumn',
			'dropdown' => true,
			'template' => '{view}{tambahEdit}{delete}{review}{closed}',
			'dropdownOptions'=>['class'=>'pull-right dropup'],
			//'headerOptions'=>['class'=>'kartik-sheet-style'],
			'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
			'buttons' => [
				/* View RO | Permissian All */
				'view' => function ($url, $model) {
								//return tombolViewInbox($url, $model);
						  },

				/* View RO | Permissian Status 0; 0=process | User created = user login  */
				'tambahEdit' => function ($url, $model) {
								//return tombolEditInbox($url, $model);
							},

				/* Delete RO | Permissian Status 0; 0=process | User created = user login */
				'delete' => function ($url, $model) {
								//return tombolDeleteInbox($url, $model);
							},

				/* Approved RO | Permissian Status 0; 0=process | Dept = Dept login | GF >= M */
				'review' => function ($url, $model) {
								return tombolReviewInbox($url, $model);
							},
				 'closed' => function ($url, $model) use ($getPermissionInboxCheeck){
								if ($getPermissionInboxCheeck['BTN_VIEW']==0) {
									return Html::label('<i class="glyphicon glyphicon-lock dm"></i> LOCKED','',['class'=>'label label-danger','style'=>['align'=>'center']]);
									//return  tombolKonci($url, $model);
								}
							},

			],
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'140px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'140px',
					'height'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		[
			'attribute'=>'STT_PROCESS',
			'label'=>'Notification',
			'mergeHeader'=>true,
			'format' => 'raw',
			'hAlign'=>'center',
			'value' => function ($model) {
							return statusProcessSot2($model);
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'130px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'130px',
					'height'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],

	];

	
	
	/*
	 * INBOX SALESAN ORDER - MD Sales
	 * ACTION CHECKED or APPROVED
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	$_gvInboxSo= GridView::widget([
		'id'=>'gv-so-md-inbox',
		'dataProvider'=> $apSoHeaderInbox,
		'filterModel' => $searchModelHeader,
		'filterRowOptions'=>['style'=>'background-color:rgba(214, 255, 138, 1); align:center'],
		'columns' =>$columnIndexInbox,		
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-so-md-inbox',
			   ],
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
		'toolbar'=> ['',
				//['content'=>''],
				//'{export}',
				//'{toggleData}',
				
			],
		'panel'=>[
			'type'=>GridView::TYPE_INFO, //rgba(214, 255, 138, 1)
			'heading'=>"<span class='fa fa-cart-plus fa-xs'><b> LIST SALES ORDER</b></span>",
			'before'=>false
		],
	]);
	?>


	<?php

	
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#confirm-permission-alert-so').on('show.bs.modal', function (event) {
				//var button = $(event.relatedTarget)
				//var modal = $(this)
				//var title = button.data('title')
				//var href = button.attr('href')
				//modal.find('.modal-title').html(title)
				//modal.find('.modal-body').html('')
				/* $.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)
					}); */
				}),
	",$this::POS_READY);
	Modal::begin([
			'id' => 'confirm-permission-alert-so',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/warning/denied.png',  ['class' => 'pnjg', 'style'=>'width:40px;height:40px;']).'</div><div style="margin-top:10px;"><h4><b>Permmission Confirm !</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
			]
		]);
		echo "<div>You do not have permission for this module.
				<dl>
					<dt>Contact : itdept@lukison.com</dt>
				</dl>
			</div>";
	Modal::end();

		$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#new-so').on('show.bs.modal', function (event) {
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
			'id' => 'new-so',
			//'header' => '<h4 class="modal-title">Entry Request Order</h4>',
			'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Entry Items Sales Order</h4></div>',
			'size' => 'modal-md',
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
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
				'style'=> 'border-radius:5px; background-color:rgba(97, 211, 96, 0.3);'
			]
		]);
		Modal::end();

		$this->registerJs("
			/* $(document).on('click', '[data-toggle-reviewinbox1]', function(e){
				e.preventDefault();
				var id = $(this).data('toggle-reviewinbox');
				$.ajax({
					url: '/purchasing/salesman-order/review',
					type: 'POST',
					data:'kd='+id,
					dataType: 'json',
					success: function(response) {
						console.log('sukses');						
					}					
				});
			}); */
		",$this::POS_READY);

	?>
<?=$_gvInboxSo?>
