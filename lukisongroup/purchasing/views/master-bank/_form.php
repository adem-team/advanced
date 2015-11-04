<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\master\models\MasterBankGroup;
use app\master\models\MasterBank;
use kartik\widgets\Select2;
//use conquer\select2\Select2Widget;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterBank */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-bank-form">

    <?php $form = ActiveForm::begin(); ?>
           
    <table class="table table-striped table-bordered">
        <tr>
             <td style="width: 200px;">Bank Nama </td>
             <td>
                <?= $form->field($model, 'BankName')->textInput(['maxlength'=>50,'style'=> 'width:400px;']) ;?>
             </td>
        </tr
   
         <tr>
            <td>Bank Group Nama </td>
            <td>
                <?=$form->field($model, 'BankGroupID')->widget(Select2::classname(),
                     [
                        'options' => ['placeholder' => 'Select BankGroupName ...','style'=>'width:200px;'],
                        'data'=> arrayhelper::map(MasterBankgroup::find()->all(),'BankGroupID','BankGroupName'),
                        'pluginOptions' => [
                        'allowClear' => true
                      ],
    
                    ] );?>
            </td>
  
             </td>
        </tr>
        
        
   <?php
    
       if (! $model->isNewRecord )
    {
              echo '<tr><td style="padding-right:20px;padding-bottom:20px;">Status</td>';
              echo '<td style="padding-right:20px;padding-bottom:5px;">';
              echo $form->field($model, 'isActive')->checkbox() ;
              echo '</td></tr>';
    }
              
             ?>
    </table>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['master-bank/index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
