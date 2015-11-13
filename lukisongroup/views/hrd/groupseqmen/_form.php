<?php

use kartik\helpers\Html;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\builder\FormGrid;
use yii\helpers\ArrayHelper;
use kartik\markdown\Markdown;

$form = ActiveForm::begin(['id' => 'seqmen-id','type' => ActiveForm::TYPE_HORIZONTAL]);
	$SeqmenInput= FormGrid::widget([
		'id'=>'fg-seqmen',
		'model'=>$model,
		'form'=>$form,
		'autoGenerateColumns'=>true,
		'rows'=>[	
			[
				'columns'=>1,
				'attributes'=>[
					// NAMA JOBGRADE - Author: -ptr.nov-
					'SEQ_NM'=>[
						'label'=>'Jobgrade.NM',
						'type'=>Form::INPUT_TEXT, 
						'options'=>['placeholder'=>'Input Seqmen Name...'],
						'columnOptions'=>['colspan'=>6],
					],
					
					// DeSRIPTION JOBGRADE - Author: -ptr.nov-
					'SEQ_DCRP'=>[
						'label'=>'Description',
						'type'=>Form::INPUT_TEXTAREA, 
						'options'=>['placeholder'=>'Input Seqmen Description...'],
						'columnOptions'=>['colspan'=>6],
					],					
					// SHORT JOBGRADE - Author: -ptr.nov-
					'SORT'=>[
						'label'=>'Sort',
						'type'=>Form::INPUT_TEXT, 
						'options'=>['placeholder'=>'Input nilai Urutan...'],
						'columnOptions'=>['colspan'=>6],
					],					
				],
			],
			[
				/*SUBMMIT Action Author: -ptr.nov-*/
				'columns'=>1,
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

	/*Panel List Group*/
	echo Html::listGroup([
		 [
			 'content' => 'INPUT SEQMEN',
			 'url' => '#',
			 'badge' => '',
			 'active' => true
		 ],
		 [
			 'content' => $SeqmenInput,

		 ],
	]);
           
ActiveForm::end();

?>

