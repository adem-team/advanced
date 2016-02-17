<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use lukisongroup\hrd\models\Jobgrade;
use kartik\widgets\Select2;
use kartik\label\LabelInPlace;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termgeneral */
/* @var $form yii\widgets\ActiveForm */
$config = ['template'=>"{input}\n{error}\n{hint}"];
$data = Jobgrade::find()->all();
$to = "JOBGRADE_ID";
$from = "JOBGRADE_NM";
?>

<div class="termgeneral-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName()
    ]); ?>


    <?= $form->field($model, 'DIST_NM', $config)->widget(LabelInPlace::classname())?>


    <?= $form->field($model, 'JABATAN_DIST', $config)->widget(LabelInPlace::classname())?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
