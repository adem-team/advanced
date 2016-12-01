<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use lukisongroup\master\models\Schedulegroup;
use lukisongroup\sistem\models\Mdlpermission;

$this->sideCorp = 'PT.Lukisongroup';                        /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'admin';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ERP Modul - Administrator');  /* title pada header page */

	/**
    *@author wawan
	* Declaration Componen User Permission
	* Function getPermission
	* Modul Name[8=SO2]
	*/
	// function getPermission(){
		// if (Yii::$app->getUserOpt->Modul_akses('10')){
			// return Yii::$app->getUserOpt->Modul_akses('10');
		// }else{
			// return false;
		// }
	// };
	
	// $varValidate=$this->getPermission();
	
  //if(getPermission()){
  	if($prmissionCheck->BTN_CREATE){
  		$link = '/sistem/modul-permission';

  	}else{
  		$link = '/site/validasi';
  	}


	$aryStt= [
		  ['STATUS' => 0, 'STT_NM' => 'DISABLE'],		  
		  ['STATUS' => 1, 'STT_NM' => 'ENABLE'],
	];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');
	
	/*
	* COLUMN LIST USER.
	* @author wawan, update Piter Novian [ptr.nov@gmail.com]
	* @since 1.1
	*/
	$listUserCLm = [
		[	
			/* Attribute Serial No */
			'class'=>'kartik\grid\SerialColumn',
			'width'=>'5px',
			'header'=>'No.',
			'hAlign'=>'center',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'5px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'5px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
				]
			],
			'pageSummaryOptions' => [
				'style'=>[
					'border-right'=>'0px',
				]
			]
		],
		[  
			//username
			'attribute' => 'username',
			'label'=>'Nama user',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'180px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'180px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		],
		[
			//STATUS
			'attribute' => 'MODUL_STS',
			'label'=>'STT',
			// 'filter' => $valStt,
			'format' => 'raw',
			'hAlign'=>'center',
			'value'=>function($model){
			   if ($model->status == 10) {
				//return Html::a('<i class="fa fa-check"></i> &nbsp;Enable', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
				return Html::a('<i class="fa fa-check"></i>', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
			  } else if ($model->status == 1) {
				//return Html::a('<i class="fa fa-close"></i> &nbsp;Disable', '',['class'=>'btn btn-danger btn-xs', 'title'=>'Deactive']);
				return Html::a('<i class="fa fa-close"></i>', '',['class'=>'btn btn-danger btn-xs', 'title'=>'Deactive']);
			  }
			},
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'mergeHeader'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'60px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'60px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		],
		[
			'class'=>'kartik\grid\ActionColumn',
			'dropdown' => true,
			'template' => '{edit}',
			'dropdownOptions'=>['class'=>'pull-right dropup'],
			'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
			'buttons' => [
				'edit' =>function($url, $model, $key){
					return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Change Password'),
								  ['/sistem/modul-permission/update-pass','id'=>$model->id],[
								  'data-toggle'=>"modal",
								  'data-target'=>"#modal-create",
								  'data-title'=>'',// $model->KD_BARANG,
								  ]). '</li>' . PHP_EOL;
				},
			],
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'150px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'150px',
					'height'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		],
    ];
	
	/*
	* COLUMN LIST MODUL PERMISSION  PER-USER.
	* @author wawan, update Piter Novian [ptr.nov@gmail.com]
	* @since 1.1
	*/	
	$listPermissionCLm = [
		[	//COL-2
			/* Attribute Serial No */
			'class'=>'kartik\grid\SerialColumn',
			'width'=>'10px',
			'header'=>'No.',
			'hAlign'=>'center',
			'headerOptions'=>[
			'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
				]
			],
			'pageSummaryOptions' => [
				'style'=>[
					'border-right'=>'0px',
				]
			]
		],
		[  	//col-1
		  // MODUL_ID
		  'attribute' =>'modul.MODUL_NM',
		  'format' => 'html',
		  'label'=>'Modul_Name',
		  'mergeHeader'=>true,
		  'hAlign'=>'left',
		  'vAlign'=>'middle',
		  'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'200px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(255, 160, 51, 1)',
			]
		  ],
		  'contentOptions'=>[
			'style'=>[
			  'text-align'=>'left',
			  'width'=>'200px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		  ],
			'group'=>false,
		],
		[ //USER_ID
			'attribute' => 'UserNm',
			'label'=>'User ID',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'mergeHeader'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
			'group'=>false,
		],
		[ //BTN_CREATE
			'class'=>'kartik\grid\EditableColumn',
			'filter' => $valStt,
			'attribute' => 'BTN_CREATE',
			'label'=>'BTN CREATE',
			'format' => 'raw',
			'value'=>function($model){
				if ($model->BTN_CREATE == 1) {
					return Html::a('<i class="fa fa-unlock "></i>');
				} else if ($model->BTN_CREATE == 0) {
					return Html::a('<i class="fa fa-lock"></i>');
					
				}
			},
			'readonly'=>function() use ($userPrmission) {
				   if($userPrmission==1 OR $userPrmission==2){
						return false;  
				   }else{
					  return true;  
				   }
			},
			'editableOptions' => [
				'header' => 'CREATE',
				'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX_X,
				'size'=>'xs',
				'options' => [
				],
				'displayValueConfig'=> [
					'1' => '<i class="fa fa-unlock"></i>',
					'0' => '<i class="fa fa-lock"></i>',
				],
			],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		],
		[  	//col-4
			//BTN_EDIT
			'class'=>'kartik\grid\EditableColumn',
			'attribute' => 'BTN_EDIT',
			'label'=>'BTN EDIT',
			'filter' => $valStt,
			'format' => 'raw',
			'value'=>function($model){
				if ($model->BTN_EDIT == 1) {
					return Html::a('<i class="fa fa-unlock "></i>');
				} else if ($model->BTN_EDIT == 0) {
					return Html::a('<i class="fa fa-lock"></i>');
					
				}
			},
			'readonly'=>function() use ($userPrmission) {
				   if($userPrmission==1 OR $userPrmission==2){
						return false;  
				   }else{
					  return true;  
				   }
			},
			'editableOptions' => [
			   'header' => 'Update Permission',
			   'inputType' =>\kartik\editable\Editable::INPUT_CHECKBOX_X,
			   'size'=>'sm',
			   'options' => [
			   ],
			   'displayValueConfig'=> [
					   '1' => '<i class="fa fa-unlock "></i>',
					   '0' => '<i class="fa fa-lock"></i>',
					 ],
			 ],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
				  'text-align'=>'center',
				  'width'=>'200px',
				  'font-family'=>'tahoma, arial, sans-serif',
				  'font-size'=>'8pt',
				]
			],
		],
		[  	//col-5
			//BTN_DELETE
			'class'=>'kartik\grid\EditableColumn',
			'attribute' => 'BTN_DELETE',
			'label'=>'BTN DELETE',
			'filter' => $valStt,
			'format' => 'raw',
			'value'=>function($model){
				if ($model->BTN_DELETE == 1) {
					return Html::a('<i class="fa fa-unlock "></i>');
				} else if ($model->BTN_DELETE == 0) {
					return Html::a('<i class="fa fa-lock"></i>');
					
				}
			},
			'readonly'=>function() use ($userPrmission) {
				   if($userPrmission==1 OR $userPrmission==2){
						return false;  
				   }else{
					  return true;  
				   }
			},
			'editableOptions' => [
			   'header' => 'Update Permission',
			   'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX_X,
			   'size'=>'sm',
			   'options' => [
			   ],
			   'displayValueConfig'=> [
					'1' => '<i class="fa fa-unlock "></i>',
					'0' => '<i class="fa fa-lock"></i>',
				],
			],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
				  'text-align'=>'center',
				  'width'=>'200px',
				  'font-family'=>'tahoma, arial, sans-serif',
				  'font-size'=>'8pt',
				]
			],
		],
		[  	//col-6
			//BTN_view
			'class'=>'kartik\grid\EditableColumn',
			'attribute' => 'BTN_VIEW',
			'label'=>'BTN VIEW',
			'filter' => $valStt,
			'format' => 'raw',
			'value'=>function($model){
				if ($model->BTN_VIEW == 1) {
					return Html::a('<i class="fa fa-unlock "></i>');
				} else if ($model->BTN_VIEW == 0) {
					return Html::a('<i class="fa fa-lock"></i>');
					
				}
			},
			'readonly'=>function() use ($userPrmission) {
				   if($userPrmission==1 OR $userPrmission==2){
						return false;  
				   }else{
					  return true;  
				   }
			},
			'editableOptions' => [
				'header' => 'Update Permission',
				'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX_X,
				'size'=>'sm',

				'options' => [
				  // 'value' => 'Kartik Visweswaran',
				],
				'displayValueConfig'=> [
					'1' => '<i class="fa fa-unlock "></i>',
					'0' => '<i class="fa fa-lock"></i>',
				],
			],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		],
		[  	//col-6
			//BTN_REVIEW
			'class'=>'kartik\grid\EditableColumn',
			'attribute' => 'BTN_REVIEW',
			'label'=>'BTN REVIEW',
			'filter' => $valStt,
			'format' => 'raw',
			'value'=>function($model){
				if ($model->BTN_REVIEW == 1) {
					return Html::a('<i class="fa fa-unlock "></i>');
				} else if ($model->BTN_REVIEW == 0) {
					return Html::a('<i class="fa fa-lock"></i>');
					
				}
			},
			'readonly'=>function() use ($userPrmission) {
				   if($userPrmission==1 OR $userPrmission==2){
						return false;  
				   }else{
					  return true;  
				   }
			},
			'editableOptions' => [
				'header' => 'Update Permission',
				'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX_X,
				'size'=>'sm',
				'options' => [
				],
				'displayValueConfig'=> [
					'1' => '<i class="fa fa-unlock "></i>',
					'0' => '<i class="fa fa-lock"></i>',
				],
			],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		],
		[  	//col-7
			//BTN_PROCESS1
			'class'=>'kartik\grid\EditableColumn',
			'attribute' => 'BTN_PROCESS1',
			'label'=>'BTN PROCESS1',
			'filter' => $valStt,
			'format' => 'raw',
			'value'=>function($model){
				if ($model->BTN_PROCESS1 == 1) {
					return Html::a('<i class="fa fa-unlock "></i>');
				} else if ($model->BTN_PROCESS1 == 0) {
					return Html::a('<i class="fa fa-lock"></i>');
					
				}
			},
			'readonly'=>function() use ($userPrmission) {
				   if($userPrmission==1 OR $userPrmission==2){
						return false;  
				   }else{
					  return true;  
				   }
			},
			'editableOptions' => [
				'header' => 'Update Permission',
				'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX_X,
				'size'=>'sm',
				'options' => [
				],
				'displayValueConfig'=> [
					'1' => '<i class="fa fa-unlock "></i>',
					'0' => '<i class="fa fa-lock"></i>',
				],
			],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		],
		[  	//col-8
			//BTN_PROCESS2
			'class'=>'kartik\grid\EditableColumn',
			'attribute' => 'BTN_PROCESS2',
			'label'=>'BTN PROCESS2',
			'filter' => $valStt,
			'format' => 'raw',
			'value'=>function($model){
				if ($model->BTN_PROCESS2 == 1) {
					return Html::a('<i class="fa fa-unlock "></i>');
				} else if ($model->BTN_PROCESS2 == 0) {
					return Html::a('<i class="fa fa-lock"></i>');
					
				}
			},
			'readonly'=>function() use ($userPrmission) {
				   if($userPrmission==1 OR $userPrmission==2){
						return false;  
				   }else{
					  return true;  
				   }
			},
			'editableOptions' => [
				'header' => 'Update Permission',
				'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX_X,
				'size'=>'sm',
				'options' => [
				],
				'displayValueConfig'=> [
					'1' => '<i class="fa fa-unlock "></i>',
					'0' => '<i class="fa fa-lock"></i>',
				],
			],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		],
		[  	//col-8
			//BTN_PROCESS3
			'class'=>'kartik\grid\EditableColumn',
			'attribute' => 'BTN_PROCESS3',
			'label'=>'BTN PROCESS3',
			'filter' => $valStt,
			'format' => 'raw',
			'value'=>function($model){
				if ($model->BTN_PROCESS3 == 1) {
					return Html::a('<i class="fa fa-unlock "></i>');
				} else if ($model->BTN_PROCESS3 == 0) {
					return Html::a('<i class="fa fa-lock"></i>');
					
				}
			},
			'readonly'=>function() use ($userPrmission) {
				   if($userPrmission==1 OR $userPrmission==2){
						return false;  
				   }else{
					  return true;  
				   }
			},
			'editableOptions' => [
				'header' => 'Update Permission',
				'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX_X,
				'size'=>'sm',
				'options' => [
				],
				'displayValueConfig'=> [
					'1' => '<i class="fa fa-unlock "></i>',
					'0' => '<i class="fa fa-lock"></i>',
				],
			],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		],
		[  	//col-8
			//BTN_PROCESS4
			'class'=>'kartik\grid\EditableColumn',
			'attribute' => 'BTN_PROCESS4',
			'label'=>'BTN PROCESS4',
			'format'=>'raw',
			'filter' => $valStt,
			'value'=>function($model){
				if ($model->BTN_PROCESS4 == 1) {
					return Html::a('<i class="fa fa-unlock "></i>');
				} else if ($model->BTN_PROCESS4 == 0) {
					return Html::a('<i class="fa fa-lock"></i>');
					
				}
			},
			'readonly'=>function() use ($userPrmission) {
				   if($userPrmission==1 OR $userPrmission==2){
						return false;  
				   }else{
					  return true;  
				   }
			},
			'editableOptions' => [				
			   'header' => 'Update Permission',
			   'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX_X,
			   'size'=>'sm',
			   'options' => [
			   ],			   
			   // 'submitOnEnter' => false,
			   'displayValueConfig'=> [
				 '1' => '<i class="fa fa-unlock "></i>',
				 '0' => '<i class="fa fa-lock"></i>',
					 ],
			],			
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'200px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'9pt',
			  'background-color'=>'rgba(255, 160, 51, 1)',
			]
			],
			'contentOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'200px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
			],
		],
		[  	//col-10
			//BTN_PROCESS5
			'class'=>'kartik\grid\EditableColumn',
			'attribute' => 'BTN_PROCESS5',
			'label'=>'BTN PROCESS5',
			'filter' => $valStt,
			'format' => 'raw',
			'value'=>function($model){
				if ($model->BTN_PROCESS5 == 1) {
					return Html::a('<i class="fa fa-unlock "></i>');
				} else if ($model->BTN_PROCESS5 == 0) {
					return Html::a('<i class="fa fa-lock"></i>');
					
				}
			},
			'readonly'=>function() use ($userPrmission) {
				   if($userPrmission==1 OR $userPrmission==2){
						return false;  
				   }else{
					  return true;  
				   }
			},
			'editableOptions' => [
				'header' => 'Update Permission',
				'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX_X,
				'size'=>'sm',
				'options' => [
				],
				'displayValueConfig'=> [
					'1' => '<i class="fa fa-unlock "></i>',
					'0' => '<i class="fa fa-lock"></i>',
				],
			],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		],
		[  	//col-11
			//BTN_SIGN1
			'class'=>'kartik\grid\EditableColumn',
			'attribute' => 'BTN_SIGN1',
			'label'=>'BTN SIGN1',
			'filter' => $valStt,
			'format' => 'raw',
			'value'=>function($model){
				if ($model->BTN_SIGN1 == 1) {
					return Html::a('<i class="fa fa-unlock "></i>');
				} else if ($model->BTN_SIGN1 == 0) {
					return Html::a('<i class="fa fa-lock"></i>');
					
				}
			},
			'readonly'=>function() use ($userPrmission) {
				   if($userPrmission==1 OR $userPrmission==2){
						return false;  
				   }else{
					  return true;  
				   }
			},
			'editableOptions' => [
				'header' => 'Update Permission',
				'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX_X,
				'size'=>'sm',
				'options' => [
				],
				'displayValueConfig'=> [
					'1' => '<i class="fa fa-unlock "></i>',
					'0' => '<i class="fa fa-lock"></i>',
				],
			],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		],
		[  	//col-12
			//BTN_SIGN2
			'class'=>'kartik\grid\EditableColumn',
			'attribute' => 'BTN_SIGN2',
			'label'=>'BTN SIGN2',
			'filter' => $valStt,
			'format' => 'raw',
			'value'=>function($model){
				if ($model->BTN_SIGN2 == 1) {
					return Html::a('<i class="fa fa-unlock "></i>');
				} else if ($model->BTN_SIGN2 == 0) {
					return Html::a('<i class="fa fa-lock"></i>');
					
				}
			},
			'readonly'=>function() use ($userPrmission) {
				   if($userPrmission==1 OR $userPrmission==2){
						return false;  
				   }else{
					  return true;  
				   }
			},
			'editableOptions' => [
				'header' => 'Update Permission',
				'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX_X,
				'size'=>'sm',
				'options' => [
				],
				'displayValueConfig'=> [
					'1' => '<i class="fa fa-unlock "></i>',
					'0' => '<i class="fa fa-lock"></i>',
				],
			],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		],
		[  	//BTN_SIGN3
			'class'=>'kartik\grid\EditableColumn',
			'attribute' => 'BTN_SIGN3',
			'label'=>'BTN SIGN3',
			'filter' => $valStt,
			'format' => 'raw',
			'value'=>function($model){
				if ($model->BTN_SIGN3 == 1) {
					return Html::a('<i class="fa fa-unlock "></i>');
				} else if ($model->BTN_SIGN3 == 0) {
					return Html::a('<i class="fa fa-lock"></i>');
					
				}
			},
			'readonly'=>function() use ($userPrmission) {
				   if($userPrmission==1 OR $userPrmission==2){
						return false;  
				   }else{
					  return true;  
				   }
			},
			'editableOptions' => [
				'header' => 'BTN_SIGN3',
				'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX_X,
				'size'=>'sm',
				'options' => [],
				'displayValueConfig'=> [
					'1' => '<i class="fa fa-unlock "></i>',
					'0' => '<i class="fa fa-lock"></i>',
				],
			],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		],
		[ 	//BTN_SIGN4
			'class'=>'kartik\grid\EditableColumn',
			'attribute' => 'BTN_SIGN4',
			'label'=>'BTN SIGN4',
			'filter' => $valStt,
			'format' => 'raw',
			'value'=>function($model){
				if ($model->BTN_SIGN4 == 1) {
					return Html::a('<i class="fa fa-unlock "></i>');
				} else if ($model->BTN_SIGN4 == 0) {
					return Html::a('<i class="fa fa-lock"></i>');
					
				}
			},
			'readonly'=>function() use ($userPrmission) {
				   if($userPrmission==1 OR $userPrmission==2){
						return false;  
				   }else{
					  return true;  
				   }
			},
			'editableOptions' => [
				'header' => 'BTN_SIGN4',
				'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX_X,
				'size'=>'sm',
				'options' => [],
				'displayValueConfig'=> [
					'1' => '<i class="fa fa-unlock"></i>',
					'0' => '<i class="fa fa-lock"></i>',
				],
			],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		],
		[ 	//BTN_SIGN5
			'class'=>'kartik\grid\EditableColumn',
			'attribute' => 'BTN_SIGN5',
			'label'=>'BTN SIGN5',
			'filter' => $valStt,
			'format' => 'raw',
			'value'=>function($model){
				if ($model->BTN_SIGN5 == 1) {
					return Html::a('<i class="fa fa-unlock "></i>');
				} else if ($model->BTN_SIGN5 == 0) {
					return Html::a('<i class="fa fa-lock"></i>');
					
				}
			},
			'readonly'=>function() use ($userPrmission) {
				   if($userPrmission==1 OR $userPrmission==2){
						return false;  
				   }else{
					  return true;  
				   }
			},
			'editableOptions' => [
				'header' => 'BTN_SIGN5',
				'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX_X,
				'size'=>'sm',
				'options' => [],
				'displayValueConfig'=> [
					'1' => '<i class="fa fa-unlock "></i>',
					'0' => '<i class="fa fa-lock"></i>',
				],
			],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		],
		[	//STATUS
			'attribute' => 'STATUS',
			'label'=>'STT',
			'filter' => $valStt,
			'format' => 'raw',
			'hAlign'=>'center',
			'value'=>function($model){
				if ($model->STATUS == 1) {
					return Html::a('<i class="fa fa-check"></i>', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
					//return Html::a('<i class="fa fa-check"></i> &nbsp;Enable', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
				} else if ($model->STATUS == 0) {
					return Html::a('<i class="fa fa-close"></i>', '',['class'=>'btn btn-danger btn-xs', 'title'=>'Deactive']);
					//return Html::a('<i class="fa fa-close"></i> &nbsp;Disable', '',['class'=>'btn btn-danger btn-xs', 'title'=>'Deactive']);
				}
			},
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'80px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 160, 51, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'80px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
				]
			],
		]
	];
	
	/*
	* GRIDVIEW LIST USER - modul permission
	* @author wawan
	* @since 1.1
	*/
	$gvUserList= GridView::widget([
		'id'=>'gv-user-list',
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'filterRowOptions'=>['style'=>'background-color:rgba(0, 95, 218, 0.3); align:center; vAlign:middle'],
		'rowOptions'   => function ($model, $key, $index, $grid) {
			return ['id' => $model->id,'onclick' => '$.pjax.reload({
				url: "'.Url::to(['/sistem/modul-permission/index']).'?MdlpermissionSearch[USER_ID]="+this.id,
				container: "#gv-perimisson-id",
				timeout: 1000,
			});'];
			//  return ['data-id' => $model->USER_ID];
		},
		'floatOverflowContainer'=>true,
		'floatHeader'=>true,
		'columns' =>$listUserCLm,
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-user-list',
			],
		],
		'panel' => [
			'heading'=>'<i class="fa fa fa-user-plus fa-1x"></i> User List ',
			'type'=>'primary',
			'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add User',
			['modelClass' => 'Kategori',]),'/sistem/modul-permission/create',[
				'data-toggle'=>"modal",
				'data-target'=>"#modal-create",
				'class' => 'btn btn-success btn-xs'
			]),
			'showFooter'=>false,
			'after'=>false,
		],
		'toolbar'=> [
			//'{items}',
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
	]);

	/*
	* GRIDVIEW Modul Permission
	* @author wawan
	* @since 1.1
	*/
	$gvPermissionModul= GridView::widget([
		'id'=>'gv-perimisson-id',
		'dataProvider' => $dataProviderpermision,
		'filterModel' => $searchModelpermision,
		'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
		'floatOverflowContainer'=>true,
		'floatHeader'=>true,
		'columns' => $listPermissionCLm,
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-perimisson-id',
			],
		],
		'panel' => [
			'heading'=>'<i class="fa fa fa-shield fa-1x"></i> List Permission ', 
			'type'=>'primary',
			'showFooter'=>false,
			'before'=>false
		],
		'toolbar'=> [
			//'{items}',
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
	]);
?>

<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<div  class="row" style="margin-top:15px">
		<!-- GROUP LOCALTION !-->
		<div class="col-md-4">
			<?=$gvUserList?>
		</div>
		<!-- GROUP CUSTOMER LIST !-->
		<div class="col-md-8">
			<?=$gvPermissionModul?>
		</div>
	</div>
</div>
<?php
	$this->registerJs("
		$.fn.modal.Constructor.prototype.enforceFocus = function(){};
		$('#modal-create').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var modal = $(this)
		var title = button.data('title')
		var href = button.attr('href')
		//modal.find('.modal-title').html(title)
		modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
		$.post(href)
			.done(function( data ) {
				modal.find('.modal-body').html(data)
			});
		})
	",$this::POS_READY);
	
	Modal::begin([
		'id' => 'modal-create',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">User</h4></div>',
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
		],
	]);
	Modal::end();
	
	
	/**
	  * MSG MODAL PERMISSION.
	  * LOCAL PERMISSION.
	  * @author piter [ptr.nov@gmail.com]
	*/
	Modal::begin([
		'id' => 'msg-alert',
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
