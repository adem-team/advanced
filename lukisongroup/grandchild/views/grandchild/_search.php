<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\grandchild\models\GrandchildSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grandchild-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'GRANDCHILD_ID') ?>

    <?= $form->field($model, 'CHILD_ID') ?>

    <?= $form->field($model, 'PARENT_ID') ?>

    <?= $form->field($model, 'GRANDCHILD') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
