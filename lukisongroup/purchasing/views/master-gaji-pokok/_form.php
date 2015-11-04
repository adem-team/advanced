<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\master\models\MasterGajiPokok */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-gaji-pokok-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php 
    
    $masterjobdesc = app\master\models\MasterJobdesc::find()->select('IDJobDesc,Description')->all();
    $masterarea = app\master\models\MasterArea::find()->select('AreaID,Description')->all();
    ?>
    <table class="table table-striped table-bordered">
        <tr>
            <td>Job Desc</td>
            <td> <?= $form->field($model, 'IDJobDesc')->dropDownList(ArrayHelper::map($masterjobdesc,'IDJobDesc','Description'),['prompt' => 'Select Job Desc','style'=> 'width:220px;']) ?></td>
        </tr>
        <tr>
            <td>Area</td>
            <td><?= $form->field($model, 'AreaID')->dropDownList(ArrayHelper::map($masterarea,'AreaID','Description'),['prompt' => 'Select Area','style'=> 'width:220px;']) ?></td>
        </tr>
        <tr>
            <td>Amount</td>
            <td><?= $form->field($model, 'Amount')->textInput(['maxlength' => 7,'style'=> 'width:120px;']) ?></td>
        </tr>
        <tr>
           <td>Star Month </td>
          <td>
    <?php echo DatePicker::widget([
                                'model' => $model, 
                                'attribute' => 'StartMonth',
                                'options' => ['placeholder' => 'Enter Date...','style'=>'width:160px'],
                                'pluginOptions' => ['autoclose'=>true,'format' => 'yyyy-mm-dd']]);
            
    ?>
               </td> 
                </tr>
   
    <tr>
           <td>Star Year </td>
          <td>
               <?php echo DatePicker::widget([
                                'model' => $model, 
                                'attribute' => 'StartYear',
                                'options' => ['placeholder' => 'Enter Date...','style'=>'width:160px'],
                                'pluginOptions' => ['autoclose'=>true,'format' => 'yyyy-mm-dd']]);
            
    ?>
          </td>
    </tr>
        <?php if(!$model->isNewRecord){ ?>
         <tr>
            <td>
                Is Active
            </td>
            <td>
               <?= $form->field($model, 'IsActive')->checkbox(); ?> 
            </td>
        </tr>
        <?php } ?>
    </table>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['master-gaji-pokok/index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
