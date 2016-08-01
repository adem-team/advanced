<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlanGroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="draft-plan-group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'SCDL_GROUP') ?>

    <?= $form->field($model, 'TGL_START') ?>

    <?= $form->field($model, 'SCL_NM') ?>

    <?= $form->field($model, 'GEO_ID') ?>

    <?= $form->field($model, 'LAYER_ID') ?>

    <?php // echo $form->field($model, 'DAY_ID') ?>

    <?php // echo $form->field($model, 'DAY_VALUE') ?>

    <?php // echo $form->field($model, 'USER_ID') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'CREATED_BY') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'UPDATED_BY') ?>

    <?php // echo $form->field($model, 'UPDATED_AT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
