<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\warehouse\models\TypeKtgSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="type-ktg-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'TYPE') ?>

    <?= $form->field($model, 'TYPE_KTG') ?>

    <?= $form->field($model, 'TYPE_NM') ?>

    <?= $form->field($model, 'DSCRPT') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
