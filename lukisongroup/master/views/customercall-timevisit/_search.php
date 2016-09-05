<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\CustomercallTimevisitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customercall-timevisit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'TGL') ?>

    <?= $form->field($model, 'STS') ?>

    <?= $form->field($model, 'CUST_ID') ?>

    <?= $form->field($model, 'CUST_NM') ?>

    <?php // echo $form->field($model, 'USER_ID') ?>

    <?php // echo $form->field($model, 'USER_NM') ?>

    <?php // echo $form->field($model, 'SCDL_GROUP') ?>

    <?php // echo $form->field($model, 'SCDL_GRP_NM') ?>

    <?php // echo $form->field($model, 'ABSEN_MASUK') ?>

    <?php // echo $form->field($model, 'ABSEN_KELUAR') ?>

    <?php // echo $form->field($model, 'ABSEN_TOTAL') ?>

    <?php // echo $form->field($model, 'GPS_GRP_LAT') ?>

    <?php // echo $form->field($model, 'GPS_GRP_LONG') ?>

    <?php // echo $form->field($model, 'ABSEN_MASUK_LAT') ?>

    <?php // echo $form->field($model, 'ABSEN_MASUK_LONG') ?>

    <?php // echo $form->field($model, 'ABSEN_MASUK_DISTANCE') ?>

    <?php // echo $form->field($model, 'ABSEN_KELUAR_LAT') ?>

    <?php // echo $form->field($model, 'ABSEN_KELUAR_LONG') ?>

    <?php // echo $form->field($model, 'ABSEN_KELUAR_DISTANCE') ?>

    <?php // echo $form->field($model, 'CUST_CHKIN') ?>

    <?php // echo $form->field($model, 'CUST_CHKOUT') ?>

    <?php // echo $form->field($model, 'LIVE_TIME') ?>

    <?php // echo $form->field($model, 'JRK_TEMPUH') ?>

    <?php // echo $form->field($model, 'JRK_TEMPUH_PULANG') ?>

    <?php // echo $form->field($model, 'GPS_CUST_LAT') ?>

    <?php // echo $form->field($model, 'GPS_CUST_LAG') ?>

    <?php // echo $form->field($model, 'LAT_CHEKIN') ?>

    <?php // echo $form->field($model, 'LONG_CHEKIN') ?>

    <?php // echo $form->field($model, 'DISTANCE_CHEKIN') ?>

    <?php // echo $form->field($model, 'LAT_CHEKOUT') ?>

    <?php // echo $form->field($model, 'LONG_CHEKOUT') ?>

    <?php // echo $form->field($model, 'DISTANCE_CHEKOUT') ?>

    <?php // echo $form->field($model, 'UPDATE_BY') ?>

    <?php // echo $form->field($model, 'UPDATE_AT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
