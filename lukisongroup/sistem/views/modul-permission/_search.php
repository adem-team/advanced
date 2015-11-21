<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\system\erpmodul\MdlpermissionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mdlpermission-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'USER_ID') ?>

    <?= $form->field($model, 'MODUL_ID') ?>

    <?= $form->field($model, 'STATUS') ?>

    <?= $form->field($model, 'CREATE') ?>

    <?php // echo $form->field($model, 'EDIT') ?>

    <?php // echo $form->field($model, 'TOMBOL1') ?>

    <?php // echo $form->field($model, 'TOMBOL2') ?>

    <?php // echo $form->field($model, 'TOMBOL3') ?>

    <?php // echo $form->field($model, 'TOMBOL4') ?>

    <?php // echo $form->field($model, 'TOMBOL5') ?>

    <?php // echo $form->field($model, 'TOMBOL6') ?>

    <?php // echo $form->field($model, 'TOMBOL7') ?>

    <?php // echo $form->field($model, 'TOMBOL8') ?>

    <?php // echo $form->field($model, 'TOMBOL9') ?>

    <?php // echo $form->field($model, 'TOMBOL10') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
