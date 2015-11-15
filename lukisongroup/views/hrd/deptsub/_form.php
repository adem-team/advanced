<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="deptsub-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'DEP_SUB_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DEP_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DEP_SUB_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DEP_SUB_STS')->textInput() ?>

    <?= $form->field($model, 'DEP_SUB_AVATAR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DEP_SUB_DCRP')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'SORT')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
