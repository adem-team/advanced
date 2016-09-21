
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

	
	

?>


<?php $form = ActiveForm::begin([
      'id'=> 'create',
      'enableClientValidation'=> true

    ]); ?>


<?= $form->field($model, 'ACTUAL_DATE1')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ],
    'pluginEvents' => [
                      'show' => "function(e) {show}",
    ],
]);?>
<?php
  function getPermissionPilot(){
		return Yii::$app->getUserOpt->Profile_user()->emp;
	}
    
       $dataseq = getPermissionPilot()->SEQ_ID;
       $datajob = getPermissionPilot()->JOBGRADE_ID;
       
       if($datajob == "AM" || $datajob == "M" || $datajob == "SM" || $datajob == "AVP" || $datajob == "VP" || $datajob == "SVP" || $datajob == "EVP" && $dataseq == 1)
       {
    
            
                    echo   $form->field($model, 'ACTUAL_DATE2')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Enter date ...'],
                                'pluginOptions' => [
                                                    'autoclose'=>true
                                             ],
                                  'pluginEvents' => [
                                                     'show' => "function(e) {show}",
                                            ],
                            ]);
    
    
       }
       elseif($datajob == "M" || $datajob == "SM" || $datajob == "AVP" || $datajob == "VP" || $datajob == "SVP" || $datajob == "EVP" || $datajob == "SEVP" && $dataseq == 2)
       
             {       
                
                   echo   $form->field($model, 'ACTUAL_DATE2')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Enter date ...'],
                                     'pluginOptions' => [
                                        'autoclose'=>true
                                                            ],
                                 'pluginEvents' => [
                                'show' => "function(e) {show}",
                                     ],
                                    ]); 
    }
    else{
          echo  $form->field($model, 'ACTUAL_DATE2')->textinput(['disabled'=>true]);
    }
       
    
?>


<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>