<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Berita */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="berita-form">

    <?php $form = ActiveForm::begin(); ?>

   

    <?= $form->field($model, 'JUDUL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ISI')->textarea(['rows' => 6]) ?>



    <?= $form->field($model, 'KD_CAB')->textInput(['maxlength' => true]) ?>

  

    <?= $form->field($model, 'DATA_PICT')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'DATA_FILE')->textarea(['rows' => 6]) ?>
	
    <?= $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ?>

    <?= $form->field($model, 'CREATED_ATCREATED_BY')->textInput() ?>


    <?= $form->field($model, 'DATA_ALL')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
