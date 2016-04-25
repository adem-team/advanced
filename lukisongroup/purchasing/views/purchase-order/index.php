<?php
/* extensions */
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\form\ActiveForm;
use kartik\tabs\TabsX;

/* namespace models */
use lukisongroup\master\models\Suplier;
use lukisongroup\hrd\models\Employe;
use lukisongroup\hrd\models\Corp;

  /* array*/
	$selectCorp = ArrayHelper::map(Corp::find()->where('CORP_STS<>3')->all(), 'CORP_ID', 'CORP_NM');
	$poParentArray= [
		  ['ID' => 'POA', 'DESCRIP' => 'PO Plus'],
		  ['ID' => 'POB', 'DESCRIP' => 'PO General'],
		  ['ID' => 'POC', 'DESCRIP' => 'PO Product'],
	];
	$poParent = ArrayHelper::map($poParentArray, 'ID', 'DESCRIP');
	$idEmp = Yii::$app->user->identity->EMP_ID;
	$emp = Employe::find()->where(['EMP_ID'=>$idEmp])->one();
	$kr = $emp->DEP_SUB_ID;


$this->title = 'Purchaseorder';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
	/*
	 * Declaration Componen User Permission
	 * Function getPermission
	 * Modul Name[3=PO]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses('3')){
			return Yii::$app->getUserOpt->Modul_akses('3');
		}else{
			return false;
		}
	}

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

	/*
	 * Tombol Modul Create
	 * permission crate PO
	*/
	function tombolCreate(){
		if(getPermission()){
			if(getPermission()->BTN_CREATE==1){
				$title1 = Yii::t('app', 'NEW PO');
				$options1 = [ 'id'=>'po-create',
							  'data-toggle'=>"modal",
							  'data-target'=>"#new-po",
							  'class' => 'btn btn-warning btn-sm',
				];
				$icon1 = '<span class="fa fa-plus fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$content = Html::button($label1,$options1);
				return $content;
			 }else{
				$title1 = Yii::t('app', 'CREATE NEW PO');
				$options1 = [ 'id'=>'po-create',
							  'class' => 'btn btn-warning btn-sm',
							  'data-toggle'=>"modal",
							  'data-target'=>"#confirm-permission-alert",
				];
				$icon1 = '<span class="fa fa-plus fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$content = Html::button($label1, $options1);
				return $content;
			};
		}else{
				$title1 = Yii::t('app', 'CREATE NEW PO');
				$options1 = [ 'id'=>'ro-create',
							  'class' => 'btn btn-warning btn-sm',
							  'data-toggle'=>"modal",
							  'data-target'=>"#confirm-permission-alert",
				];
				$icon1 = '<span class="fa fa-plus fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$content = Html::button($label1,$options1);
				return $content;
		}
	}

	/*
	 * Tombol Modul Barang-Umum
	 * No Permission
	*/
	function tombolBarangUmum(){
		$title = Yii::t('app', 'Barang Umum');
		$options = ['id'=>'barang-umum',
					'data-toggle'=>"modal",
					'data-target'=>"#check-barang-umum",
					'class' => 'btn btn-default btn-sm'
		];
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['#']);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	/*
	 * Tombol Modul Barang-Prodak
	 * No Permission
	*/
	function tombolBarangProdak(){
		$title = Yii::t('app', 'Barang Prodak');
		$options = ['id'=>'barang-prodak',
					'data-toggle'=>"modal",
					'data-target'=>"#check-barang-prodak",
					'class' => 'btn btn-default btn-sm'
		];
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['#']);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	/*
	 * Tombol Modul Supplier
	 * No Permission
	*/
	function tombolBarangSupplier(){
		$title = Yii::t('app', 'Supplier');
		$options = ['id'=>'po-spl',
					'data-toggle'=>"modal",
					'data-target'=>"#po-spl",
					'class' => 'btn btn-default btn-sm'
		];
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['#']);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	/*
	 * Tombol Modul Customer
	 * No Permission
	*/
	function tombolBarangCustomer(){
		$title = Yii::t('app', 'Customer');
		$options = ['id'=>'po-customer',
					'data-toggle'=>"modal",
					'data-target'=>"#po-customer",
					'class' => 'btn btn-default btn-sm'
		];
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['#']);
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
				$url = Url::toRoute(['/purchasing/purchase-order/view','kd'=>$model->KD_PO]);
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
			if(getPermissionEmp()->EMP_ID == $model->CREATE_BY OR getPermission()->BTN_EDIT==1){
				if($model->STATUS == 0 OR $model->STATUS == 1 ){ // 0=process 101=Approved
					$title = Yii::t('app','Edit Detail');
					$options = [
					];
					$icon = '<span class="fa fa-pencil-square-o fa-lg"></span>';
					$label = $icon . ' ' . $title;
					$url = Url::toRoute(['/purchasing/purchase-order/create','kdpo'=>$model->KD_PO]);
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
			if(getPermissionEmp()->EMP_ID == $model->CREATE_BY AND getPermission()->BTN_DELETE==1){
				if($model->STATUS == 0){ //STATUS=0 ATAU STATUS=1 Available to delete
					$title = Yii::t('app', 'Delete');
					$options = [ 'id'=>'ro-delete',
								'data-confirm'=>'Anda yakin ingin menghapus RO ini?',
					];
					$icon = '<span class="fa fa-trash-o fa-lg"></span>';
					$label = $icon . ' ' . $title;
					$url = Url::toRoute(['/purchasing/purchase-order/hapusro','kd'=>$model->KD_PO]);
					$options['tabindex'] = '-1';
					return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
				}
			}
		}
	}

	/*
	 * BUTTON "Review" FOR CHECKED AND APPROVAL -> Check By User login
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 101=Approved]
	 * EMP_ID=UserLogin & BTN_SIGN1==1 &  Status 0 = Action Edit Show/bisa edit
	 * EMP_ID=UserLogin & BTN_SIGN1==1 &  Status 0 = Action Edit Hide/tidak bisa edit
	 * 1. Hanya User login dengan permission modul PO=3 dengan BTN_SIGN1==1
	 * 2. Action APPROVAL Akan close atau tidak bisa di lakukan jika sudah Approved | status Approved =101 | Permission sign1
	*/
	function tombolReview($url, $model){
		if(getPermission()){
			if(getPermission()->BTN_REVIEW==1 && $model->STATUS == 0  || getPermission()->BTN_REVIEW==1 && ($model->STATUS != 101 && $model->STATUS != 102) ){
					$title = Yii::t('app','Review');
					$options = [
					];
					$icon = '<span class="glyphicon glyphicon-ok"></span>';
					$label = $icon . ' ' . $title;
					$url = Url::toRoute(['/purchasing/purchase-order/review','kdpo'=>$model->KD_PO]);
					$options['tabindex'] = '-1';
					return '<li>' . Html::a($label, $url , $options) . '</li>' . PHP_EOL;

			}
			elseif(getPermissionEmp()->DEP_ID == 'ACT' && getPermission()->BTN_REVIEW==1 && $model->STATUS <>102 )
			{
				$title = Yii::t('app','Review');
				$options = [
				];
				$icon = '<span class="glyphicon glyphicon-ok"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/purchasing/purchase-order/review','kdpo'=>$model->KD_PO]);
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, $url , $options) . '</li>' . PHP_EOL;
			}
			elseif(getPermissionEmp()->DEP_ID == 'DRC' && getPermission()->BTN_REVIEW==1 && $model->STATUS <>102  || getPermissionEmp()->DEP_ID == 'GM' && getPermission()->BTN_REVIEW==1 && $model->STATUS <>102  )
			{
				$title = Yii::t('app','Review');
				$options = [
				];
				$icon = '<span class="glyphicon glyphicon-ok"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/purchasing/purchase-order/review','kdpo'=>$model->KD_PO]);
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, $url , $options) . '</li>' . PHP_EOL;
			}
		}
	}


	/*Button Action | Permission Denaid*/
	function tombolDenaid($url, $model){
		if(getPermission()){
			$permitView = getPermission()->BTN_VIEW;
			$permitEdit = getPermission()->BTN_EDIT;
			$permitReview = getPermission()->BTN_REVIEW;
			$permitDelete = getPermission()->BTN_DELETE;
			$auth2=getPermission()->BTN_SIGN2;
			$auth3=getPermission()->BTN_SIGN3;
			if($model->STATUS > 0 and ($auth2==0 or $auth3==0) and ($permitView==0 and $permitEdit==0 and $permitReview==0 and $permitDelete==0) ){
				$title1 = Yii::t('app', 'Permit Access ');
				$options1 = [ 'id'=>'action-denied-id',
							  'data-toggle'=>"modal",
							  'data-target'=>"#confirm-permission-alert",
				];
				$icon1 = '<span class="fa fa-remove fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$content = Html::a($label1,'',$options1);
				return $content;
			}
		}else{
			$title1 = Yii::t('app', 'Permit Access ');
			$options1 = [ 'id'=>'action-denied-id',
						  'data-toggle'=>"modal",
						  'data-target'=>"#confirm-permission-alert",
			];
			$icon1 = '<span class="fa fa-remove fa-lg"></span>';
			$label1 = '<div style="text-align:center">'.$icon1 . ' ' . $title1.'</div>';
			$content = Html::a($label1,'',$options1);
			return $content;
		}
	}


	/*author:wawan ver 1.0
	 * STATUS Prosess Purchase Order
	 * 1. New	= 0 | Pertama PO di buat
	 * 2. PROCESS	= 100 		| Prosess PO di buat
	 * 3. Checked	= 101	| PO Sudah Di Checked
	 * 4. Approved= 102		| PO Sudah Aprrove | RO->PO->RCVD
   * 5. REJECT	= 4		| PO Sudah Rejec
	 * 6. UNKNOWN	<>		| PO tidak valid
	*/

	function statusProcessPo($model){
		if($model->STATUS == 0){
			return Html::a('<i class="glyphicon glyphicon-retweet"></i> New', '#',['class'=>'btn btn-warning btn-xs', 'style'=>['width'=>'100px'],'title'=>'Detail']);
		}elseif ($model->STATUS==100){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> PROCESS', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==101){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> CHECKED', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==102){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> APPROVED', '#',['class'=>'btn btn-info btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==4){
			return Html::a('<i class="glyphicon glyphicon-thumbs-down"></i> REJECT', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}
    else{
			return Html::a('<i class="glyphicon glyphicon-question-sign"></i> UNKNOWN', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		};
	}

?>

<script type="text/javascript">
function submitform()
{
  document.myform.submit();
}
</script>

<?php
/* grid column history author:wawan */
$gridColumnshistory = [
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
				'background-color'=>'rgba(0, 95, 218, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		],
	],
	[
		'attribute'=>'KD_PO',
		'label'=>'Kode PO',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'130px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(0, 95, 218, 0.3)',
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
		'attribute'=>'CREATE_AT',
		'label'=>'DateTime',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'value'=>function($model){
			/*
			 * max String Disply
			 * @author ptrnov <piter@lukison.com>
			*/
			return substr($model->CREATE_AT, 0, 10);
		},
		'filterType'=> \kartik\grid\GridView::FILTER_DATE_RANGE,
					'filterWidgetOptions' =>([
						'attribute' =>'CREATE_AT',
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
				'width'=>'80px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(0, 95, 218, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'80px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt'
			]
		],
	],
	[
		'attribute'=>'namasuplier',
		'label'=>'Supplier',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'value'=>function($model){
			/*
			 * max String Disply
			 * @author ptrnov <piter@lukison.com>
			*/
			if (strlen($model->namasuplier) <=26){
				return substr($model->namasuplier, 0, 26);
			}else{
				return substr($model->namasuplier, 0, 24). '..';
			}
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'190px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(0, 95, 218, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'190px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		],
	],
			[
		'attribute'=>'SIG1_NM',
		'label'=>'Created By',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'value'=>function($model){
			/*
			 * max String Disply
			 * @author ptrnov <piter@lukison.com>
			*/
			if (strlen($model->SIG1_NM) <=16){
				return substr($model->SIG1_NM, 0, 16);
			}else{
				return substr($model->SIG1_NM, 0, 14). '..';
			}
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'125px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(0, 95, 218, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'125px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt'
			],

		],
	],
	[
		'attribute'=>'SIG2_NM',
		'label'=>'Sumbition By',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'value'=>function($model){
			/*
			 * max String Disply
			 * @author ptrnov <piter@lukison.com>
			*/
			if (strlen($model->SIG2_NM) <=16){
				return substr($model->SIG2_NM, 0, 16);
			}else{
				return substr($model->SIG2_NM, 0, 14). '..';
			}
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'125px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(0, 95, 218, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'125px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		],
	],
	[
		'attribute'=>'SIG3_NM',
		'label'=>'Approved By',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'value'=>function($model){
			/*
			 * max String Disply
			 * @author ptrnov <piter@lukison.com>
			*/
			if (strlen($model->SIG3_NM) <=16){
				return substr($model->SIG3_NM, 0, 16);
			}else{
				return substr($model->SIG3_NM, 0, 14). '..';
			}
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'125px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(0, 95, 218, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'125px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		],
	],
	[
		'attribute'=>'nmcorp',
		'label'=>'Corporation',
		'filterType'=>GridView::FILTER_SELECT2,
			'filter' => $selectCorp,
			'filterWidgetOptions'=>[
				'pluginOptions'=>['allowClear'=>true],
			],
			'filterInputOptions'=>['placeholder'=>'Any author'],
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'125px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(0, 95, 218, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'125px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		],
	],
	[
		'class'=>'kartik\grid\ActionColumn',
		'dropdown' => true,
		'template' => '{view}{tambahEdit}{delete}{approved}{no_akses}',
		'dropdownOptions'=>['class'=>'pull-right dropup'],
		'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
		'buttons' => [
			/* View PO | Permissian All */
			'view' => function ($url, $model) {
							return tombolView($url, $model);
						},
		],
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'150px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(0, 95, 218, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
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
						return statusProcessPo($model);
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'50px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(0, 95, 218, 0.3)',
			]
		],
	],

];

