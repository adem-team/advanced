<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\doc\Docdba */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="docdba-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PARENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MDL_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MDL_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MDL_DB')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MDL_DB_ALIAS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MDL_TBL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MDL_KEY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MDL_FLD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MDL_CLS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MDL_LINK')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DSCRP')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'CREATED_DATE')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'CORP_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DEP_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'USER_CREATED')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SORT')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
