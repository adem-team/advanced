<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\password\PasswordInput;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Scheduleheader */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scheduleheader-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName(),
      'enableClientValidation'=>true
    ]); ?>

    <?= $form->field($model, 'username')->textInput()->label('User Login') ?>

    <?= $form->field($user_profile, 'NM_FIRST')->textInput()->label('Nama') ?>

     <?= $form->field($user_profile, 'HP')->textInput()->label('Nomer HP') ?>


    <?= $form->field($model, 'password_hash')->widget(PasswordInput::classname(), []) ?>

    <?php echo $form->field($model, 'POSITION_LOGIN')->dropDownList([1 => 'SALESMAN', 2 => 'SALES PROMOTION',3=>'CUSTOMER',4 => 'DISTRIBUTOR' , 5=>'FACTORY PABRIK',6 => 'OUTSOURCE']); ?>

    <?php echo $form->field($model, 'POSITION_ACCESS')->dropDownList([1 => 'Manager', 2 => 'Sales Operational',3=>'Spg Operational']); ?>


    <?php
      if(!$model->IsNewRecord)
      {
        echo $form->field($model, 'status')->dropDownList(['' => ' -- Silahkan Pilih --', '1' => 'Tidak Aktif', '10' => 'Aktif']);
      }

     ?>

    <?= $form->field($model, 'POSITION_SITE')->hiddenInput(['value'=>'CRM'])->label(false) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
