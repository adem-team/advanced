<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\money\MaskMoney;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Kota */
/* @var $form yii\widgets\ActiveForm */

 
?>

<div class="kota-form">

    <?php $form = ActiveForm::begin([
        'id' => $model->formName(),
        'enableClientValidation' => true,
        'enableAjaxValidation'=>true,
        'validationUrl'=>Url::toRoute('/purchasing/salesman-order/valid-alias-barang'),
    ]); ?>

    <?=  $form->field($model, 'KODE_REF')->textInput(['value'=>$kode_som,'readonly'=>true]); ?>

    <?= $form->field($model, 'KD_BARANG')->widget(Select2::classname(), [
        'data' => $data_barang,
        'options' => [
         // 'id'=>"slect",
        'placeholder' => 'Pilih Barang..'],
        'pluginOptions' => [
            'allowClear' => true,
             ],


    ])->label('NM Barang');?>



    <?= $form->field($model, 'SO_QTY')->widget(MaskMoney::classname(), [
            'pluginOptions' => [
                'allowNegative' => false
            ]
        ])->label('Qty') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

