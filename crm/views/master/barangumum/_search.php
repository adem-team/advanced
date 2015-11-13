<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\master\BarangumumSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barangumum-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'KD_BARANG') ?>

    <?= $form->field($model, 'NM_BARANG') ?>

    <?= $form->field($model, 'KD_TYPE') ?>

    <?= $form->field($model, 'KD_KATEGORI') ?>

    <?php // echo $form->field($model, 'KD_UNIT') ?>

    <?php // echo $form->field($model, 'KD_SUPPLIER') ?>

    <?php // echo $form->field($model, 'KD_DISTRIBUTOR') ?>

    <?php // echo $form->field($model, 'PARENT') ?>

    <?php // echo $form->field($model, 'HPP') ?>

    <?php // echo $form->field($model, 'HARGA') ?>

    <?php // echo $form->field($model, 'BARCODE') ?>

    <?php // echo $form->field($model, 'IMAGE') ?>

    <?php // echo $form->field($model, 'NOTE') ?>

    <?php // echo $form->field($model, 'KD_CORP') ?>

    <?php // echo $form->field($model, 'KD_CAB') ?>

    <?php // echo $form->field($model, 'KD_DEP') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'CREATED_BY') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'UPDATED_BY') ?>

    <?php // echo $form->field($model, 'UPDATED_AT') ?>

    <?php // echo $form->field($model, 'DATA_ALL') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
