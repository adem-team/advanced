<?php 
//use yii\helpers\Html;
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use kartik\markdown\Markdown;

use lukisongroup\models\hrd\Corp;
use lukisongroup\models\hrd\Dept;
use lukisongroup\models\hrd\Deptsub;
use lukisongroup\models\hrd\Groupfunction;
use lukisongroup\models\hrd\Groupseqmen;
use lukisongroup\models\hrd\Jobgrade;
use lukisongroup\models\hrd\Status;
use lukisongroup\models\hrd\Employe;
use yii\helpers\Url;
use kartik\widgets\DepDrop;

//use lukisongroup\models\system\side_menu\M1000;
//use kartik\sidenav\SideNav;


$form = ActiveForm::begin([		
		'type'=>ActiveForm::TYPE_VERTICAL,
		'options'=>['enctype'=>'multipart/form-data'],
		'id'=>'emp-form1-create',
		'enableClientValidation' => true,
	]);

//$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
//$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
/*Author: -ptr.nov- Generate digit EMP_ID */

/*Get Id count Author:-ptr.nov-*/
//$cnt= (Employe::find()->count())+1;

/*get ID Sparator Array , Author: -ptr.nov-*/
//$sql = 'SELECT max(EMP_ID) as EMP_ID FROM a0001';
//$cnt= Employe::findBySql($sql)->one(); 
///$arySplit=explode('.',$cnt->EMP_ID);
//$str_id_cnt=trim($arySplit[2]);
//print_r($str_id_cnt+1);
//$id_cnt=$str_id_cnt+1;

/*Combine String and Digit Author: -ptr.nov- */
//$digit=str_pad($id_cnt,4,"0",STR_PAD_LEFT);
//$thn=date("Y");
//$nl='LG'.'.'.$thn.'.'.$digit;
/*Author: Eka Side Menu */
//$side_menu=\yii\helpers\Json::decode(M1000::find()->findMenu('hrd')->one()->jval);

