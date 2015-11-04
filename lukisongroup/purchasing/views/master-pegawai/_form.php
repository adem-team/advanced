<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\master\models\MasterJobdesc;
use app\master\models\MasterStatuspernikahan;
use app\master\models\MasterBank;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\master\models\MasterPegawai */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-pegawai-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
    
    $masterjob = MasterJobDesc::find()->select('ID,Description')->all();
    $masterstatusnikah = MasterStatusPernikahan::find()->select('ID,Description')->all();
    $masterbank = MasterBank::find()->select('ID,BankName')->all();
    ?>
    <table class="table table-striped table-bordered">
        <tr>
            <td>
                NIK
            </td>
            <td>
                <?= $form->field($model, 'NIK')->textInput(['maxlength' => 20]) ?>
            </td>
        </tr>
        <tr>
            <td>
                Nama
            </td>
            <td>
                <?= $form->field($model, 'Nama')->textInput(['maxlength' => 100]) ?>    
            </td>
        </tr>
        <tr>
            <td>
                Job Desc
            </td>
            <td>
                <?= $form->field($model, 'IDJobDesc')->dropDownList(ArrayHelper::map($masterjob,'ID','Description'),['prompt' => 'Select Job Desc']); ?>
            </td>
        </tr>
        <tr>
            <td>
                Gender
            </td>
            <td>
                <?= $form->field($model, 'gender')->dropDownList(['f'=>'Female','m'=>'Male'],['prompt'=>'Select Gender']) ?>
            </td>
        </tr>
        <tr>
            <td>
                Status Pernikahan
            </td>
            <td>
                <?= $form->field($model, 'IDStatusNikah')->dropDownList(ArrayHelper::map($masterstatusnikah,'ID','Description'),['prompt' => 'Select Status Pernikahan']) ?>
            </td>
        </tr>
        <tr>
            <td>
                Address
            </td>
            <td>
               <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?> 
            </td>
        </tr>
        <tr>
            <td>
                City
            </td>
            <td>
                <?= $form->field($model, 'city')->textInput(['maxlength' => 100]) ?>
            </td>
        </tr>
        <tr>
            <td>
                Zip
            </td>
            <td>
                <?= $form->field($model, 'zip')->textInput(['maxlength' => 5]) ?>
            </td>
        </tr>
        <tr>
            <td>
                Phone
            </td>
            <td>
                <?= $form->field($model, 'phone')->textInput(['maxlength' => 15]) ?>
            </td>
        </tr>
         <tr>
            <td>
                Mobile 1
            </td>
            <td>
                <?= $form->field($model, 'mobile1')->textInput(['maxlength' => 15]) ?>
            </td>
        </tr>
         <tr>
            <td>
                Mobile 2
            </td>
            <td>
                <?= $form->field($model, 'mobile2')->textInput(['maxlength' => 15]) ?>
            </td>
        </tr>
         <tr>
            <td>
                Bank
            </td>
            <td>
               <?= $form->field($model, 'BankID')->dropDownList(ArrayHelper::map($masterbank,'ID','BankName'),['prompt' => 'Select Bank']) ?> 
            </td>
        </tr>
         <tr>
            <td>
                Bank Account Number
            </td>
            <td>
               <?= $form->field($model, 'BankAccNumber')->textInput(['maxlength' => 20]) ?> 
            </td>
        </tr>
         <tr>
            <td>
                NPWP
            </td>
            <td>
                <?= $form->field($model, 'NPWP')->textInput(['maxlength' => 20]) ?>
            </td>
        </tr>
        <?php if(!$model->isNewRecord){ ?>
         <tr>
            <td>
                Is Active
            </td>
            <td>
               <?= $form->field($model, 'IsActive')->checkbox(); ?> 
            </td>
        </tr>
        <?php } ?>

    </table>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['master-pegawai/index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
