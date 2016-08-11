<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use lukisongroup\master\models\DraftPlan;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="draft-plan-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(),
        'enableClientValidation' => true,
        'enableAjaxValidation'=>true,
        'validationUrl'=>Url::toRoute('/master/draft-plan/valid-user')   

    ]); ?>

     
	 <?= $form->field($model, 'SCL_NM')->widget(Select2::classname(), [
                'data' => $geo,
                'options' => ['placeholder' => 'Pilih ...'],
                'pluginOptions' => [
                    'allowClear' => true
                     ],
                ])->label('List Geografis');?>


    <?= $form->field($model, 'USER_ID')->widget(Select2::classname(), [
                'data' => $user,
                'options' => ['placeholder' => 'Pilih User ...'],
                'pluginOptions' => [
                    'allowClear' => true
                    ],
                ])->label('Pilih User');?>

           
					

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Create', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
