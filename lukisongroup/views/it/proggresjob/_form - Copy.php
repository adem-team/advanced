<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use dosamigos\ckeditor\CKEditor;
use dosamigos\datetimepicker\DateTimePicker;
//use dosamigos\datepicker\DatePicker;

use kartik\editable\Editable;
use kartik\widgets\DepDrop;
$this->sideMenu = 'itprogrammer';

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'options'=>['enctype'=>'multipart/form-data']]);
?>
<div class="row">
    <div class="col-md-8">
        <?php
        echo  FormGrid::widget([
            'model'=>$model,
            'form'=>$form,
            'autoGenerateColumns'=>true,
            //'ajax' => true,
            'rows'=>[
                [
                    //'columns'=>2,
                    'contentBefore'=>'<div class="box box-warning box-solid "> <div class="box-header with-border ">Manage Jobs</div></div>',
                    //autoGenerateColumns'=>false,
                    'columns'=>4,
                    'attributes'=>[
                        'employe_identity' => [
                            'columns'=>4,
                            'label'=>'Entry Jobs :',
                            'attributes'=>[

                                'proggres_id'=>[
                                    'type'=>Form::INPUT_TEXT,
                                    'options'=>[
                                        'placeholder'=>'Enter First Name...',
                                        'readonly'=>true,
                                        ],
                                    'columnOptions'=>['colspan'=>1],
                                    'hint'=>'Job.Id ',
                                ],
                                'modul'=>[
                                    'type'=>Form::INPUT_TEXT,
                                    'options'=>['placeholder'=>'Enter First Name...'],
                                    'columnOptions'=>['colspan'=>2],
                                ],
                                'judul'=>[
                                    'hint'=>'Job Titles ',
                                    'type'=>Form::INPUT_TEXT,
                                    'options'=>['placeholder'=>'Enter First Name...'],
                                    'columnOptions'=>['colspan'=>3],

                                ],
                                'user_id'=>[
                                    'type'=>Form::INPUT_TEXT,

                                    'options'=>[
                                        'placeholder'=>'Enter First Name...',
                                        'value'=>Yii::$app->user->identity->id,
                                    ],
                                    'hint'=>'Author By',
                                    'columnOptions'=>['colspan'=>1],
                                ],
                                'keterangan'=>[
                                    'type'=>Form::INPUT_WIDGET,
                                    'widgetClass'=>'dosamigos\ckeditor\CKEditor',
                                        'options' => [
                                            //'rows' => 6,
                                            'preset' => 'basic'
                                        ],
                                    'columnOptions'=>['colspan'=>4],
                                    'hint'=>'Job Descriptions ',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    //'columns'=>2,
                    //'contentBefore'=>'<div class="box box-warning box-solid "> <div class="box-header with-border ">CORPORATE IDENTITY</div></div>',

                    //autoGenerateColumns'=>false,
                    'attributes'=>[
                        'employe_identity' => [
                            'label'=>'Employee.ID :',
                            'columns'=>4,
                            'attributes'=>[
                                'start_data'=>[
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
                                    'columnOptions'=>['colspan'=>2  ],
                                ],
                                'end_date'=>[
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
                                    'columnOptions'=>['colspan'=>2  ],
                                ],
                                'proggres'=>[
                                    'type'=>Form::INPUT_TEXT,
                                    'options'=>['placeholder'=>'Enter First Name...'],
                                    'columnOptions'=>['colspan'=>2],
                                ],
                                'status'=>[
                                    'type'=>Form::INPUT_TEXT,
                                    'options'=>['placeholder'=>'Enter First Name...'],
                                    'columnOptions'=>['colspan'=>2],
                                ],
                            ]
                        ],
                    ],
                ],
                [ //-Action Author: -ptr.nov-
                    'attributes'=>[
                        'actions'=>[    // embed raw HTML content
                            'type'=>Form::INPUT_RAW,
                            'value'=>  '<div style="text-align: left; margin-top: 20px; margin-bottom: 20px;  margin-left: 20px">' .
                                Html::resetButton('Reset', ['class'=>'btn btn-default']) . ' ' .
                                Html::submitButton('Submit', ['class'=>'btn btn-primary']) .

                                '</div>'
                        ],
                    ],
                ],
            ]
        ]);
ActiveForm::end();
?>
    </div>
</div>

























?>
<div class="proggresjob-form">
 
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true,'value'=>Yii::$app->user->identity->id]) ?>


    <?php echo $form->field($model, 'modul')->dropDownList(['GOSEN' => 'GOSEN', 'ESM' => 'ESM', 'SSS' => 'SSS'],['prompt'=>'--Pilih Modul--']); ?>
    <?php echo $form->field($model, 'modul')->dropDownList(['GOSEN' => 'GOSEN', 'ESM' => 'ESM', 'SSS' => 'SSS'],['prompt'=>'--Pilih Dept--']); ?>

    <?= $form->field($model, 'judul')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'proggres_id')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'keterangan')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

    <?= $form->field($model, 'start_data')->widget(
        DateTimePicker::className(), [
        'template' => '{addon}{input}',
        'clientOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd'
        ]
     ]);?>

    <?= $form->field($model, 'end_date')->widget(
        DateTimePicker::className(), [
        'template' => '{addon}{input}',
        'clientOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd'
        ]
     ]);?>


    <?= $form->field($model, 'proggres')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'status')->dropDownList(['1' => '1', '2' => '2'],['prompt'=>'--Pilih Status--']); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
