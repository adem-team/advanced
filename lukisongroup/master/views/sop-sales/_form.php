<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\label\LabelInPlace;
use lukisongroup\master\models\Kategoricus;
use lukisongroup\master\models\Province;
use lukisongroup\master\models\Kota;
use yii\web\JsExpression;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\DepDrop;
// use kartik\money\MaskMoney;
/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\SopSalesHeader */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sop-sales-header-form">

    <?php $form = ActiveForm::begin([
        'id'=>$model->formName(),
        'enableClientValidation' => true,
        // 'enableAjaxValidation'=>true,
    ]); ?>

     <!-- $form->field($model, 'TGL')->textInput() ?> -->

    <?= $form->field($model, 'TGL')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter date start ...'],
                'pluginOptions' => [
                            'todayHighlight' => true,
                            'autoclose'=>true,
                              'format' => 'yyyy-m-dd'
                        ],
                        'pluginEvents'=>[
                            'show' => "function(e) {show}",
                        ],
                ]) ?>

     <!-- $form->field($model, 'STT_DEFAULT')->textInput() ?> -->

     <?= $form->field($model, 'SOP_TYPE')->widget(Select2::classname(),[
        'options'=>[  'placeholder' => 'Select...'
        ],
        'data' =>$data_type_sales
    ]);?>

    <?= $form->field($model, 'parent_kategori')->widget(Select2::classname(),[
        'options'=>[  'placeholder' => 'Select...'
        ],
        'data' =>$data_parent_kategori
    ]);?>

    <?=  $form->field($model, 'KATEGORI')->widget(DepDrop::classname(), [
      'options' => [//'id'=>'customers-cust_ktg',
      'placeholder' => 'Select Customers kategory'],
     'type' => DepDrop::TYPE_SELECT2,
     'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
     'pluginOptions'=>[
         'depends'=>['sopsalesheader-parent_kategori'],
         'url' => Url::to(['/master/sop-sales/lisdata']),
       'loadingText' => 'Loading data ...',
     ]
    ]) ?>

   <!--   $form->field($model, 'BOBOT_PERCENT')->widget(MaskMoney::classname(), [
    'pluginOptions' => [
        // 'prefix' => '$ ',
        'suffix' => ' %',
         'precision' => 1, 
        'allowNegative' => false
    ]
]) ?> -->

    
    <!-- $form->field($model, 'KATEGORI')->textInput(['maxlength' => true]) ?> -->

    <!-- $form->field($model, 'BOBOT_PERCENT')->textInput() ?> -->

     <!-- $form->field($model, 'TARGET_MONTH')->textInput() ?> -->

     <!-- $form->field($model, 'TARGET_DAY')->textInput() ?> -->

     <!-- $form->field($model, 'TTL_DAYS')->textInput() ?> -->

     <!-- $form->field($model, 'TARGET_UNIT')->textInput(['maxlength' => true]) ?> -->


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
