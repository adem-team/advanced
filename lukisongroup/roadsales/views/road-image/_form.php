<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\roadsales\models\SalesRoadImage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-road-image-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID_ROAD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IMGBASE64')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'IMG_NAME')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'CREATED_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
