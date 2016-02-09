<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\Sot2 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sot2-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TGL')->textInput() ?>

    <?= $form->field($model, 'CUST_KD_ALIAS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_DIS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'USER_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_BARANG_ALIAS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NM_BARANG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UNIT_BARANG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UNIT_QTY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UNIT_BERAT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SO_TYPE')->textInput() ?>

    <?= $form->field($model, 'SO_QTY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HARGA_PABRIK')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HARGA_DIS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HARGA_SALES')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOTED')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'HARGA_LG')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
