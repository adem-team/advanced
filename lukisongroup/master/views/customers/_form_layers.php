<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Kategoricus;
use kartik\widgets\TouchSpin;

/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Kategoricus */
/* @var $form yii\widgets\ActiveForm */
?>



<div class="kategoricus-form">

    <?php $form = ActiveForm::begin([
	  'id'=>$model->formName(),
      'enableClientValidation' => true,

	]); ?>


     <?= $form->field($model, 'LAYER_NM')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'JEDA_PEKAN')->widget(TouchSpin::classname(), [
          'options' => ['placeholder' => 'jeda pekan ...'],
        ])?>

      <?= $form->field($model, 'DCRIPT')->textArea(['rows' => 6]) ?>


    <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
