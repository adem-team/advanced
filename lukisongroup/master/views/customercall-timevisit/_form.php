<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\CustomercallTimevisit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customercall-timevisit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TGL')->textInput() ?>

    <?= $form->field($model, 'STS')->textInput() ?>

    <?= $form->field($model, 'CUST_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'USER_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'USER_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SCDL_GROUP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SCDL_GRP_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ABSEN_MASUK')->textInput() ?>

    <?= $form->field($model, 'ABSEN_KELUAR')->textInput() ?>

    <?= $form->field($model, 'ABSEN_TOTAL')->textInput() ?>

    <?= $form->field($model, 'GPS_GRP_LAT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'GPS_GRP_LONG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ABSEN_MASUK_LAT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ABSEN_MASUK_LONG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ABSEN_MASUK_DISTANCE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ABSEN_KELUAR_LAT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ABSEN_KELUAR_LONG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ABSEN_KELUAR_DISTANCE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_CHKIN')->textInput() ?>

    <?= $form->field($model, 'CUST_CHKOUT')->textInput() ?>

    <?= $form->field($model, 'LIVE_TIME')->textInput() ?>

    <?= $form->field($model, 'JRK_TEMPUH')->textInput() ?>

    <?= $form->field($model, 'JRK_TEMPUH_PULANG')->textInput() ?>

    <?= $form->field($model, 'GPS_CUST_LAT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'GPS_CUST_LAG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LAT_CHEKIN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LONG_CHEKIN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DISTANCE_CHEKIN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LAT_CHEKOUT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LONG_CHEKOUT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DISTANCE_CHEKOUT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATE_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
