<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Customerskat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customerskat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CUST_KD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_KD_ALIAS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_GRP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_KTG')->textInput() ?>

    <?= $form->field($model, 'JOIN_DATE')->textInput() ?>

    <?= $form->field($model, 'MAP_LAT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MAP_LNG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PIC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALAMAT')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'TLP1')->textInput() ?>

    <?= $form->field($model, 'TLP2')->textInput() ?>

    <?= $form->field($model, 'FAX')->textInput() ?>

    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'WEBSITE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'NPWP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STT_TOKO')->textInput() ?>

    <?= $form->field($model, 'DATA_ALL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAB_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CORP_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATED_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATED_AT')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
