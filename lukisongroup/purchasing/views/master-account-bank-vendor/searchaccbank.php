<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterVendorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-vendor-search">

     <?php $form = ActiveForm::begin([
        'action' => ['vendor'],
        'method' => 'post',
        'options' => ['data-pjax' => true],
    ]); ?>

   <?php 
    
        if(isset($_POST['typeSearch']))
        {
            $type = $_POST['typeSearch'];
        } else {
            $type = NULL;
        }

        if(isset($_POST['textsearch']))
        {
            $text = $_POST['textsearch'];
        } else {
            $text = NULL;
        }
    
        echo Html::dropDownList('typeSearch',$type,['1'=>' Vendor ID','2'=>'Vendor Name'],['prompt'=>'ALL','class' => 'form-control','id' => 'searchdrop']);
        echo Html::textInput('textsearch',$text,['class' => 'form-control','id'=> 'searchbox']);
    ?>

    
 <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
       
    </div>
    <?php // echo $form->field($model, 'Phone') ?>

    <?php // echo $form->field($model, 'Fax') ?>

    <?php // echo $form->field($model, 'ContactName') ?>

    <?php // echo $form->field($model, 'ContactPhone') ?>

    <?php // echo $form->field($model, 'ContactEmail') ?>

    <?php // echo $form->field($model, 'IsActive') ?>

    <?php // echo $form->field($model, 'UserCrt') ?>

    <?php // echo $form->field($model, 'DateCrt') ?>

    <?php // echo $form->field($model, 'UserUpdate') ?>

    <?php // echo $form->field($model, 'DateUpdate') ?>

   

    <?php ActiveForm::end(); ?>

</div>
