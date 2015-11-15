<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterJobDesc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-job-desc-form">

    <?php $form = ActiveForm::begin();
    
    echo '<table class="table table-striped table-bordered">';
        echo '<tr><td>Description</td><td>';
        echo $form->field($model, 'Description')->textarea(['maxlength' => 100,'style'=> 'width:400px;','rows'=>'2']) ;
    echo '</td></tr>';
  
        if (! $model->isNewRecord )
    {
        echo '<tr><td>Status</td>';
        echo '<td>';
       echo $form->field($model, 'IsActive')->checkbox() ;
       echo '</td></tr>';
    }
    
    echo '</table>';
?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['master-job-desc/index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
