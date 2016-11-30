<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;


/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Notulen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notulen-form">

    <?php $form = ActiveForm::begin([
        'id'=>$model->formName(),
        // 'enableClientValidation' => true,
    ]); ?>

   <?= $form->field($model, 'ROOM')->textArea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
