<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;


/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Notulen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notulen-form">

    <?php $form = ActiveForm::begin([
        'id'=>$model->formName(),
        'enableClientValidation' => true,
    ]); ?>


     <?= $form->field($model, 'PIC')->widget(Select2::classname(), [
            'data' => $data_emp,
            'options' => ['placeholder' => 'Select ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

    <?= $form->field($model, 'DESCRIPTION')->textArea(['maxlength' => true]) ?>

     <?php echo $form->field($model, 'DATE_LINE')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => '...'],
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'autoclose'=>true,
                        'format' => 'yyyy-m-dd'
                    ],
                        'pluginEvents'=>[
                            'show' => "function(e) {show}",
                    ],
            ])->label('Timeline');
        ?>

   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
