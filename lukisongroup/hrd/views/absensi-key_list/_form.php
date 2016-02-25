<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Key_list */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="key-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'FunctionKey')->textInput() ?>

    <?= $form->field($model, 'FunctionKeyNM')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
