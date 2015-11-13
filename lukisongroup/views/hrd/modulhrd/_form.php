<?php 
use yii\helpers\Html;
use lukisongroup\models\hrd\Modulhrd;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;

$this->sideMenu = 'hrd_employee';
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
$nlDigit= (Modulhrd::find()->count())+1;
$nl='LG'.$nlDigit;
?>

<?php
echo FormGrid::widget([
	'model'=>$model,
	'form'=>$form,
	'autoGenerateColumns'=>true,
	'rows'=>[
		[
			'contentBefore'=>'<legend class="text-info"><small>DEPARTMENT IDENTITY</small></legend>',	
			'columns'=>1,
			'autoGenerateColumns'=>false,
			'attributes'=>[ 
				'employe_identity' => [
					'label'=>'Dept.ID',
					'columns'=>5,
					'attributes'=>[
						'MDL_ID'=>[
							'type'=>Form::INPUT_TEXT,
							'Form::SIZE_LARGE', 							
							'options'=>[
								//'staticValue'=>'<large><bold>'.$nl.'</bold></large>',
								//'staticValue'=>$nl,
								//'value'=>$nl,
								//'staticOnly'=>true,
							],
							'columnOptions'=>['colspan'=>3],
							
							//'label'=>$nl,
							//'value'=>$nl,
						],
						'MDL_NM'=>[
							'type'=>Form::INPUT_TEXT, 
							'options'=>['placeholder'=>'Department Name...'],
							'columnOptions'=>['colspan'=>4],
						],
						'MDL_DCRP'=>[
							'type'=>Form::INPUT_TEXTAREA, 
							'options'=>['placeholder'=>'Department Description ...'],
							'columnOptions'=>['colspan'=>4],
						],
						'SORT'=>[
							'type'=>Form::INPUT_TEXT, 
							'options'=>['placeholder'=>'SORT...'],
							'columnOptions'=>['colspan'=>4],
						],						
					]
				],
			],
		],		
		
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