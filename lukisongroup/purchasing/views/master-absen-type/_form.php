<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterAbsenType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-absen-type-form">

    <?php $form = ActiveForm::begin();
    
    echo '<table class="table table-striped table-bordered">';
        echo '<tr><td>Start Date</td><td>';
        echo $form->field($model, 'StartAbsen')->textInput(['maxlength' => 2 ,'style'=> 'width:200px;']) ;
    echo '</td></tr>';
  
        echo '<tr><td>End Date</td>';
        echo '<td>';
       echo $form->field($model, 'EndAbsen')->textInput(['maxlength' => 2, 'style'=> 'width:200px;']) ;
       echo '</td></tr>';
    
    echo '</table>';
?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['master-absen-type/index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
