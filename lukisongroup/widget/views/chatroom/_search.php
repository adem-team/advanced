<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\ChatroomSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chatroom-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'PARENT') ?>

    <?= $form->field($model, 'SORT') ?>

    <?= $form->field($model, 'GROUP_ID') ?>

    <?= $form->field($model, 'GROUP_NM') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
