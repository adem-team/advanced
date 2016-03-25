<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\ImportViewSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="import-view-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'TGL') ?>

    <?= $form->field($model, 'CUST_KD') ?>

    <?= $form->field($model, 'CUST_KD_ALIAS') ?>

    <?= $form->field($model, 'CUST_NM') ?>

    <?php // echo $form->field($model, 'KD_BARANG') ?>

    <?php // echo $form->field($model, 'KD_BARANG_ALIAS') ?>

    <?php // echo $form->field($model, 'NM_BARANG') ?>

    <?php // echo $form->field($model, 'SO_QTY') ?>

    <?php // echo $form->field($model, 'SO_TYPE') ?>

    <?php // echo $form->field($model, 'POS') ?>

    <?php // echo $form->field($model, 'KD_DIS') ?>

    <?php // echo $form->field($model, 'NM_DIS') ?>

    <?php // echo $form->field($model, 'USER_ID') ?>

    <?php // echo $form->field($model, 'UNIT_BARANG') ?>

    <?php // echo $form->field($model, 'UNIT_QTY') ?>

    <?php // echo $form->field($model, 'UNIT_BERAT') ?>

    <?php // echo $form->field($model, 'HARGA_PABRIK') ?>

    <?php // echo $form->field($model, 'HARGA_DIS') ?>

    <?php // echo $form->field($model, 'HARGA_SALES') ?>

    <?php // echo $form->field($model, 'HARGA_LG') ?>

    <?php // echo $form->field($model, 'NOTED') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
