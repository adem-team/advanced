<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use lukisongroup\back\models\Parents;
use lukisongroup\back\models\ParentsSearch;
use kartik\widgets\DepDrop;
use kartik\select2\select2;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $model lukisongroup\backs\models\Posting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posting-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

     <?php
  
        echo $form->field($model,'PARENT')->dropDownList(ArrayHelper::map(Parents::find()->asArray()->all(), 'parent_id', 'parent'),['id'=>'cat-id'] );



        echo $form->field($model, 'CHILD')->widget(\kartik\depdrop\DepDrop::classname(), [
        'options'=>['id'=>'subcat-id'],
        'pluginOptions'=>[
        'depends'=>['cat-id'],
        'placeholder'=>'Select...',
        'url'=>Url::to(['get-child'])
        ]
        ]); 
        echo $form->field($model, 'GRANDCHILD')->widget(DepDrop::classname(), [
        'pluginOptions'=>[
        'depends'=>['cat-id', 'subcat-id'],
        'placeholder'=>'Select...',
        'url'=>Url::to(['get-grandchild'])
        ]
        ]);
    ?>

    <?= $form->field($model, 'JUDUL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'RESUME_EN')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>
    

   <?= $form->field($model, 'RESUME_ID')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

     <?php /*echo $form->field($model, 'image')->widget(FileInput::classname(), [
    'options'=>['accept'=>'image/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]
    ]); */
    ?>
   <?= $form->field($model,'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
