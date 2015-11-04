<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\system\erpmodul\Modulerp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modulerp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MODUL_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MODUL_DCRP')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'MODUL_STS')->textInput() ?>

    <?= $form->field($model, 'SORT')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
