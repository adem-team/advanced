<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterTunjanganpotongan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-tunjanganpotongan-form">

    <?php $form = ActiveForm::begin();

     echo '<table>';
        echo '<tr>'
    . '         <td style="padding-right:20px; padding-top:10px;"> Description</td>';
     echo '<td>';
//     echo $form->field($model, 'Description')->dropDownList(['T' => 'tunjangan', 'P' => 'potongan'],['name'=>'drop']); 
        echo $form->field($model, 'Description')->textInput(['maxlength' => 100]) ;
    echo '</td></tr>';
     if (! $model->isNewRecord )
    {
        echo '<tr><td style="padding-right:20px;padding-bottom:20px;">Status</td>';
        echo '<td style="padding-right:20px;padding-bottom:5px;">';
       echo $form->field($model, 'IsActive')->checkbox() ;
       echo '</td></tr>';
    }
    
    echo '</table>';
//    
//    
// print_r($model);
//die();   
    if(Yii::$app->controller->action->id === 'tuncreate') {
  echo' <div class="form-group">';
     echo Html::submitButton($model->isNewRecord ? 'create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
     echo Html::a('Back', ['master-tunjanganpotongan/tunjangan'], ['class' => 'btn btn-success']);
     
      
 
    echo'</div>';
}
else{
    echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    echo Html::a('Back', ['master-tunjanganpotongan/potongan'], ['class' => 'btn btn-success']);
  
}
    ?>
   
    
    
    <?php ActiveForm::end(); ?>

</div>

</div>
