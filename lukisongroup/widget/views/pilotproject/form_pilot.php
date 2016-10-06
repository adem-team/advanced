<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use yii\helpers\Html;
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);

echo FormGrid::widget([
    'model'=>$model,
    'form'=>$form,
    'autoGenerateColumns'=>true,
    'rows'=>[
        [
            'contentBefore'=>'<legend class="text-info"><small>Schedule</small></legend>',
            'attributes'=>[       // 2 column layout
                'PILOT_NM'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter...']],
                'DSCRP'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter...']],
            ]
        ],
     ],
]);
	

echo Html::button('Submit', ['type'=>'button', 'class'=>'btn btn-primary']);
ActiveForm::end();