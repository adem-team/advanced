<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\master\models\MasterBank;
use app\master\models\MasterJobDesc;
use app\master\models\MasterClass;
use app\master\models\MasterStatusPernikahan;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\master\models\Masterproduct */
/* @var $form yii\widgets\ActiveForm */
$script = <<<SKRIPT
       
        
 function val()
        
        {  
            var j =document.getElementById("job").options[document.getElementById("job").selectedIndex].text;
               
            if( j == 'DRIVER')
            {
                $( "#cimd" ).show("slow");
                $( "#cim" ).show("slow");
                $( "#simc" ).show("slow");
                $( "#simb" ).show("slow");
            }
            else
            {
                $( "#cimd" ).hide("slow");
                $( "#cim" ).hide("slow");
                $( "#simc" ).hide( "slow" );
                $( "#simb" ).hide( "slow" );
            }
        };
        
$( "#job" ).change( val);
        
         function cek()
        {
            var j =document.getElementById("job").options[document.getElementById("job").selectedIndex].text;
            var b=document.getElementById("simc").value;
            var c=document.getElementById("simb").value;
            if( j == 'DRIVER'&& b == '')
            {
                alert("Tolong di isi Sim dan SIM Expired Date karena Product "+j);
                return false;
            }
            else if(j == 'DRIVER'&& c=='')
            {
                alert('Tolong di isi Sim dan SIM Expired Date karena Product '+j);
                return false;
        
             }
        }
        
$( "#btn" ).click( cek );

SKRIPT;

$this->registerJs($script);
?>

<div class="masterproduct-form">

    <?php $form = ActiveForm::begin(); ?>
 <?php
     

	  
    $masterjob = MasterJobDesc::find()->select('IDJobDesc,Description')->all();
    $masterstatusnikah = MasterStatusPernikahan::find()->select('IDStatusPernikahan,Description')->all();
    $masterbank = MasterBank::find()->select('mb.BankGroupID,mbg.BankGroupName,mb.BankID,mb.BankName')
                                    ->from('MasterBankGroup mbg')
                                    ->innerJoin('MasterBank mb','mb.BankGroupID=mbg.BankGroupID')
