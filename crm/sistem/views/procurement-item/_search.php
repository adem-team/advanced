<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\front\models\Procurement_itemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procurement-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'PARENT') ?>

    <?= $form->field($model, 'SORT_PATENT') ?>

    <?= $form->field($model, 'PRC_BRG_ID') ?>

    <?= $form->field($model, 'PRC_BRG_NM') ?>

    <?php // echo $form->field($model, 'PRC_BRG_SPEK') ?>

    <?php // echo $form->field($model, 'PRC_BRG_DCRP') ?>

    <?php // echo $form->field($model, 'GROUP') ?>

    <?php // echo $form->field($model, 'TGL_START') ?>

    <?php // echo $form->field($model, 'TGL_END') ?>

    <?php // echo $form->field($model, 'CREATED_BY') ?>

    <?php // echo $form->field($model, 'UPDATED_BY') ?>

    <?php // echo $form->field($model, 'UPDATED_TIME') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
