<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterVendor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-vendor-form">

    <?php $form = ActiveForm::begin(); ?>

   
<table class="table table-striped table-bordered">
    <tr>    
        <td style="width: 200px"> Nama Vendor</td>
        <td>
    <?= $form->field($model, 'VendorName')->textInput(['maxlength'=>100,'style'=> 'width:400px;']) ?>
        </td>
    </tr>
      <tr>    
        <td> Address </td>
        <td>
    <?= $form->field($model, 'Address')->textarea(['maxlength'=>255,'style'=> 'width:400px;','rows'=>2]) ?>
              </td>
    </tr>
      <tr>    
        <td> City </td>
        <td>
    <?= $form->field($model, 'City')->textInput(['maxlength'=>100,'style'=> 'width:400px;']) ?>
             </td>
    </tr>
       <tr>    
        <td> Zip</td>
        <td>
    <?= $form->field($model, 'Zip')->textInput(['maxlength' =>5,'style'=> 'width:120px;']) ?>
              </td>
    </tr>
          <tr>    
        <td> Phone </td>
        <td>
    <?= $form->field($model, 'Phone')->textInput(['maxlength'=>15,'style'=> 'width:400px;']) ?>
            </td>
    </tr>
            <tr>    
        <td> Fax </td>
        <td>
    <?= $form->field($model, 'Fax')->textInput(['maxlength'=>100,'style'=> 'width:400px;']) ?>
                </td>
    </tr>
          <tr>    
        <td> Nama Contact</td>
        <td>
    <?= $form->field($model, 'ContactName')->textInput(['maxlength'=>50,'style'=> 'width:400px;']) ?>
             </td>
    </tr>
           <tr>    
        <td> Contact Phone </td>
        <td>
    <?= $form->field($model, 'ContactPhone')->textInput(['maxlength'=>15,'style'=> 'width:400px;']) ?>
              </td>
    </tr>
          <tr>    
        <td> Contact Emai </td>
        <td>
    <?= $form->field($model, 'ContactEmail')->input('email',['maxlength'=>100,'style'=> 'width:400px;'])  ?>
            </td>
    </tr>
    <?php
                if (! $model->isNewRecord)
     {
      echo '<tr> ';   
      echo '<td> Is Active </td>';
      echo ' <td>';
          echo  $form->field($model, 'IsActive')->checkbox();
          echo '</td>'; 
          echo '</tr>';
    }
    ?>
</table>

    <div class="form-group">
       
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
             <?= Html::a('Back', ['master-vendor/index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
