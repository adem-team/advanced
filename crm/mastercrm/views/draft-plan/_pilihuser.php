<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use crm\mastercrm\models\DraftPlan;
use lukisongroup\sistem\models\Userlogin;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlan */
/* @var $form yii\widgets\ActiveForm */
 
?>

<div class="draft-plan-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName() 

    ]); ?>

     
	  <?= $form->field($model, 'SCL_NM')->widget(Select2::classname(), [
                'data' => $geo,
                'options' => ['placeholder' => 'Pilih ...'],
                'pluginOptions' => [
                    'allowClear' => true
                     ],
                ])->label('Geografis');?>

               <!--    $form->field($model, 'SCL_NM')->textInput(['value' =>$scl_nm,'readonly'=>true]) ?> -->


    <?= $form->field($model, 'USER_ID')->widget(Select2::classname(), [
                'data' => $user,
                'options' => ['placeholder' => 'Pilih User ...'],
                'pluginOptions' => [
                    'allowClear' => true
                    ],
                ])->label('Pilih User');?>

           
					

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Create', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary','data-confirm'=>'apakah anda yakin ingin ganti Group?']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
