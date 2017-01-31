<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\marketing\models\SalesPromo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-promo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CUST_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PROMO')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'TGL_START')->textInput() ?>

    <?= $form->field($model, 'TGL_END')->textInput() ?>

    <?= $form->field($model, 'OVERDUE')->textInput() ?>

    <?= $form->field($model, 'MEKANISME')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'KOMPENSASI')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'KETERANGAN')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'CREATED_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATED_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATED_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
