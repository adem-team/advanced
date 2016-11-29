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
use kartik\widgets\TouchSpin
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

     <?= $form->field($model, 'SCORE_RSLT')->widget(Select2::classname(),[
        'options'=>[  'placeholder' => 'Select...'
        ],
        'data' =>$score
    ]);?>


     <?= $form->field($model, 'SCORE_PERCENT_MIN')->widget(TouchSpin::classname(), [
            'options' => ['placeholder' => 'Enter rating 0 to 100...'],
            'pluginOptions'=>['postfix' => '%'],
        ]) ?>

        <?= $form->field($model, 'SCORE_PERCENT_MAX')->widget(TouchSpin::classname(), [
            'options' => ['placeholder' => 'Enter rating 0 to 100...'],
             'pluginOptions'=>['postfix' => '%'],
        ]) ?>
     

    

  

    
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
