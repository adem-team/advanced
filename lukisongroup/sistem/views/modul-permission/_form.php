<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\system\erpmodul\Mdlpermission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mdlpermission-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName(),
      'enableClientValidation'=>true
    ]); ?>


     <?= $form->field($model, 'password_hash')->passwordInput()?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
