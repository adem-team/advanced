
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
	 * Function getPermission
	 * Modul Name[8=SO2]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses(8)){
			return Yii::$app->getUserOpt->Modul_akses(8);
		}else{
			return false;
		}
	}

	$getPermissionCheeck = getPermission();

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
				$options1 = [ 'id'=>'so-create',
							  'data-toggle'=>"modal",
							  'data-target'=>"#new-so",
							  'class' => 'btn btn-warning  btn-xs',
				];
				$icon1 = '<span class="fa fa-plus fa-xs"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['/purchasing/sales-order/create']);
				//$options1['tabindex'] = '-1';
				$content = Html::a($label1,$url1, $options1);
				return $content;
			}else{
				$title1 = Yii::t('app', 'New');
				$options1 = [ 'id'=>'so-create',
							  'class' => 'btn btn-warning btn-xs',
								'data-toggle'=>"modal",
							  'data-target'=>"#confirm-permission-alert-so",
				];
				$icon1 = '<span class="fa fa-plus fa-xs"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['#']);
				//$options1['tabindex'] = '-1';
				$content = Html::a($label1,$url1, $options1);
				return $content;
			};
		}else{
				$title1 = Yii::t('app', 'New');
				$options1 = [ 'id'=>'so-create',
							  'class' => 'btn btn-warning  btn-xs',
								'data-toggle'=>"modal",
								'data-target'=>"#confirm-permission-alert-so",
				];
				$icon1 = '<span class="fa fa-plus fa-xs"></span>';
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
				'data-target'=>"#check-barang",
				'class' => 'btn btn-default  btn-xs'
	];
	$icon = '<span class="glyphicon glyphicon-search"></span>';
	$label = $icon . ' ' . $title;
	$url = Url::toRoute(['/purchasing/sales-order/create']);
	$content = Html::a($label,$url, $options);
	return $content;
}



function tombolCreateSom()
{
	if(getPermission()->BTN_CREATE && getPermission()->BTN_PROCESS1 ){
		$options = [ 'id'=>'som-id-create',
				'data-toggle'=>"modal",
				'data-target'=>"#sales-modal-id",
				'class' => 'btn btn-primary  btn-xs'
	];
	$url = Url::toRoute(['/purchasing/salesman-order/create-sales']);
}else{
	$options = [ 'id'=>'som-id-create',
				'data-toggle'=>"modal",
				'data-target'=>"#confirm-permission-alert",
				'class' => 'btn btn-primary  btn-xs'
	];
	$url = Url::toRoute(['#']);

}
	$title = Yii::t('app', 'CREATE MANUAL SO');
	// $options = [ 'id'=>'som-id-create',
	// 			'data-toggle'=>"modal",
	// 			'data-target'=>"#sales-modal-id",
	// 			'class' => 'btn btn-primary  btn-xs'
	// ];
	$options;
	$icon = '<span class="fa fa-plus fa-xs"></span>';
	$label = $icon . ' ' . $title;
	// $url = Url::toRoute(['/purchasing/salesman-order/create-sales']);
	$url;
	$options['tabindex'] = '-1';
	return  Html::a($label, $url, $options);
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
	$url = Url::toRoute(['/purchasing/sales-order/create']);
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
				$url = Url::toRoute(['/purchasing/sales-order/view','kd'=>$model->KD_RO]);
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
			}
		}
	}

	/*
	 * Tombol Modul Edit -> Check By User login
	 * Permission Edit [BTN_VIEW==1] & [Status 0=process 103=Approved]
	 * EMP_ID=UserLogin & BTN_EDIT==1 &  Status 0 = Action Edit Show/bisa edit
	 * EMP_ID=UserLogin & BTN_EDIT==1 &  Status 0 = Action Edit Hide/tidak bisa edit
	 * 1. Hanya User login yang bisa melakukan Edit Request Order yang sudah di Create user tersebut (Tanpa Kecuali)
	 * 2. Action EDIT Akan close atau tidak bisa di lakukan jika sudah Approved | status Approved =103 | Permission sign1
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
					$url = Url::toRoute(['/purchasing/sales-order/edit','kd'=>$model->KD_RO]);
					$options['tabindex'] = '-1';
					return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
				}
			}
		}
	}

	/*
	 * Tombol Modul Delete -> Check By User login
	 * Permission Edit [BTN_DELETE==1] & [Status 0=process 103=Approved]
	 * EMP_ID=UserLogin & BTN_DELETE==1 &  Status 0 = Action Edit Show/bisa edit
	 * EMP_ID=UserLogin & BTN_DELETE==1 &  Status 0 = Action Edit Hide/tidak bisa edit
	 * 1. Hanya User login yang bisa melakukan DELETE Request Order yang sudah di Create user tersebut (Tanpa Kecuali)
	 * 2. Action DELETE  Akan close atau tidak bisa di lakukan jika sudah Approved | status Approved =103 | Permission sign1
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
					$url = Url::toRoute(['/purchasing/sales-order/hapusro','kd'=>$model->KD_RO]);
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
	function tombolReviewOutbox($url, $model){
		// if(getPermission()){
		// 	/* GF_ID>=4 Group Function[Director|GM|M|S] */
		// 	$gF=getPermissionEmp()->GF_ID;
		// 	$Auth2=getPermission()->BTN_SIGN2; // Auth2
		// 	$Auth3=getPermission()->BTN_SIGN3; // Auth3
		// 	$BtnReview=getPermission()->BTN_REVIEW;
		// 	if ((($Auth2==1 or $Auth3==1) AND $gF<=4 AND $BtnReview=1) OR (getPermissionEmp()->EMP_ID ==$model->USER_CC)){
		// 		$title = Yii::t('app', 'Review');
		// 		$options = [ //'id'=>'ro-approved',
		// 					//'data-method' => 'post',
		// 					 //'data-pjax'=>true,
		// 					 //'data'=>$model->KD_RO,
		// 					 //'data-pjax' => '0',
		// 					 //'data-toggle-active' => $model->KD_RO
		// 					//'data-confirm'=>'Anda yakin ingin menghapus RO ini?',
		// 		];
		// 		$icon = '<span class="glyphicon glyphicon-ok"></span>';
		// 		$label = $icon . ' ' . $title;
		// 		$url = Url::toRoute(['/purchasing/sales-order/review','kd'=>$model->KD_RO]);
		// 		//$url = Url::toRoute(['/purchasing/sales-order/approved']);
		// 		//$url = Url::toRoute(['/purchasing/sales-order/approved']);
		// 		$options['tabindex'] = '-1';
		// 		return '<li>' . Html::a($label, $url , $options) . '</li>' . PHP_EOL;
		// 	}

		if(getPermission()){
			if(getPermission()->BTN_REVIEW && $model['STT_PROCESS'] == 0)
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
			}elseif(getPermission()->BTN_REVIEW && getPermission()->BTN_SIGN2 && $model['STT_PROCESS'] == 101){
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

			}elseif(getPermission()->BTN_REVIEW && getPermission()->BTN_SIGN3 && $model['STT_PROCESS'] == 102){
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
		// }
	}

