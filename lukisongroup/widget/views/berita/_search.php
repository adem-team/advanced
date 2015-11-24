<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\BeritaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="berita-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'KD_BERITA') ?>

    <?= $form->field($model, 'JUDUL') ?>

    <?= $form->field($model, 'ISI') ?>

    <?= $form->field($model, 'KD_CORP') ?>

    <?php // echo $form->field($model, 'KD_CAB') ?>

    <?php // echo $form->field($model, 'KD_DEP') ?>

    <?php // echo $form->field($model, 'DATA_PICT') ?>

    <?php // echo $form->field($model, 'DATA_FILE') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'CREATED_ATCREATED_BY') ?>

    <?php // echo $form->field($model, 'CREATED_BY') ?>

    <?php // echo $form->field($model, 'UPDATE_AT') ?>

    <?php // echo $form->field($model, 'DATA_ALL') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
