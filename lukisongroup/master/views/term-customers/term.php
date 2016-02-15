<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use lukisongroup\master\models\Termgeneral;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termgeneral */
/* @var $form yii\widgets\ActiveForm */

$data = Termgeneral::find()->all();
$to = "ID";
$from = "SUBJECT";
?>

<div class="termgeneral-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName()
    ]); ?>


    <?= $form->field($model, 'SUBJECT')->widget(Select2::classname(),[
      'options'=>[  'placeholder' => 'Select  ...'
      ],
      'data' =>$model->data($data,$to,$from)
    ]);?>


    <?= $form->field($model, 'ISI_TERM')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
