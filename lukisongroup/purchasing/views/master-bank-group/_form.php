<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterBankgroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-bankgroup-form">

    <?php $form = ActiveForm::begin(); ?>

     <table class="table table-striped table-bordered" >
        <tr>
             <td style="padding-right:10px;">Bank Group Name</td>
             <td>
                <?= $form->field($model, 'BankGroupName')->textInput(['maxlength' => 50,'style'=> 'width:400px;'])->hint('masukan nama bank group')->label('Bank group name') ;?>
            </td>
        </tr>
    
   
    <?php
    if (! $model->isNewRecord )
    {
    ?>
    <tr>
        <td>
            Status
        </td>
        <td>
        <?= $form->field($model, 'IsActive')->checkbox() ?>
        </td>
    </tr>
  
    <?php
    }
    ?>
    </table>
    
  
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::a('Back', ['master-bank-group/index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
