<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\master\models\MasterCustomer;
//use yii\helpers\ArrayHelper;
//use app\master\models\MasterAbsenType;
/* @var $this yii\web\View */
/* @var $model app\master\models\MasterCustomer */
/* @var $form yii\widgets\ActiveForm */

$script = <<<SKRIPT
        $(document).ready(function() {
                $('#parentid').change(function(){
                if (this.checked) {        
                    $('#parentgroup').hide();

                }
                else {
                    $('#parentgroup').show();   
                }                   
            });
            
        });
        
        
        

SKRIPT;

$this->registerJs($script);


?>

<div class="master-customer-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <table class="table table-striped table-bordered">
        <tr>
            <td>Customer ID</td>
            <td><?//= $form->field($model,'CustomerID')->textInput(['class'=>'form-control medbox']); ?></td>
        </tr>
        <?php 
            if($model['ParentID'] != NULL)
            {
                $disp = "none";
            } else {

                $disp = "table-row";
            }
        ?>
    <tr style="display:<?php echo $disp;?>;">
        <td>
            Is Parent
        </td>
        <td>
        <?= Html::checkbox('parentid', false,['id' => 'parentid']) ?>
        </td>
    </tr>
    <tr id="parentgroup">
         <td>
            Parent ID
        </td>
        <td> 
            <?php   
            
            if($model['ParentID'] == NULL)
            {
                $select = NULL;
               
            } else {
                
                $select = $model->ParentID;
                
            }
            //$subquery = (new \yii\db\Query)->select("CustomerID")->from("MasterCustomer")->groupBy("CustomerID");
            $arraypar = MasterCustomer::find()
                    ->select('CustomerID,ParentID,Nama')
                    ->from('MasterCustomer')
                    ->where("ParentID <> ''")
                    ->all();
            
            $arraymap = \yii\helpers\ArrayHelper::map($arraypar,'CustomerID','ParentID');
//            print_r($arraymap);
//            die();
//            foreach ($arraypar as $value)
//            {
//                   
//                if($arraypar == NULL)
//                {
//                    $parent['-'] = "-";
//                } else {
//                    $parent[$value['CustomerID']] = $value['ParentID'].' - '. $value['Nama'];
//                }
//                print_r($arraypar);
//                die();
//                
//            }
             ?>
            
            <?= Html::dropDownList('parent',$select,$arraymap,['prompt' => 'Select Parent', 'class' => 'form-control' , 'id' => 'searchdrop1']); ?>
        </td>
    </tr> 
   
    
    <tr>
        <td>
            Name
        </td>
        <td>
        <?= $form->field($model, 'Nama')->textInput(['maxlength' => 100,'style'=> 'width:400px;']) ?>
        </td>
    </tr>
    <tr>
        <td>
            Address
        </td>
        <td>
        <?= $form->field($model, 'Address')->textarea(['maxlength' => 255,'style'=> 'width:400px;','rows'=>2]) ?>
        </td>
    </tr>
    <tr>
        <td>
            City
        </td>
        <td>
        <?= $form->field($model, 'City')->textInput(['maxlength' => 100,'style'=> 'width:400px;']) ?>
        </td>
    </tr>
    <tr>
        <td>
            Zip
        </td>
        <td>
        <?= $form->field($model, 'Zip')->textInput(['maxlength' => 5,'style'=> 'width:400px;']) ?>
        </td>
    </tr>
    <tr>
        <td>
            Phone
        </td>
        <td>
        <? //= $form->field($model, 'Phone')->textInput(['maxlength' => 15,'style'=> 'width:400px;']) ?>
        </td>
    </tr>
    <tr>
        <td>
            Fax
        </td>
        <td>
        <?//= $form->field($model, 'Fax')->textInput(['maxlength' => 15,'style'=> 'width:400px;']) ?>
        </td>
    </tr>
    <tr>
        <td>
            Contact Name
        </td>
        <td>
        <?//= $form->field($model, 'ContactName')->textInput(['maxlength' => 50,'style'=> 'width:400px;']) ?>
        </td>
    </tr>
    <tr>
        <td>
            Contact Phone
        </td>
        <td>
        <?//= $form->field($model, 'ContactPhone')->textInput(['maxlength' => 15,'style'=> 'width:400px;']) ?>
        </td>
    </tr>
    <tr>
        <td>
            Contact Email
        </td>
        <td>
        <?//= $form->field($model, 'ContactEmail')->textInput(['maxlength' => 50,'style'=> 'width:400px;']) ?>
        </td>
    </tr>
    <tr>
        <td>
            Absen Type
        </td>
        <td>
        <?php      
        
            if($model['IDAbsenType'] == NULL)
            {
                $select1 = NULL;
               
            } else {
                
                $select1 = $model->IDAbsenType;
                
            }
        
            $arrayasd = Yii::$app->db->createCommand('select ID,StartAbsen,EndAbsen from MasterAbsenType')->queryAll();
            
            foreach ($arrayasd as $value){
                $singleArray[$value['ID']] = $value['StartAbsen'].' - '. $value['EndAbsen'];
            }
            
            echo Html::dropDownList('absen',$select1,$singleArray,['prompt' => 'Select Type', 'class' => 'form-control' , 'id' => 'searchdrop1']);
            
            ?>
        </td>
    </tr>
    <?php if(!$model->isNewRecord)
    {
    ?>
    <tr>
        <td>
            Is Active
        </td>
        <td>
        <?= $form->field($model, 'IsActive')->checkbox() ?>
        </td>
    </tr>
    <?php
    }?>
    </table>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['master-customer/index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
