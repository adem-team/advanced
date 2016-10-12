<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\TimePicker;


/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Notulen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notulen-form">

    <?php $form = ActiveForm::begin([
        'id'=>$model->formName(),
        // 'enableClientValidation' => true,
    ]); ?>

   <?= $form->field($model, 'TIME_START')->widget(TimePicker::classname(), []) ?>

   <?= $form->field($model, 'TIME_END')->widget(TimePicker::classname(), []) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
