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
	 * Tombol cancel proses
	*/
	function tombolCancelProses(){
				$title1 = Yii::t('app', 'Cancel Proses');
				$options1 = [ 'id'=>'po-cancel-proses',
							        'class' => 'btn btn-warning btn-sm',
				];
				$icon1 = '<span class="fa fa-plus fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$content = Html::button($label1,$options1);
				return $content;
	}


  /*
	 * Tombol cancel checked
	*/
	function tombolCancelChecked(){
				$title1 = Yii::t('app', 'Cancel Checked');
				$options1 = [ 'id'=>'po-cancel-checked',
							        'class' => 'btn btn-warning btn-sm',
				];
				$icon1 = '<span class="fa fa-plus fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$content = Html::button($label1,$options1);
				return $content;
	}

  /*
	 * Tombol cancel checked
	*/
	function tombolCancelApproved(){
				$title1 = Yii::t('app', 'Cancel Approved');
				$options1 = [ 'id'=>'po-cancel-approved',
							        'class' => 'btn btn-warning btn-sm',
				];
				$icon1 = '<span class="fa fa-plus fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$content = Html::button($label1,$options1);
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
/* grid column approval author:wawan */
$gridColumnsapproval = [
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
    'filterType' => GridView::FILTER_DATE,
           'filterWidgetOptions' => [
               'pluginOptions' => [
                   'format' => 'yyyy-mm-dd',
                   'autoclose' => true,
                   'todayHighlight' => true,
               ]
           ],
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
		'label'=>'Checked By',
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
		'attribute'=>'nmcorphistory',
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
		'template' => '{view}{review}',
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

/* grid view approved author:wawan*/
$gridLisapproved = GridView::widget([
		'id'=>'pohistory',
		'dataProvider'=> $dataproviderApproved,
		'filterModel' => $searchmodelApproved,
		'columns' => $gridColumnsapproval,
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
				['content'=>tombolCancelApproved()
      ],
				//'{export}',
				//'{toggleData}',
			],
		'panel'=>[
			//'type'=>GridView::TYPE_INFO,
			'heading'=>"<span class='fa fa-shopping-cart fa-xs'><b> LIST PURCHASE ORDER</b></span>",
		],
	]);

/* grid columns inbox po */
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
			'attribute'=>'CREATE_AT2',
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
      'filterType' => GridView::FILTER_DATE,
             'filterWidgetOptions' => [

                 'pluginOptions' => [
                     'format' => 'yyyy-mm-dd',
                     'autoclose' => true,
                     'todayHighlight' => true,
                 ]
             ],
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
			'label'=>'Checked By',
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
			'template' => '{view}',
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


  /* grid columns outbox po author : wawan */
  	$gridColumnsOutbox = [
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
  			'attribute'=>'CREATE_AT1',
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
        'filterType' => GridView::FILTER_DATE,
               'filterWidgetOptions' => [
                   'pluginOptions' => [
                       'format' => 'yyyy-mm-dd',
                       'autoclose' => true,
                       'todayHighlight' => true,
                   ]
               ],
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
  			'label'=>'Checked By',
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
  			'attribute'=>'nmcorpoutbox',
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
  			'template' => '{view}',
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


/* grid view inbox */
	$gridLisPo= GridView::widget([
			'id'=>'po-list',
			'dataProvider'=> $dataProviderCancel,
			'filterModel' => $searchModelCancel,
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
					['content'=>tombolCancelProses()],
					//'{export}',
					//'{toggleData}',
				],
			'panel'=>[
				//'type'=>GridView::TYPE_INFO,
				'heading'=>"<span class='fa fa-shopping-cart fa-xs'><b> LIST PURCHASE ORDER</b></span>",
			],
		]);

   /* grid view outbox */
		$outboxpo = GridView::widget([
					'id'=>'po',
					'dataProvider'=> $dataproviderChecked,
					'filterModel' => $searchmodelChecked,
					'columns' => $gridColumnsOutbox,
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
    					['content'=>tombolCancelChecked()],
    					//'{export}',
    					//'{toggleData}',
							//'{export}',
							//'{toggleData}',
						],
					'panel'=>[
						//'type'=>GridView::TYPE_INFO,
						'heading'=>"<span class='fa fa-shopping-cart fa-xs'><b> LIST PURCHASE ORDER</b></span>",
					],
				]);

		?>



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
				'label'=>'<i class="fa fa-sign-in fa-lg"></i>  Proses','content'=>$gridLisPo,
				// 'active'=>true,
				'options' => ['id' => 'in-box'],
			],
			[
				'label'=>'<i class="fa fa-sign-out fa-lg"></i>  Checked','content'=>$outboxpo, // Checked/approved Ro
				'options' => ['id' => 'out-tab'],
			],
			[
				'label'=>'<i class="glyphicon glyphicon-briefcase"></i>  Approved','content'=>$gridLisapproved, // History approved po
				'options' => ['id' => 'history-tab'],
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
