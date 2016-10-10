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
         [
            'contentBefore'=>'<legend class="text-info"><small>Planning Date</small></legend>',
            'attributes'=>[       // 2 column layout
                 'PLAN_DATE1'=>['type'=>Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\DateTimePicker', 'hint'=>'Planning Start'],
               'PLAN_DATE2'=>['type'=>Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\DateTimePicker', 'hint'=>'Planning End'],
            ]
        ],
         [
            'contentBefore'=>'<legend class="text-info"><small>Destination and User CC</small></legend>',
            'attributes'=>[       // 2 column layout
                 'USER_CC'=>['type'=>Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','items'=>$dropemploy],
               'DESTINATION_TO'=>['type'=>Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','items'=>$dropemploy],
            ]
        ],

     ],
]);
	

echo Html::button('Submit', ['type'=>'button', 'class'=>'btn btn-primary']);
ActiveForm::end();