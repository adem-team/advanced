<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlanProses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="draft-plan-proses-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PROSES_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DCRIPT')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
