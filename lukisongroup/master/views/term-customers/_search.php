<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\TermcustomersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="termcustomers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_TERM') ?>

    <?= $form->field($model, 'NM_TERM') ?>

    <?= $form->field($model, 'CUST_KD') ?>

    <?= $form->field($model, 'CUST_NM') ?>

    <?= $form->field($model, 'CUST_SIGN') ?>

    <?php // echo $form->field($model, 'PRINCIPAL_KD') ?>

    <?php // echo $form->field($model, 'PRINCIPAL_NM') ?>

    <?php // echo $form->field($model, 'PRINCIPAL_SIGN') ?>

    <?php // echo $form->field($model, 'DIST_KD') ?>

    <?php // echo $form->field($model, 'DIST_NM') ?>

    <?php // echo $form->field($model, 'DIST_SIGN') ?>

    <?php // echo $form->field($model, 'DCRP_SIGNARURE') ?>

    <?php // echo $form->field($model, 'PERIOD_START') ?>

    <?php // echo $form->field($model, 'PERIOD_END') ?>

    <?php // echo $form->field($model, 'TARGET_TEXT') ?>

    <?php // echo $form->field($model, 'TARGET_VALUE') ?>

    <?php // echo $form->field($model, 'RABATE_CNDT') ?>

    <?php // echo $form->field($model, 'GROWTH') ?>

    <?php // echo $form->field($model, 'TOP') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'CREATED_BY') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'UPDATE_BY') ?>

    <?php // echo $form->field($model, 'UPDATE_AT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
