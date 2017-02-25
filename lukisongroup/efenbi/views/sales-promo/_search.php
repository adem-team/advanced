<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\marketing\models\SalesPromoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-promo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'CUST_ID') ?>

    <?= $form->field($model, 'CUST_NM') ?>

    <?= $form->field($model, 'PROMO') ?>

    <?= $form->field($model, 'TGL_START') ?>

    <?php // echo $form->field($model, 'TGL_END') ?>

    <?php // echo $form->field($model, 'OVERDUE') ?>

    <?php // echo $form->field($model, 'MEKANISME') ?>

    <?php // echo $form->field($model, 'KOMPENSASI') ?>

    <?php // echo $form->field($model, 'KETERANGAN') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'CREATED_BY') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'UPDATED_BY') ?>

    <?php // echo $form->field($model, 'UPDATED_AT') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