/* grid view history author:wawan*/
$gridLisHistory= GridView::widget([
		'id'=>'pohistory',
		'dataProvider'=> $dataproviderHistory,
		'filterModel' => $searchmodelHistory,
		'columns' => $gridColumnshistory,
		'filterRowOptions'=>['style'=>'background-color:rgba(0, 95, 218, 0.3); align:center'],
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'pohistory',
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
				[''
      ],
				//'{export}',
				//'{toggleData}',
			],
		'panel'=>[
			//'type'=>GridView::TYPE_INFO,
			'heading'=>"<span class='fa fa-shopping-cart fa-xs'><b> LIST PURCHASE ORDER</b></span>",
		],
	]);

	$gridColumns = [
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
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		[
			'attribute'=>'KD_PO',
			'label'=>'Kode PO',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'130px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
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
			'attribute'=>'CREATE_AT',
			'label'=>'DateTime',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'value'=>function($model){
				/*
				 * max String Disply
				 * @author ptrnov <piter@lukison.com>
				*/
				return substr($model->CREATE_AT, 0, 10);
			},
			'filterType'=> \kartik\grid\GridView::FILTER_DATE_RANGE,
						'filterWidgetOptions' =>([
							'attribute' =>'CREATE_AT',
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
					'width'=>'80px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'80px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt'
				]
			],
		],
		[
			'attribute'=>'namasuplier',
			'label'=>'Supplier',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'value'=>function($model){
				/*
				 * max String Disply
				 * @author ptrnov <piter@lukison.com>
				*/
				if (strlen($model->namasuplier) <=26){
					return substr($model->namasuplier, 0, 26);
				}else{
					return substr($model->namasuplier, 0, 24). '..';
				}
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'190px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'190px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
        [
			'attribute'=>'SIG1_NM',
			'label'=>'Created By',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'value'=>function($model){
				/*
				 * max String Disply
				 * @author ptrnov <piter@lukison.com>
				*/
				if (strlen($model->SIG1_NM) <=16){
					return substr($model->SIG1_NM, 0, 16);
				}else{
					return substr($model->SIG1_NM, 0, 14). '..';
				}
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'125px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'125px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt'
				],

			],
		],
		[
			'attribute'=>'SIG2_NM',
			'label'=>'Sumbition By',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'value'=>function($model){
				/*
				 * max String Disply
				 * @author ptrnov <piter@lukison.com>
				*/
				if (strlen($model->SIG2_NM) <=16){
					return substr($model->SIG2_NM, 0, 16);
				}else{
					return substr($model->SIG2_NM, 0, 14). '..';
				}
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'125px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'125px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		[
			'attribute'=>'SIG3_NM',
			'label'=>'Approved By',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'value'=>function($model){
				/*
				 * max String Disply
				 * @author ptrnov <piter@lukison.com>
				*/
				if (strlen($model->SIG3_NM) <=16){
					return substr($model->SIG3_NM, 0, 16);
				}else{
					return substr($model->SIG3_NM, 0, 14). '..';
				}
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'125px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'125px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		[
			'attribute'=>'nmcorp',
			'label'=>'Corporation',
			'filterType'=>GridView::FILTER_SELECT2,
				'filter' => $selectCorp,
				'filterWidgetOptions'=>[
					'pluginOptions'=>['allowClear'=>true],
				],
				'filterInputOptions'=>['placeholder'=>'Any author'],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'125px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'125px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		[
			'class'=>'kartik\grid\ActionColumn',
			'dropdown' => true,
			'template' => '{view}{tambahEdit}{delete}{approved}{no_akses}',
			'dropdownOptions'=>['class'=>'pull-right dropup'],
			'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
			'buttons' => [
				/* View PO | Permissian All */
				'view' => function ($url, $model) {
								return tombolView($url, $model);
						  },

				/* Edit PO | Permissian Status 0; 0=NEW */
				'tambahEdit' => function ($url, $model) {
								return tombolEdit($url, $model);
							},

				/* Delete RO | Permissian Status 0; 3=delete | User created = user login */
				'delete' => function ($url, $model) {
								return tombolDelete($url, $model);
							},

				/* Approved PO | Permissian Status 0; 102=Approved | Dept = Dept login | GF >= M */
				'approved' => function ($url, $model) {
								return tombolReview($url, $model);
							},
				'no_akses' => function ($url, $model) {
								return tombolDenaid($url, $model);
				},
			],
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'150px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
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
							return statusProcessPo($model);
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
		],

	];

	$gridLisPo= GridView::widget([
			'id'=>'po-list',
			'dataProvider'=> $dataProvider,
			'filterModel' => $searchModel,
			'columns' => $gridColumns,
			'filterRowOptions'=>['style'=>'background-color:rgba(0, 95, 218, 0.3); align:center'],
			'pjax'=>true,
			'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'po-list',
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
					['content'=>tombolCreate().tombolBarangUmum().tombolBarangProdak().tombolBarangSupplier().tombolBarangCustomer()],
					//'{export}',
					//'{toggleData}',
				],
			'panel'=>[
				//'type'=>GridView::TYPE_INFO,
				'heading'=>"<span class='fa fa-shopping-cart fa-xs'><b> LIST PURCHASE ORDER</b></span>",
			],
		]);

		$outboxpo = GridView::widget([
					'id'=>'po',
					'dataProvider'=> $dataprovider,
					'filterModel' => $searchmodel,
					'columns' => $gridColumns,
					'filterRowOptions'=>['style'=>'background-color:rgba(0, 95, 218, 0.3); align:center'],
					'pjax'=>true,
					'pjaxSettings'=>[
					'options'=>[
						'enablePushState'=>false,
						'id'=>'po',
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
							[''
            ],
							//'{export}',
							//'{toggleData}',
						],
					'panel'=>[
						//'type'=>GridView::TYPE_INFO,
						'heading'=>"<span class='fa fa-shopping-cart fa-xs'><b> LIST PURCHASE ORDER</b></span>",
					],
				]);

		?>




<div class="container-full">
	<!-- Modal -->
	<div class="modal modal-wide fade" id="new-po" size="Modal::SIZE_SMALL" tabindex="-1" role="dialog" aria-labelledby="create-poLabel">
	  <div class="modal-dialog modal-sm"  role="document">
		<div class="modal-content">

			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="create-poLabel">OPTION CREATE PO</h4>
			  </div>

			<?php $form = ActiveForm::begin([
				'id'=>'po-generate',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/purchasing/purchase-order/simpanpo'],
			]); ?>
			  <div class="modal-body" style="text-align:center">

			<?php echo $form->field($poHeaderVal,'kD_CORP')->dropDownList($selectCorp)->label(false); ?>
			<?php echo $form->field($poHeaderVal,'pARENT_PO')->dropDownList($poParent)->label(false); ?>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" >Generate PO</button>
			  </div>
			<?php ActiveForm::end(); ?>
		</div>
	  </div>
	</div>

</div>

<?php
	/*
	 * Button Modal Confirm PERMISION DENAID
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#confirm-permission-alert').on('show.bs.modal', function (event) {
				}),
	",$this::POS_READY);
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

?>
<div style="padding:10px;">
	<?php

		$items=[
			[
				'label'=>'<i class="fa fa-sign-in fa-lg"></i>  Inbox','content'=>$gridLisPo,
				'active'=>true,
			],
			[
				'label'=>'<i class="fa fa-sign-out fa-lg"></i>  Outbox','content'=>$outboxpo, // Checked/approved Ro
			],
			[
				'label'=>'<i class="glyphicon glyphicon-briefcase"></i>  History','content'=>$gridLisHistory, // History approved po
			],
		];
		echo TabsX::widget([
			'id'=>'tab-index-po',
			'items'=>$items,
			'position'=>TabsX::POS_ABOVE,
			//'height'=>'tab-height-xs',
			'bordered'=>true,
			'encodeLabels'=>false,
			//'align'=>TabsX::ALIGN_LEFT,
		]);

	?>
</div>
