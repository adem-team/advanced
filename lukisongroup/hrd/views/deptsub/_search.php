<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\hrd\DeptsubSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deptsub-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'DEP_SUB_ID') ?>

    <?= $form->field($model, 'DEP_ID') ?>

    <?= $form->field($model, 'DEP_SUB_NM') ?>

    <?= $form->field($model, 'DEP_SUB_STS') ?>

    <?= $form->field($model, 'DEP_SUB_AVATAR') ?>

    <?php // echo $form->field($model, 'DEP_SUB_DCRP') ?>

    <?php // echo $form->field($model, 'SORT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
