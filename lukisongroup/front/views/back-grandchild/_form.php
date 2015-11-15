<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use lukisongroup\front\models\Parents;
use yii\helpers\ArrayHelper;
use kartik\select2\select2;
use yii\helpers\Url;






/* @var $this yii\web\View */
/* @var $model lukisongroup\grandchild\models\Grandchild */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grandchild-form">

    <?php $form = ActiveForm::begin(); ?>

    
     <?php
  
     echo $form->field($model,'CHILD_ID')->dropDownList(ArrayHelper::map(Parents::find()->asArray()->all(), 'parent_id', 'parent'),['id'=>'cat-id'] );
        
 
   
      echo $form->field($model, 'PARENT_ID')->widget(\kartik\depdrop\DepDrop::classname(), [
      'options'=>['id'=>'subcat-id'],
      'pluginOptions'=>[
        'depends'=>['cat-id'],
        'placeholder'=>'Select...',
        'url'=>Url::to(['get-child'])
    ]
]); 
    ?>

    <?= $form->field($model, 'GRANDCHILD')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
