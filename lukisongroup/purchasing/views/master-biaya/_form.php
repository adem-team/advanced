<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterTunjanganpotongan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-Biayapotongan-form">

    <?php $form = ActiveForm::begin();

   echo '<table class="table table-striped table-bordered">';
        echo '<tr>'
    . '         <td style="padding-right:20px; padding-top:10px;"> Description</td>';
                 echo '<td>';
//     echo $form->field($model, 'Description')->dropDownList(['T' => 'tunjangan', 'P' => 'potongan'],['name'=>'drop']); 
                        echo $form->field($model, 'Description')->textInput(['maxlength' => 50,'style'=> 'width:400px;','rows'=>3]) ;
                echo '</td>';
        echo'</tr>';
     if (! $model->isNewRecord )
    {
        echo '<tr>'
         . '<td style="padding-right:20px;padding-bottom:20px;">Status</td>';
            echo '<td style="padding-right:20px;padding-bottom:5px;">';
            echo $form->field($model, 'IsActive')->checkbox() ;
            echo '</td>';
        echo '</tr>';
    }
    
    
  echo '</table>';
//    
//    
// print_r($model);
//die();   
    if(Yii::$app->controller->action->id === 'tuncreate') {
  echo' <div class="form-group">';
     echo Html::submitButton($model->isNewRecord ? 'create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
     echo Html::a('Back', ['master-biaya/biayatunjangan'], ['class' => 'btn btn-success']);
     
      
 
    echo'</div>';
}
else{
  
    echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    echo Html::a('Back', ['master-biaya/biayapotongan'], ['class' => 'btn btn-success']);
  
}
    ?>
   
    
    
    <?php ActiveForm::end(); ?>

</div>

</div>
