<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Kota */
/* @var $form yii\widgets\ActiveForm */

 
?>

<div class="kota-form">

    <?php $form = ActiveForm::begin([
        'id' => $model->formName(),
        'enableClientValidation' => true,
    ]); ?>

    <?=  $form->field($model, 'KODE_REF')->textInput(['value'=>$model->KD_SO,'readonly'=>true]); ?>

     <?= $form->field($model, 'TGL_KIRIM')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => ' pilih ...'],
            'pluginOptions' => [
               'autoclose'=>true,
               'format' => 'yyyy-mm-dd',
            ],

        'pluginEvents'=>[
               'show' => "function(e) {errror}",
                   ],

    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

