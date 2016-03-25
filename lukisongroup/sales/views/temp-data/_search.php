<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\TempDataSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="temp-data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'TGL') ?>

    <?= $form->field($model, 'CUST_KD') ?>

    <?= $form->field($model, 'CUST_KD_ALIAS') ?>

    <?= $form->field($model, 'CUST_NM') ?>

    <?php // echo $form->field($model, 'CUST_NM_ALIAS') ?>

    <?php // echo $form->field($model, 'ITEM_ID') ?>

    <?php // echo $form->field($model, 'ITEM_ID_ALIAS') ?>

    <?php // echo $form->field($model, 'ITEM_NM') ?>

    <?php // echo $form->field($model, 'ITEM_NM_ALIAS') ?>

    <?php // echo $form->field($model, 'QTY_PCS') ?>

    <?php // echo $form->field($model, 'QTY_UNIT') ?>

    <?php // echo $form->field($model, 'DIS_KD') ?>

    <?php // echo $form->field($model, 'DIS_NM') ?>

    <?php // echo $form->field($model, 'SO_TYPE') ?>

    <?php // echo $form->field($model, 'POS') ?>

    <?php // echo $form->field($model, 'USER_ID') ?>

    <?php // echo $form->field($model, 'NOTED') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
