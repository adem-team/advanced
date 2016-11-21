<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\money\MaskMoney;
use yii\helpers\Url;
use kartik\widgets\DepDrop;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Kota */
/* @var $form yii\widgets\ActiveForm */

 
?>

<div class="kota-form">

    <?php $form = ActiveForm::begin([
        'id' => $model->formName(),
        'enableClientValidation' => true,
        'enableAjaxValidation'=>true,
        'validationUrl'=>Url::toRoute('/purchasing/salesman-order/valid-alias-header'),
    ]); ?>

    

    <?= $form->field($model, 'parent_cusid')->widget(Select2::classname(), [
        'data' => $data_cus,
        'options' => [
        'placeholder' => 'Pilih parent Customers..'],
        'pluginOptions' => [
            'allowClear' => true,
             ],


    ])?>

    <?= $form->field($model, 'CUST_ID')->widget(DepDrop::classname(), [
          'options' => [
         'placeholder' => 'Select Customers'],
         'type' => DepDrop::TYPE_SELECT2,
          'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
          'pluginOptions'=>[
              'depends'=>['soheader-parent_cusid'],
              'url' => Url::to(['/purchasing/salesman-order/lis-child-cus']),
            'loadingText' => 'Loading data ...',
          ]
     ]); ?>

    <?= $form->field($model, 'TGL')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => ' pilih ...'],
            'pluginOptions' => [
               'autoclose'=>true,
               // 'format' => 'dd-mm-yyyy',
            ],

        'pluginEvents'=>[
               'show' => "function(e) {errror}",
                   ],

    ]); ?>


     <?= $form->field($model, 'USER_SIGN1')->widget(Select2::classname(), [
        'data' => $data_user,
        'options' => [
        'placeholder' => 'Pilih User..'],
        'pluginOptions' => [
            'allowClear' => true,
             ],


    ])?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

