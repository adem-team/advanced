<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\salesmd\models\RekapStockVisit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rekap-stock-visit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CUST_KD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_BARANG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NM_BARANG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TGL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'POS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SO_TYPE')->textInput() ?>

    <?= $form->field($model, 'USER_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w0')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w6')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w7')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w8')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w9')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w10')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w11')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w12')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w13')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w14')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w15')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w16')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w17')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w18')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w19')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w20')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w21')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w22')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w23')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w24')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w25')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w26')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w27')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w28')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w29')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w30')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w31')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w32')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w33')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w34')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w35')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w36')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w37')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w38')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w39')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w40')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w41')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w42')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w43')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w44')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w45')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w46')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w47')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w48')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w49')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w50')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w51')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w52')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'w53')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
