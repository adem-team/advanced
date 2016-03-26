<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\SecheduleHeaderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sechedule-header-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'TGL1') ?>

    <?= $form->field($model, 'TGL2') ?>

    <?= $form->field($model, 'SCDL_GROUP') ?>

    <?= $form->field($model, 'USER_ID') ?>

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
