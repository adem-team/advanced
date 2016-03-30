<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\purchasing\models\stck\StockClosingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-closing-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'TGL') ?>

    <?= $form->field($model, 'TYPE') ?>

    <?= $form->field($model, 'KD_JUST') ?>

    <?= $form->field($model, 'KD_DEPT') ?>

    <?php // echo $form->field($model, 'PIC') ?>

    <?php // echo $form->field($model, 'ID_BARANG') ?>

    <?php // echo $form->field($model, 'NM_BARANG') ?>

    <?php // echo $form->field($model, 'UNIT') ?>

    <?php // echo $form->field($model, 'UNIT_NM') ?>

    <?php // echo $form->field($model, 'UNIT_QTY') ?>

    <?php // echo $form->field($model, 'UNIT_WIGHT') ?>

    <?php // echo $form->field($model, 'QTY') ?>

    <?php // echo $form->field($model, 'NOTE') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

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
