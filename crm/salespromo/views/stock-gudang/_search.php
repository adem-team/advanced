<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model crm\salespromo\models\Stock_gudangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-gudang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'WAKTU') ?>

    <?= $form->field($model, 'CUST_KD') ?>

    <?= $form->field($model, 'CUST_NM') ?>

    <?= $form->field($model, 'KD_BARANG') ?>

    <?php // echo $form->field($model, 'NM_BARANG') ?>

    <?php // echo $form->field($model, 'STOCK_GUDANG') ?>

    <?php // echo $form->field($model, 'PRODAK_LINE') ?>

    <?php // echo $form->field($model, 'CORP_ID') ?>

    <?php // echo $form->field($model, 'KD_DISTRIBUTOR') ?>

    <?php // echo $form->field($model, 'KD_SUBDIST') ?>

    <?php // echo $form->field($model, 'CREATED_BY') ?>

    <?php // echo $form->field($model, 'UPDATED_BY') ?>

    <?php // echo $form->field($model, 'UPDATED_TIME') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
