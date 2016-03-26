<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\SecheduleHeader */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sechedule-header-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TGL1')->textInput() ?>

    <?= $form->field($model, 'TGL2')->textInput() ?>

    <?= $form->field($model, 'SCDL_GROUP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'USER_ID')->textInput(['maxlength' => true]) ?>

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
