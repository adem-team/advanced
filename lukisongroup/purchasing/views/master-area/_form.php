<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterArea */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-area-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <table class="table table-striped table-bordered">
        <tr>
            <td>Area ID</td>
            <td>Auto Generate</td>
        </tr>
        
        <tr>
            <td>
                Area Name
            </td>
            <td>
               <?= $form->field($model, 'Description')
                    ->textInput(['maxlength' => 100,'style'=>'width:400px']) ?> 
            </td>
        </tr>
        <?php
        
//        if(!$model->isNewRecord)
//        {
//            
//            echo "<tr>
//            <td>
//                Is Active
//            </td>
//            <td>".
//                 $form->field($model, 'IsActive')->checkbox()."
//            </td>
//        </tr>";
//        }
        
        ?>
        
    </table>
    
     <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['master-area/index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
