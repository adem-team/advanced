<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model lukisongroup\roadsales\models\SalesRoadImage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-road-image-form">

     <?php $form = ActiveForm::begin([
        'id'=>$model->formName(),
        'enableClientValidation'=>true,

    ]); ?>



  <?= $form->field($model, 'ID_ROAD')->widget(Select2::classname(), [
        'data' => $data_road,
        'options' => ['placeholder' => 'Select a Road ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Road') ?>


    <?= $form->field($model, 'IMGBASE64')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
    ]) ?>

    <?= $form->field($model, 'IMG_NAME')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