//                                    ->joinWith('idbankgrup')
//                                    ->orderBy('MasterBank.BankGroupID, MasterBankGroup.BankGroupID')
//                                    ->where(['BankGroupID'=>001])
          
                                    ->all();
    $MasterClass=MasterClass::find()->select('ClassID,ClassDesc')->all();
    ?>

    
     <table class="table table-striped table-bordered">
      <tr>
          <td style="width: 200px;"> 
              Nama 
          </td>
          <td>
            <?= $form->field($model, 'Nama')->textInput(['maxlength'=>100, 'style'=> 'width:250px;']) ?>
      </tr>
     
     <tr>
         <td> Job Desc  </td>
         <td>
            <?= $form->field($model, 'IDJobDesc')->dropDownList(ArrayHelper::map($masterjob,'IDJobDesc','Description'),['prompt' => 'Select Job Desc','style'=> 'width:200px;','id'=>'job'])->label('JobDesc'); ?>
         </td>
     </tr>
      <tr>
          <td> Gender </td>
          <td>
            <?= $form->field($model, 'Gender')->dropDownList(['f'=>'Female','m'=>'Male'],['prompt'=>'Select Gender', 'style'=> 'width:200px;']) ?>
          </td>
      </tr>
          
      <tr>
          <td> KTP </td>
          <td>
                <?= $form->field($model, 'KTP')->textInput(['maxlength'=>50 ,'style'=> 'width:400px;']) ?>
          </td>
       </tr>
        <tr>
          <td> KTP Expired date </td>
          <td>
            <?php echo DatePicker::widget([
                                'model' => $model, 
                                'attribute' => 'KTPExpiredDate',
                                'options' => ['placeholder' => 'Enter Date...','style'=>'width:160px'],
                                'pluginOptions' => ['autoclose'=>true,'format' => 'yyyy-mm-dd']]);
            
            ?>
           </td>
       </tr>
       <tr>
          <td id="cim"> SIM  </td>
          <td>
                <?= $form->field($model, 'SIM')->textInput(['maxlength'=>50 ,'style'=> 'width:400px;','id'=>'simc']) ?>
          </td>
       </tr>
       <tr id="cimd">
          <td> SIM Expired date </td>
          <td>
            <?= DatePicker::widget([
                                'model' => $model, 
                                'attribute' => 'SIMExpiredDate',
                                'options' => ['placeholder' => 'Enter Date...','style'=>'width:160px','id'=>'simb'],
                                'pluginOptions' => ['autoclose'=>true,'format' => 'yyyy-mm-dd']]);
                    
                    ?>
         </td>
      </tr>  
       <tr>
          <td> Status Nikah</td>
          <td>
                <?= $form->field($model, 'IDStatusNikah')->dropDownList(ArrayHelper::map($masterstatusnikah,'IDStatusPernikahan','Description'),['prompt' => 'Select status nikah' ,'style'=> 'width:200px;'])->label('StatusNikah');  ?>
              
          </td>
      </tr>
      <tr>
          <td>Address </td>
          <td>
             <?= $form->field($model, 'Address')->textarea(['maxlength'=>255, 'style'=> 'width:400px;',"rows"=>2])->label('Address') ?>
          </td>
      </tr>
       <tr>
          <td> City </td>
          <td>
               <?= $form->field($model, 'City')->textInput(['maxlength'=>100 ,'style'=> 'width:400px;'])->label('City') ?>
          </td>
      </tr>
      <tr>
          <td> Zip</td>
          <td>
                <?= $form->field($model, 'Zip')->textInput(['maxlength' =>5, 'style'=> 'width:100px;']) ?>
          </td>
      </tr>
      <tr>
          <td> Phone </td>
          <td>
                <?= $form->field($model, 'Phone')->textInput(['maxlength'=>15,'style'=> 'width:400px;']) ?>
          </td>
      </tr>
       <tr>
          <td> Mobile1 </td>
          <td>
                <?= $form->field($model, 'Mobile1')->textInput(['maxlength'=>15, 'style'=> 'width:400px;']) ?>
          </td>
      </tr>
            </tr>
       <tr>
          <td> Mobile2</td>
          <td>
                <?= $form->field($model, 'Mobile2')->textInput(['maxlength'=>15, 'style'=> 'width:400px;']) ?>
          </td>
      </tr>
      <tr>
          <td> Bank Name</td>
          <td>      
            <?= $form->field($model, 'BankID') ->widget(Select2::classname(),
                    ['data'=>ArrayHelper::map($masterbank,'BankID','BankName','BankGroupName'),
                     'options' => ['placeholder' => 'Select BankName ...','style'=>'width:200px;'], 
                    ]
                 );
              ?>
          </td>
     </tr>
      <tr>
          <td> BankAccNumber </td>
          <td>
                <?= $form->field($model, 'BankAccNumber')->textInput(['maxlength'=>20 ,'style'=> 'width:400px;']) ?>
          </td>
      </tr>
      <tr>
          <td> NPWP </td>
          <td>
                 <?= $form->field($model, 'NPWP')->textInput(['maxlength'=>20,'style'=> 'width:400px;']) ?>
           </td>
      </tr>   
       <tr>
          <td> Status</td>
          <td>
                <?php echo $form->field($model, 'Status')->dropDownList(['FIX' => 'FIX', 'GSF' => 'GSF', 'GSK' => 'GSK'],['prompt'=>'Pilih Status', 'style'=> 'width:200px;']) ?>
          </td>
       </tr>
       <tr>
          <td> Class </td>
          <td>
                <?= $form->field($model, 'ClassID')->dropDownList(ArrayHelper::map($MasterClass,'ClassID','ClassDesc'),['prompt' => 'Select Class', 'style'=> 'width:200px;'])->label('Class'); ?>
               
          </td>
       </tr>
          <?php
    
        if (! $model->isNewRecord )
    {
            echo '<tr><td style="padding-right:20px;padding-bottom:20px;">Status</td>';
            echo '<td style="padding-right:20px;padding-bottom:5px;">';
            echo $form->field($model, 'IsActive')->checkbox() ;
            echo '</td></tr>';
    } 
             ?>
  </table>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'btn']) ?>
         <?= Html::a('Back', ['master-product/index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
