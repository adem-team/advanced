<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\TempData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="temp-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TGL')->textInput() ?>

    <?= $form->field($model, 'CUST_KD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_KD_ALIAS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_NM_ALIAS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_ID_ALIAS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_NM_ALIAS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QTY_PCS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QTY_UNIT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DIS_KD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DIS_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SO_TYPE')->textInput() ?>

    <?= $form->field($model, 'POS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'USER_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOTED')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
