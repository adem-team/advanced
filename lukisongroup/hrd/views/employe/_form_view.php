<?php 
use yii\helpers\Html;
use app\models\hrd\Corp;
use app\models\hrd\Dept;
use app\models\hrd\Jabatan;
use app\models\hrd\Status;
use app\models\hrd\Employe;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
//$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
$nlDigit= (Employe::find()->count())+1;
$nl='LG'.$nlDigit;
echo FormGrid::widget([
	'model'=>$model,
	'form'=>$form,
	'autoGenerateColumns'=>true,
	'rows'=>[
		[
			'contentBefore'=>'<legend class="text-info"><small>EMPLOYE IDENTITY</small></legend>',	
			'columns'=>1,
			'autoGenerateColumns'=>false,
			'attributes'=>[ 
				'employe_identity' => [
					'label'=>'Employee.ID',
					'columns'=>5,
					'attributes'=>[
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
						'EMP_NM'=>[
							'type'=>Form::INPUT_TEXT, 
							'options'=>['placeholder'=>'Enter First Name...'],
							'columnOptions'=>['colspan'=>4],
						],
						'EMP_NM_BLK'=>[
							'type'=>Form::INPUT_TEXT, 
							'options'=>['placeholder'=>'Enter Last Name...'],
							'columnOptions'=>['colspan'=>4],
						],						
					]
				],
			],
		],		
		
		[
			'contentBefore'=>'<legend class="text-info"><small>CORPORATE IDENTITY</small></legend>',	
			'columns'=>2,
			'autoGenerateColumns'=>false,
			'attributes'=>[ 
				'employe_identity' => [
					'label'=>'Company',
					'columns'=>2,
					'attributes'=>[
						'EMP_CORP_ID'=>[
							'type'=>Form::INPUT_DROPDOWN_LIST , 
							'items'=>ArrayHelper::map(Corp::find()->orderBy('SORT')->asArray()->all(), 'CORP_ID','CORP_NM'), 
							//'options'=>['placeholder'=>'Select Coorporate...'],
							'columnOptions'=>['colspan'=>1],
							
						],
						'DEP_ID'=>[
							'type'=>Form::INPUT_DROPDOWN_LIST , 
							'items'=>ArrayHelper::map(Dept::find()->orderBy('SORT')->asArray()->all(), 'DEP_ID','DEP_NM'), 
							//'options'=>['placeholder'=>'Select Coorporate...'],
							'hint'=>'Select Department',
							'columnOptions'=>['colspan'=>1],
						],
						'JAB_ID'=>[
							'type'=>Form::INPUT_DROPDOWN_LIST , 
							'items'=>ArrayHelper::map(Jabatan::find()->orderBy('SORT')->asArray()->all(), 'JAB_ID','JAB_NM'), 
							//'options'=>['placeholder'=>'Select Coorporate...'],
							'hint'=>'Select	Position ',
							'columnOptions'=>['colspan'=>1],
						],
						'EMP_STS'=>[
							'type'=>Form::INPUT_DROPDOWN_LIST , 
							'items'=>ArrayHelper::map(Status::find()->orderBy('SORT')->asArray()->all(), 'STS_ID','STS_NM'), 
							//'options'=>['placeholder'=>'Select Coorporate...'],
							'hint'=>'Select Employee Status',
							'columnOptions'=>['colspan'=>1],
						],
						'EMP_JOIN_DATE'=>[
							'type'=>Form::INPUT_WIDGET,
							'widgetClass'=>'\kartik\widgets\DatePicker',
							'options' => [
								//'placeholder' => 'Input Join Date  ...',
								'pluginOptions' => [
									'autoclose'=>true,
									'format' => 'yyyy-mm-dd',
									'todayHighlight' => true
								],
							],
							'hint'=>'Enter Join Date (yyyy-mm-dd)',
							'columnOptions'=>['colspan'=>1],
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
							],
							'hint'=>'Enter Resign Date (yyyy-mm-dd)',
							'columnOptions'=>['colspan'=>1],
						],
					]
				],
			],
		],
		[
			'contentBefore'=>'<legend class="text-info"><small>EMPLOYEE PROFILE</small></legend>',
			'columns'=>3,
			'autoGenerateColumns'=>false, // override columns setting
			'attributes'=>[       // colspan example with nested attributes
				'address_detail' => [ 
					'label'=>'Address',
					'columns'=>6,
					'attributes'=>[
						'EMP_KTP'=>[
							'type'=>Form::INPUT_TEXT, 
							'options'=>['placeholder'=>'Enter NO KTP...'],
							'columnOptions'=>['colspan'=>2],
						],
						'EMP_ALAMAT'=>[
							'type'=>Form::INPUT_TEXTAREA, 
							'options'=>['placeholder'=>'Enter address...'],
							'columnOptions'=>['colspan'=>6],
						],
						'EMP_ZIP'=>[							
							'type'=>Form::INPUT_TEXT, 
							'options'=>['placeholder'=>'Zip...'],
							'columnOptions'=>['colspan'=>1],
						],
						'EMP_HP'=>[
							'type'=>Form::INPUT_TEXT, 
							'options'=>['placeholder'=>'Phone...'],
							'columnOptions'=>['colspan'=>2],
						],
						'EMP_GENDER'=>[
							'type'=>Form::INPUT_RADIO_LIST,
							'items'=>['Male'=>'Male', 'Female'=>'Female'],
							'options'=>['inline'=>'Male'],
							'columnOptions'=>['colspan'=>4],
						],
						'EMP_TGL_LAHIR'=>[
							'type'=>Form::INPUT_WIDGET,
							'widgetClass'=>'\kartik\widgets\DatePicker',
							'options' => [
								//'placeholder' => 'Input Join Date  ...',
								'pluginOptions' => [
									'autoclose'=>true,
									'format' => 'yyyy-mm-dd',
									'todayHighlight' => true
								],
							],
							'hint'=>'Enter birthday  (yyyy-mm-dd)',
							'columnOptions'=>['colspan'=>3],
						],
						'EMP_EMAIL'=>[
							'type'=>Form::INPUT_TEXT, 
							'options'=>[
								'placeholder'=>'acount@domain.com...',
								'addon' => ['prepend' => ['content'=>'@']],
							],
							'columnOptions'=>['colspan'=>3],
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
						'EMP_IMG'=>[
							'type' => Form::INPUT_WIDGET,
							'widgetClass'=>'\kartik\widgets\FileInput',
							'columnOptions'=>['colspan'=>2],
							//'hint'=>'Enter Picture',
						],
					],
				],
			],			
		],
		
		/*
		[
			'attributes'=>[
				'birthday'=>['type'=>Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\DatePicker', 'hint'=>'Enter birthday (mm/dd/yyyy)'],
				//'state_1'=>['type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>$model->typeahead_data, 'hint'=>'Type and select state'],
				'color'=>['type'=>Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\ColorInput', 'hint'=>'Choose your color'],
				
			],
		],
		[
			'attributes'=>[       // 3 column layout
				'rememberMe'=>[   // radio list
					'type'=>Form::INPUT_RADIO_LIST, 
					'items'=>[true=>'Yes', false=>'No'], 
					'options'=>['inline'=>true]
				],
				'brightness'=>[   // uses widget class with widget options
					'type'=>Form::INPUT_WIDGET, 
					'label'=>Html::label('Brightness (%)'), 
					'widgetClass'=>'\kartik\widgets\RangeInput',
					'options'=>['width'=>'80%']
				],
				'actions'=>[    // embed raw HTML content
					'type'=>Form::INPUT_RAW, 
					'value'=>  '<div style="text-align: right; margin-top: 20px">' . 
						Html::resetButton('Reset', ['class'=>'btn btn-default']) . ' ' .
						Html::submitButton('Submit', ['class'=>'btn btn-primary']) . 
						'</div>'
				],
			],
		],
		*/
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
ActiveForm::end();