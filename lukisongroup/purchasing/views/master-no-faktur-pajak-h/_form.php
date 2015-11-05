 <?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\master\models\MasterNoFakturPajakH */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="master-no-faktur-pajak-h-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <table class="table table-striped table-bordered">
        
          <tr>
            <td>Period From</td>
            <td>  
                  <?php echo DatePicker::widget([
                                'model' => $model, 
                                'attribute' => 'PeriodFrom',
                                'options' => ['placeholder' => 'Enter Date...','style'=>'width:160px'],
                                'pluginOptions' => ['autoclose'=>true,'format' => 'yyyy-mm-dd']]);
               
             ?></td>
        </tr>
          <tr>
            <td>Period To</td>
            <td> 
            
            <?php echo DatePicker::widget([
                                'model' => $model, 
                                'attribute' => 'PeriodTo',
                                'options' => ['placeholder' => 'Enter Date...','style'=>'width:160px'],
                                'pluginOptions' => ['autoclose'=>true,'format' => 'yyyy-mm-dd']]);
               
             ?></td>
        </tr>
          <tr>
            <td>Number From</td>
            <td><?= $form->field($model, 'NumberFrom')->textInput(['maxlength'=>50,'style'=> 'width:400px;']) ?></td>
        </tr>
          <tr>
            <td>Number To</td>
            <td>  <?= $form->field($model, 'NumberTo')->textInput(['maxlength'=>50, 'style'=> 'width:400px;']) ?></td>
        </tr>
        
        <?php
        
        if(!$model->isNewRecord)
        {
            
            echo "<tr>
            <td>
                Is Active
            </td>
            <td>".
                 $form->field($model, 'IsActive')->checkbox()."
            </td>
        </tr>";
        }
        
        ?>
        
    </table>
    
     <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['master-no-faktur-pajak-h/index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



