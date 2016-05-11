<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\password\PasswordInput;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model lukisongroup\models\system\erpmodul\Mdlpermission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mdlpermission-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName(),
      'enableClientValidation'=>true
    ]); ?>

     <?= $form->field($model, 'username')->textInput()?>

     <!-- $form->field($model, 'password_hash')->passwordInput()?> -->

      <?= $form->field($model, 'password_hash')->widget(PasswordInput::classname()) ?>

      <?= $form->field($model, 'EMP_ID')->widget(Select2::classname(), [
    'data' => $data,
    'language' => 'en',
    'options' => ['placeholder' => 'Select...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]) ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
