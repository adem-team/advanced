<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftGeo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="draft-geo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'GEO_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'GEO_DCRIP')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'CUST_MAX_NORMAL')->textInput() ?>

    <?= $form->field($model, 'CUST_MAX_LAYER')->textInput() ?>

    <?= $form->field($model, 'START_LAT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'START_LONG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'CREATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATE_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATE_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
