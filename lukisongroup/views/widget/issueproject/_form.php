<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\Issueproject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="issueproject-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PARENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ISSUE_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ISSUE_DESC')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'PRIORITY')->textInput() ?>

    <?= $form->field($model, 'CLOSE_DATETIME')->textInput() ?>

    <?= $form->field($model, 'USER_CREATED')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'CORP_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DEP_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OPEN_DATETIME')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