$Combo_Dept = ArrayHelper::map(Dept::find()->orderBy('SORT')->asArray()->all(), 'DEP_NM','DEP_NM');
?>
	<?php
	$columnIndexOutbox= [
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
				$searchModelDetail = new SoDetailSearch([
					'KODE_REF'=>$model['KODE_REF'],
					'CUST_KD'=>$model['CUST_KD'],
					'USER_ID'=>$model['USER_ID'],
				]);
				$aryProviderSoDetailOutbox = $searchModelDetail->searchDetail(Yii::$app->request->queryParams);
				return Yii::$app->controller->renderPartial('_indexOutboxExpand1',[
					'model'=>$model,
					'aryProviderSoDetailOutbox'=>$aryProviderSoDetailOutbox
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
			'attribute'=>'TGL_OUTBOX',
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
			//'filter' => $Combo_Dept,
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'filterOptions'=>[
				'colspan'=>3,
			  ],
			//'group'=>true,
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
			'label'=>'Time.IN',
			//'filter' => $Combo_Dept,
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
			'label'=>'Time.IN',
			//'filter' => $Combo_Dept,
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
			'template' => '{view}{review}{closed}',
			'dropdownOptions'=>['class'=>'pull-right dropup'],
			//'headerOptions'=>['class'=>'kartik-sheet-style'],
			'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
			'buttons' => [
				/* View RO | Permissian All */
				'view' => function ($url, $model) {
								//return tombolViewInbox($url, $model);
						  },
				/* Approved RO | Permissian Status 0; 0=process | Dept = Dept login | GF >= M */
				'review' => function ($url, $model) {
								return tombolReviewOutbox($url, $model);
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
		 * OUTBOX SALESAN ORDER - MD Sales
		 * ACTION CREATE
		 * @author ptrnov [piter@lukison]
		 * @since 1.2
		*/
		$_gvOutboxSo= GridView::widget([
			'id'=>'gv-so-md-outbox',
			'dataProvider'=> $apSoHeaderOutbox,
			'filterModel' => $searchModelHeader,
			'filterRowOptions'=>['style'=>'background-color:rgba(214, 255, 138, 1); align:center'],
			'columns'=>$columnIndexOutbox,
			'pjax'=>true,
			'pjaxSettings'=>[
				'options'=>[
					'enablePushState'=>false,
					'id'=>'gv-so-md-outbox',
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
					'content'=>tombolCreateSom(),
				],
			'panel'=>[
				'type'=>GridView::TYPE_WARNING,
				'heading'=>"<span class='fa fa-cart-plus fa-xs'><b> LIST SALES ORDER</b></span>",
			],
		]);

	?>


	<?php

		Modal::begin([
			'id' => 'confirm-permission-alert',
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
			$('#sales-modal-id').on('show.bs.modal', function (event) {
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
			'id' => 'sales-modal-id',
			//'header' => '<h4 class="modal-title">Entry Request Order</h4>',
			'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Sales Order</h4></div>',
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
			$(document).on('click', '[data-toggle-active]', function(e){
			e.preventDefault();

			var id = $(this).data('toggle-active');

			$.ajax({
				url: '/purchasing/sales-order/approved&id=' + id,
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
<?=$_gvOutboxSo?>
