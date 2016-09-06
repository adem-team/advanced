<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\CustomercallExpiredSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customercall-expired-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'ID_PRIORITASED') ?>

    <?= $form->field($model, 'ID_DETAIL') ?>

    <?= $form->field($model, 'CUST_ID') ?>

    <?= $form->field($model, 'BRG_ID') ?>

    <?php // echo $form->field($model, 'USER_ID') ?>

    <?php // echo $form->field($model, 'TGL_KJG') ?>

    <?php // echo $form->field($model, 'QTY') ?>

    <?php // echo $form->field($model, 'DATE_EXPIRED') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'CREATE_AT') ?>

    <?php // echo $form->field($model, 'UPDATE_AT') ?>

    <?php // echo $form->field($model, 'CREATE_BY') ?>

    <?php // echo $form->field($model, 'UPDATE_BY') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
