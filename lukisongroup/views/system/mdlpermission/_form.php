<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\system\erpmodul\Mdlpermission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mdlpermission-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'USER_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MODUL_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'BTN_CREATE')->textInput() ?>

    <?= $form->field($model, 'BTN_EDIT')->textInput() ?>

    <?= $form->field($model, 'BTN_DELETE')->textInput() ?>

    <?= $form->field($model, 'BTN_VIEW')->textInput() ?>

    <?= $form->field($model, 'BTN_PROCESS1')->textInput() ?>

    <?= $form->field($model, 'BTN_PROCESS2')->textInput() ?>

    <?= $form->field($model, 'BTN_PROCESS3')->textInput() ?>

    <?= $form->field($model, 'BTN_PROCESS4')->textInput() ?>

    <?= $form->field($model, 'BTN_PROCESS5')->textInput() ?>

    <?= $form->field($model, 'BTN_SIGN1')->textInput() ?>

    <?= $form->field($model, 'BTN_SIGN2')->textInput() ?>

    <?= $form->field($model, 'BTN_SIGN3')->textInput() ?>
	
	<?= $form->field($model, 'BTN_SIGN4')->textInput() ?>
 	
    <?= $form->field($model, 'BTN_SIGN5')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
