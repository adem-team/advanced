<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\purchasing\models\HeaderDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="header-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'TGL') ?>

    <?= $form->field($model, 'KD_SJ') ?>

    <?= $form->field($model, 'KD_SO') ?>

    <?= $form->field($model, 'KD_INVOICE') ?>

    <?php // echo $form->field($model, 'KD_FP') ?>

    <?php // echo $form->field($model, 'ETD') ?>

    <?php // echo $form->field($model, 'ETA') ?>

    <?php // echo $form->field($model, 'KD_BARANG') ?>

    <?php // echo $form->field($model, 'NM_BARANG') ?>

    <?php // echo $form->field($model, 'QTY_UNIT') ?>

    <?php // echo $form->field($model, 'QTY_PCS') ?>

    <?php // echo $form->field($model, 'HARGA') ?>

    <?php // echo $form->field($model, 'DISCOUNT') ?>

    <?php // echo $form->field($model, 'PAJAK') ?>

    <?php // echo $form->field($model, 'DELIVERY_COST') ?>

    <?php // echo $form->field($model, 'NOTE') ?>

    <?php // echo $form->field($model, 'CREATE_BY') ?>

    <?php // echo $form->field($model, 'CREATE_AT') ?>

    <?php // echo $form->field($model, 'UPDATE_BY') ?>

    <?php // echo $form->field($model, 'UPDATE_AT') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
