<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlanDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="draft-plan-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'TGL') ?>

    <?= $form->field($model, 'CUST_ID') ?>

    <?= $form->field($model, 'USER_ID') ?>

    <?= $form->field($model, 'SCDL_GROUP') ?>

    <?php // echo $form->field($model, 'NOTE') ?>

    <?php // echo $form->field($model, 'LAT') ?>

    <?php // echo $form->field($model, 'LAG') ?>

    <?php // echo $form->field($model, 'RADIUS') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'CREATE_BY') ?>

    <?php // echo $form->field($model, 'CREATE_AT') ?>

    <?php // echo $form->field($model, 'UPDATE_BY') ?>

    <?php // echo $form->field($model, 'UPDATE_AT') ?>

    <?php // echo $form->field($model, 'CHECKIN_TIME') ?>

    <?php // echo $form->field($model, 'CHECKOUT_LAT') ?>

    <?php // echo $form->field($model, 'CHECKOUT_LAG') ?>

    <?php // echo $form->field($model, 'CHECKOUT_TIME') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
