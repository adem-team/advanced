<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\purchasing\models\stck\StockReture */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-reture-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TGL')->textInput() ?>

    <?= $form->field($model, 'TYPE')->textInput() ?>

    <?= $form->field($model, 'KD_REF')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_PO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_SPL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_DEPT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PIC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_BARANG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NM_BARANG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UNIT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UNIT_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UNIT_QTY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UNIT_WIGHT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QTY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'CREATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATE_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATE_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
