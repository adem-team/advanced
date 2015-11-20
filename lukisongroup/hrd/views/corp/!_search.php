<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\hrd\CorpSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="corp-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'CORP_ID') ?>

    <?= $form->field($model, 'CORP_NM') ?>

    <?= $form->field($model, 'CORP_STS') ?>

    <?= $form->field($model, 'CORP_AVATAR') ?>

    <?= $form->field($model, 'CORP_DCRP') ?>

    <?php // echo $form->field($model, 'SORT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
