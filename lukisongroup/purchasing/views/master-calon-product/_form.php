<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\master\models\MasterJobDesc;
use app\master\models\MasterStatuspernikahan;
use app\master\models\MasterBank;
use yii\helpers\ArrayHelper;
use bootui\datetimepicker\Datepicker;
/* @var $this yii\web\View */
/* @var $model app\master\models\MasterCalonProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-calon-product-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php
    $masterjob = MasterJobDesc::find()->select('IDJobDesc,Description')->all();
    $masterstatusnikah = MasterStatusPernikahan::find()->select('IDStatusPernikahan,Description')->all();
    $masterbank = MasterBank::find()->select('BankID,BankName')->all();
    
    ?>
  
     <table class="table table-striped table-bordered">
         <tr>
             <td style="width: 200px"> Nama Calon Product</td>
             <td>
     <?= $form->field($model, 'Nama')->textInput(['maxlength'=>100, 'style'=> 'width:400px;']) ?>
             </td>
         </tr>
              <tr>
             <td> Job Description</td>
             <td>
     <?= $form->field($model, 'IDJobDesc')->dropDownList(ArrayHelper::map($masterjob,'IDJobDesc','Description'),['prompt' => 'Select Job Desc', 'style'=> 'width:200px;']);  ?>
             </td>
         </tr>
          <tr>
             <td>Gender </td>
             <td>
     <?= $form->field($model, 'Gender')->dropDownList(['f'=>'Female','m'=>'Male'],['prompt'=>'Select Gender', 'style'=> 'width:200px;']) ?>
              </td>
         </tr>
           <tr>
             <td> KTP </td>
             <td>
   <?= $form->field($model, 'KTP')->textInput(['maxlength'=>50,'style'=> 'width:400px;']) ?>
                 </td>
         </tr>
          <tr>
             <td>KTP Expired date</td>
             <td>
    <?= Datepicker::widget([
                'name' => 'KTPExpireddate',
                'options' => ['class' => 'form-control', 'style'=> 'width:180px;'],
                'addon' => ['prepend' => 'Expired Date'],
                'format' => 'YYYY-MM-DD',
            ]); ?>
                  </td>
         </tr>
            <tr>
             <td> SIM </td>
             <td>
  <?= $form->field($model, 'SIM')->textInput(['maxlength'=>50, 'style'=> 'width:400px;']) ?>
                </td>
         </tr>
          <tr>
             <td> SIM Expire Date </td>
             <td>
       <?= Datepicker::widget([
                'name' => 'SIMExpireDate',
                'options' => ['class' => 'form-control', 'style'=> 'width:180px;'],
                'addon' => ['prepend' => 'Expired Date'],
                'format' => 'YYYY-MM-DD',
            ]); ?>
                  </td>
         </tr>
          <tr>
             <td> Status Nikah </td>
             <td>
      
         <?= $form->field($model, 'IDstatusnikah')->dropDownList(ArrayHelper::map($masterstatusnikah,'IDStatusPernikahan','Description'),['prompt' => 'Select status nikah', 'style'=> 'width:200px;']);  ?>
                 </td>
         </tr>
             <tr>
             <td> Address </td>
             <td>
        <?= $form->field($model, 'Address')->textarea(['maxlength'=>255 ,'style'=> 'width:400px;','rows'=>2]) ?>
              </td>
         </tr>
             <tr>
             <td> Refferensi Desc </td>
             <td>
        <?= $form->field($model, 'RefferensiDesc')->textarea(['maxlength'=>50, 'style'=> 'width:400px;','rows'=>2]) ?>
             </td>
         </tr>
          <tr>
             <td> City </td>
             <td>
         <?= $form->field($model, 'City')->textInput(['maxlength'=>100,'style'=> 'width:400px;']) ?>
              </td>
         </tr>
           <tr>
             <td> Zip </td>
             <td>
        <?= $form->field($model, 'Zip')->textInput(['maxlength'=>5, 'style'=> 'width:130px;']) ?>
              </td>
         </tr>
          <tr>
             <td> Phone</td>
             <td>
        <?= $form->field($model, 'Phone')->textInput(['maxlength'=>15,'style'=> 'width:400px;']) ?>
               </td>
         </tr>
          <tr>
             <td>Mobile 1</td>
             <td>
        <?= $form->field($model, 'Mobile1')->textInput(['maxlength'=>15,'style'=> 'width:400px;']) ?>
              </td>
         </tr>
          <tr>
             <td> Mobile 2</td>
             <td>
        <?= $form->field($model, 'Mobile2')->textInput(['maxlength'=>15,'style'=> 'width:400px;']) ?>
               </td>
         </tr>
          <tr>
             <td> Bank Nama</td>
             <td>
        <?= $form->field($model, 'BankID')->dropDownList(ArrayHelper::map($masterbank,'BankID','BankName'),['prompt' => 'Select bank name', 'style'=> 'width:200px;']); ?>
             <tr>
             <td>Bank Acc Number </td>
             <td>
        <?= $form->field($model, 'BankAccNumber')->textInput([ 'maxlength'=>20,'style'=> 'width:400px;']) ?>
                  </td>
         </tr>
          <tr>
             <td> NPWP </td>
             <td>
        <?= $form->field($model, 'NPWP')->textInput([ 'maxlength'=>20,'style'=> 'width:400px;']) ?>
                  </td>
         </tr>
         <?php
         if(! $model->isNewRecord)
         {
             echo '<tr>';
             echo '<td> IsActive </td>';
             echo '<td>';
             echo $form->field($model, 'IsActive')->checkbox(); 
             echo '</td>';
             echo '</tr>';
         }
         ?>
         <tr>
             <td> Status </td>
             <td>
        <?= $form->field($model, 'Status')->dropDownList(['prompt'=>'Pilih Status'],['style'=> 'width:200px;']) ?>
                  </td>
         </tr>
     </table>

    <div class="form-group">
       
         <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
              <?= Html::a('Back', ['master-calon-product/index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
