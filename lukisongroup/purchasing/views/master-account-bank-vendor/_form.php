<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\master\models\MasterBank;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterAccountBankVendor */
/* @var $form yii\widgets\ActiveForm */

?>
        <?php
    $url = Url::to('index.php?r=master/master-account-bank-vendor/vendor');
    $buttn = 'btn btn-success';
    $bankname = ['prompt'=>'Select BankName','style'=> 'width:200px;'];
    $masterbank = MasterBank::find()->select('mb.BankGroupID,mbg.BankGroupName,mb.BankID,mb.BankName')
                                    ->from('MasterBankGroup mbg')
                                    ->innerJoin('MasterBank mb','mb.BankGroupID=mbg.BankGroupID')
//                                    ->joinWith('idbankgrup')
//                                    ->orderBy('MasterBank.BankGroupID, MasterBankGroup.BankGroupID')
//                                    ->where(['BankGroupID'=>001])
          
                                    ->all();
    $html = Html::button('...', ['value'=>$url,'class' =>$buttn ,'id'=>'modalv'])

        ?>
<?php 
Modal::begin([
             'header'=>'<h4>Vlookup</h4>',
             'id'=> 'modal',
             'size'=>'modal-lg',
         ]);
         echo"<div id='modalvendor'></div>";
 modal::end();
         
         ?>
<div class="master-account-bank-vendor-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <input type=hidden name=vendor id=v value= >
    
<table class="table table-striped table-bordered">
    <tr>
        <td>
          Vendor ID
        </td>
        <td>
             <?= $form->field($model, 'VendorID')->textInput(['disabled'=>true,'id'=>'vd','style'=> 'width:400px;']) ; ?>
             <?= $html ?>
        </td>
    </tr>     
    <tr> 
        <td>Bank Name</td>
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
        <td>Account No</td>
             <td>
                <?= $form->field($model, 'AccountNo')->textInput(['maxlength'=>20,'style'=> 'width:400px;']) ?>
             </td>
    </tr>
    
    <?php
    
    $mo = $model->isNewRecord;
    if(!$mo)
    {
       echo $form->field($model, 'IsActive')->checkbox();  
    
    }
    
    ?>
 </table>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['master-account-bank-vendor/index'], ['class' => 'btn btn-success']) ?>
    </div>   
    <?php ActiveForm::end(); ?>
    

</div>
<?php
$script = <<<SKRIPT
$(function(){
$('#modalv').click(function() {
	$('#modal').modal('show')
		.find('#modalvendor')
		.load($(this).attr('value'));

	})
        });
SKRIPT;

$this->registerJs($script);
?>
