<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProggresjobSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proggresjob-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'proggres_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'modul') ?>

    <?= $form->field($model, 'judul') ?>

    <?= $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'start_data') ?>

    <?php // echo $form->field($model, 'end_date') ?>

    <?php // echo $form->field($model, 'proggres') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