$EmployeeInput= FormGrid::widget([
	'model'=>$model,
	'form'=>$form,
	'autoGenerateColumns'=>true,
	'rows'=>[
		[
            //'columns'=>2,
			//'contentBefore'=>'<div class="box box-warning box-solid "> <div class="box-header with-border ">CORPORATE IDENTITY</div></div>',
			//autoGenerateColumns'=>false,
			'columns'=>1,
			'attributes'=>[
				'employe_identity' => [
					//'columns'=>6,
					'label'=>'GENERATE CODE BY COORPORATE :',
					'attributes'=>[
						'EMP_CORP_ID'=>[

								'type'=>Form::INPUT_DROPDOWN_LIST ,
								'items'=>ArrayHelper::map(Corp::find()->orderBy('SORT')->asArray()->all(), 'CORP_ID','CORP_NM'),
								'options' => [ 'id'=>'cat-id',],
								'columnOptions'=>['colspan'=>1],
						],
					],
				],
			],
		],
		/* SUB INPUT*/
		[
			'contentBefore'=>'<legend class="text-info"><small>EMPLOYEE IDENTITY</small></legend>',	
			'columns'=>1,
			'autoGenerateColumns'=>false,
			'attributes'=>[ 
				'employe_identity' => [
					'label'=>'Employee.ID',
					//'columns'=>5,
					'attributes'=>[
						'EMP_ID'=>[
                            'disabled'=>true,
                            'type'=>Form::INPUT_WIDGET,
                            'widgetClass'=>'kartik\widgets\DepDrop',
                            'options' => [
                                'options'=>['id'=>'subcat-id','readonly'=>true,'selected'=>false], //PR VISIBLE DROP DOWN
                                'pluginOptions'=>[
                                    'depends'=>['cat-id'],
                                    //'placeholder'=>'Select...',
                                    'url'=>Url::to(['/hrd/employe/subcat']),
                                    'initialize'=>true, //loding First //
                                    'placeholder' => false, //disable select //
                                ],

                            ],

                            'columnOptions'=>['colspan'=>1],
                        ],
						/*
						'EMP_ID'=>[
							'type'=>Form::INPUT_TEXT,
							'Form::SIZE_LARGE', 							
							'options'=>[
								//'staticValue'=>'<large><bold>'.$nl.'</bold></large>',
								//'staticValue'=>$nl,
								'value'=>$nl,
								//'staticOnly'=>true,
							],
							'columnOptions'=>['colspan'=>3],
							
							//'label'=>$nl,
							//'value'=>$nl,
						],
						*/
						'EMP_NM'=>[
							'type'=>Form::INPUT_TEXT, 
							'options'=>['placeholder'=>'Enter First Name...'],
							'columnOptions'=>['colspan'=>1],
						],
						'EMP_NM_BLK'=>[
							'type'=>Form::INPUT_TEXT, 
							'options'=>['placeholder'=>'Enter Last Name...'],
							'columnOptions'=>['colspan'=>1],
						],						
					]
				],
			],
		],		
		/* SUB INPUT*/
		[
			'contentBefore'=>'<legend class="text-info"><small>COORPORATE IDENTITY</small></legend>',	
			'columns'=>1,
			'autoGenerateColumns'=>false,
			'attributes'=>[ 
				'employe_identity' => [
					//'label'=>'Company',
					//'columns'=>5,
					'attributes'=>[
						// COORPORATE - Author: -ptr.nov-
						'EMP_CORP_ID'=>[
							'type'=>Form::INPUT_DROPDOWN_LIST , 
							'items'=>ArrayHelper::map(Corp::find()->orderBy('SORT')->asArray()->all(), 'CORP_ID','CORP_NM'), 
							'options'=>['placeholder'=>'Select Coorporate...'],
							'hint'=>'Pilih Perusahaan',
							'columnOptions'=>['colspan'=>12],							
						],
						// DEPARTMENT - Author: -ptr.nov-
						'DEP_ID'=>[
							'type'=>Form::INPUT_DROPDOWN_LIST , 
							'items'=>ArrayHelper::map(Dept::find()->orderBy('SORT')->asArray()->all(), 'DEP_ID','DEP_NM'), 
							'options' => [ 'id'=>'dept-id'],
							//'options'=>['placeholder'=>'Select Coorporate...'],
							'hint'=>'Pilih Department',
							'columnOptions'=>['colspan'=>12],
						],
						// SUB DEPARTMENT - Author: -ptr.nov-
						'DEP_SUB_ID'=>[
							'type'=>Form::INPUT_WIDGET,
							'widgetClass'=>'\kartik\widgets\DepDrop',
							'options' => [
								'id'=>'subdept-id',								
								'pluginOptions'=>[
									'depends'=>['dept-id'],									
									'url'=>Url::to(['/hrd/employe/subdept']),
									'initialize'=>true, //loding First 
									'params'=>[''],
									'loadingText' => 'Sub Department ...',								
								],								
							],
							//'items'=>ArrayHelper::map(Deptsub::find()->orderBy('SORT')->asArray()->all(), 'DEP_SUB_ID','DEP_SUB_NM'),
							'hint'=>'Pilih Sub Department',							
							'columnOptions'=>['colspan'=>12],
							//'options'=>['placeholder'=>'Select Coorporate...'],
							
							
						],						
						// GROUP FUNCTION - Author: -ptr.nov-
						'GF_ID'=>[
							'type'=>Form::INPUT_DROPDOWN_LIST , 
							'items'=>ArrayHelper::map(Groupfunction::find()->orderBy('SORT')->asArray()->all(), 'GF_ID','GF_NM'),
							'options' => [ 'id'=>'Groupfnc-id'],
							'hint'=>'Pilih Group Function',
							'columnOptions'=>['colspan'=>12],
						],
						// GROUP SEQMEN - Author: -ptr.nov-
						'SEQ_ID'=>[
							'type'=>Form::INPUT_DROPDOWN_LIST , 
							'items'=>ArrayHelper::map(Groupseqmen::find()->orderBy('SEQ_NM')->asArray()->all(), 'SEQ_ID','SEQ_NM'),
							'options' => [ 'id'=>'Groupseq-id'],
							'hint'=>'Pilih Group Sequen',
							'columnOptions'=>['colspan'=>12],
						],
						// JOBGRADE - Author: -ptr.nov-
						'JOBGRADE_ID'=>[
							'type'=>Form::INPUT_WIDGET,
							'widgetClass'=>'\kartik\widgets\DepDrop',
							'options' => [
								'id'=>'grading-id',								
								'pluginOptions'=>[
									'depends'=>['Groupfnc-id','Groupseq-id'],								
									'url'=>Url::to(['/hrd/employe/grading']),
									'initialize'=>true, //loding First 
									'params'=>[''],
									'loadingText' => 'Sub Department ...',								
								],								
							],
							'hint'=>'Pilih Grading Karyawan ',
							'columnOptions'=>['colspan'=>12],
						],
						// STATUS - Author: -ptr.nov-
						'EMP_STS'=>[
							'type'=>Form::INPUT_DROPDOWN_LIST , 
							'items'=>ArrayHelper::map(Status::find()->orderBy('SORT')->asArray()->all(), 'STS_ID','STS_NM'), 
							//'options'=>['placeholder'=>'Select Coorporate...'],
							'hint'=>'Pilih Status Karyawan',
							'columnOptions'=>['colspan'=>12],
						],
						'EMP_JOIN_DATE'=>[
							'type'=>Form::INPUT_WIDGET,
							'widgetClass'=>'\kartik\widgets\DatePicker',
							'options' => [
								//'placeholder' => 'Input Join Date  ...',
								'pluginOptions' => [
									'autoclose'=>true,
									'format' => 'yyyy-mm-dd',
									'enableonreadonly'=>false,
									'todayHighlight' => true
								],
								'pluginEvents'=>[
									'show' => "function(e) {show}",
								],
							],
							'hint'=>'Enter Join Date (yyyy-mm-dd)',
							'columnOptions'=>['colspan'=>12],
						],
						'EMP_RESIGN_DATE'=>[
							'type'=>Form::INPUT_WIDGET,
							'widgetClass'=>'\kartik\widgets\DatePicker',
							'options' => [
								//'placeholder' => 'Input Resign Date  ...',
								'pluginOptions' => [
									'autoclose'=>true,
									'format' => 'yyyy-mm-dd',
									'todayHighlight' => true
								],
								'pluginEvents'=>[
									'show' => "function(e) {show}",
								],
							],
							'hint'=>'Enter Resign Date (yyyy-mm-dd)',
							'columnOptions'=>['colspan'=>12],
						],
					]
				],
			],
		],
		/* SUB INPUT*/
		[
			'contentBefore'=>'<legend class="text-info"><small>EMPLOYEE PROFILE</small></legend>',
			'columns'=>1,
			'autoGenerateColumns'=>false, // override columns setting
			'attributes'=>[       // colspan example with nested attributes
				'address_detail' => [ 
					'label'=>'Address',
					//'columns'=>5,
					'attributes'=>[
						'EMP_KTP'=>[
							'type'=>Form::INPUT_TEXT, 
							'options'=>['placeholder'=>'Enter NO KTP...'],
							'columnOptions'=>['colspan'=>12],
						],
						'EMP_ALAMAT'=>[
							//'type'=>Form::INPUT_TEXTAREA,
                            'type'=>Form::INPUT_WIDGET,
                            'widgetClass'=>'kartik\markdown\MarkdownEditor',
							'value'=>'<span class="text-justify"><em>' . $model->EMP_ALAMAT . 
							'</em></span>',
							//'options'=>['placeholder'=>'Enter address...'],
							'columnOptions'=>['colspan'=>12],
						],
						'EMP_ZIP'=>[							
							'type'=>Form::INPUT_TEXT, 
							'options'=>['placeholder'=>'Zip...'],
							'columnOptions'=>['colspan'=>6],
						],
						'EMP_HP'=>[
							'type'=>Form::INPUT_TEXT, 
							'options'=>['placeholder'=>'Phone...'],
							'columnOptions'=>['colspan'=>6],
						],						
						'EMP_TGL_LAHIR'=>[
							'type'=>Form::INPUT_WIDGET,
							'widgetClass'=>'\kartik\widgets\DatePicker',
							'options' => [
								//'placeholder' => 'Input Join Date  ...',
								'pluginOptions' => [
									'autoclose'=>true,
									'format' => 'yyyy-mm-dd',
									//'todayHighlight' => true,
									'startView'=>true
								],
								'pluginEvents'=>[
									'show' => "function(e) {show}",
								],
							],
							'hint'=>'Enter birthday  (yyyy-mm-dd)',
							'columnOptions'=>['colspan'=>6],
						],
						'EMP_GENDER'=>[
							'type'=>Form::INPUT_RADIO_LIST,
							'items'=>['Male'=>'Male', 'Female'=>'Female'],
							'options'=>['inline'=>'Male'],
							'columnOptions'=>['colspan'=>6],
						],
						'EMP_EMAIL'=>[
							'type'=>Form::INPUT_TEXT, 
							'options'=>[
								'placeholder'=>'acount@lukison.com',
								'addon' => ['prepend' => ['content'=>'@']],
							],
							'columnOptions'=>['colspan'=>6],
						],
					]
				],
			],
		],
		[	
			'columns'=>3,
			'attributes'=>[				
				'address_detail' => [ 
					'label'=>'Picture',
					'columns'=>6,
					'attributes'=>[
						'upload_file'=>[
							'type' => Form::INPUT_WIDGET,
							'widgetClass'=>'\kartik\widgets\FileInput',							
							'options'=>[
								'pluginOptions' => [
									'showPreview' => true,
									'showCaption' => false,
									'showRemove' => false,
									'showUpload' => false
									],
							],
							'columnOptions'=>['colspan'=>2],
							//'hint'=>'Enter Picture',
						],
					],
				],
			],			
		],
		/* SUB INPUT*/
		[ //-Action Author: -ptr.nov-
			'attributes'=>[ 
				'actions'=>[    // embed raw HTML content
						'type'=>Form::INPUT_RAW, 
						'value'=>  '<div style="text-align: right; margin-top: 20px">' . 
							Html::resetButton('Reset', ['class'=>'btn btn-default']) . ' ' .
							Html::submitButton('Submit', ['class'=>'btn btn-primary']) . 
							'</div>'
				],
			],
		],
	]
  
]);


echo Html::listGroup([
	 [
		 'content' => 'IINPUT DATA KARYAWAN',
		 'url' => '#',
		 'badge' => '',
		 'active' => true
	 ],
	 [
		 'content' => $EmployeeInput,

	 ],
]);
           
ActiveForm::end();
?>