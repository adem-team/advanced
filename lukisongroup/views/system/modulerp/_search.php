<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\system\erpmodul\ModulerpSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modulerp-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'MODUL_ID') ?>

    <?= $form->field($model, 'MODUL_NM') ?>

    <?= $form->field($model, 'MODUL_DCRP') ?>

    <?= $form->field($model, 'MODUL_STS') ?>

    <?= $form->field($model, 'SORT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
