<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\roadsales\models\SalesRoadHeader */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-road-header-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'USER_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CASE_ID')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'CASE_NOTE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'LAT')->textInput() ?>

    <?= $form->field($model, 'LAG')->textInput() ?>

    <?= $form->field($model, 'CREATED_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
