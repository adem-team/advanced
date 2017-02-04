<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\purchasing\models\warehouse\HeaderDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="header-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID')->textInput() ?>

    <?= $form->field($model, 'TGL')->textInput() ?>

    <?= $form->field($model, 'KD_SJ')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_SO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_INVOICE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_FP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ETD')->textInput() ?>

    <?= $form->field($model, 'ETA')->textInput() ?>

    <?= $form->field($model, 'KD_BARANG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NM_BARANG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QTY_UNIT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QTY_PCS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HARGA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DISCOUNT')->textInput() ?>

    <?= $form->field($model, 'PAJAK')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DELIVERY_COST')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'CREATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATE_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATE_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
