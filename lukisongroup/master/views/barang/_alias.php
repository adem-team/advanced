<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use lukisongroup\master\models\barangalias;
use lukisongroup\master\models\Distributor;
use yii\helpers\Url;
use kartik\widgets\Select2;
use kartik\label\LabelInPlace;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Barangalias */
/* @var $form yii\widgets\ActiveForm */


$datadis = Distributor::find()->where('STATUS<>3')
                              ->all();
$todis = 'KD_DISTRIBUTOR';
$fromdis = 'NM_DISTRIBUTOR';
$config = ['template'=>"{input}\n{error}\n{hint}"]
?>

<div class="barangalias-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName(),
      'enableClientValidation'=>true,
      'enableAjaxValidation'=>true
    ]); ?>

    <?= $form->field($model, 'KD_PARENT',['template' => "{input}"])->hiddenInput(['value'=>$parent,'readonly' => true]) ?>

    <?= $form->field($model, 'KD_BARANG')->textInput(['value'=>$id->KD_BARANG,'readonly'=>true])->label('KODE_BARANG') ?>

    <?= $form->field($model, 'NM_BARANG')->textInput(['value'=>$id->NM_BARANG,'readonly'=>true]) ?>

    <?= $form->field($model, 'KD_ALIAS',$config)->widget(LabelInPlace::classname()); ?>

    <?= $form->field($model, 'KD_DISTRIBUTOR')->widget(Select2::classname(), [
      'data' => $model->data($datadis,$todis,$fromdis),
      'options' => ['placeholder' => 'Pilih KD DISTRIBUTOR ...'],
      'pluginOptions' => [
        'allowClear' => true
         ],
    ]);?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
