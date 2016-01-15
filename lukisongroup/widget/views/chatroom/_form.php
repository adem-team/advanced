<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Groupchat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="groupchat-form">

    <?php $form = ActiveForm::begin([
	'id'=> 'create',
	'enableClientValidation' => true,
	]); ?>

     <!--$form->field($model, 'PARENT')->textInput(['maxlength' => true]) ?>-->

     <!--$form->field($model, 'SORT')->textInput(['maxlength' => true]) ?>-->

     <!--$form->field($model, 'GROUP_ID')->textInput(['maxlength' => true]) ?>-->

    <?= $form->field($model, 'GROUP_NM')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
