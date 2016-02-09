<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termcustomers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="termcustomers-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName(),

    ]); ?>

    <?= $form->field($model, 'NM_TERM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_KD')->widget(Select2::classname(),[
  		'options'=>[  'placeholder' => 'Select Customers parent ...'
  		],
  		'data' => $dropparentkategori
  	]);?>

    <?= $form->field($model, 'CUST_KD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_SIGN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PRINCIPAL_KD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PRINCIPAL_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PRINCIPAL_SIGN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DIST_KD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DIST_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DIST_SIGN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DCRP_SIGNARURE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'PERIOD_START')->textInput() ?>

    <?= $form->field($model, 'PERIOD_END')->textInput() ?>

    <?= $form->field($model, 'TARGET_TEXT')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'TARGET_VALUE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'RABATE_CNDT')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'GROWTH')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TOP')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'CREATED_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATE_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
