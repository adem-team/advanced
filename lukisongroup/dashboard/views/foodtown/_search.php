<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\dashboard\models\FoodtownSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="foodtown-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Id') ?>

    <?= $form->field($model, 'Val_Nm') ?>

    <?= $form->field($model, 'Val_1') ?>

    <?= $form->field($model, 'UPDT') ?>

    <?= $form->field($model, 'Val_Json') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
