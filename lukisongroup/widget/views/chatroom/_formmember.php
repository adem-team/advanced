<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Groupchat */
/* @var $form yii\widgets\ActiveForm */
 
?>

<div class="groupchat-form">

    <?php $form = ActiveForm::begin([
		'id'=> 'createmember',
	'enableClientValidation' => true,
	]); ?>

    
  

    <?= $form->field($model, 'GROUP_NM')->textInput(['maxlength' => true])->label('Member') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
