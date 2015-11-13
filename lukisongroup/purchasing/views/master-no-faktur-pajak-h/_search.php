<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterNoFakturPajakHSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-no-faktur-pajak-h-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
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
    
        echo Html::dropDownList('typeSearch',$type,['1'=>' ID Faktur Pajak', '2'=>'Period To'],['prompt'=>'ALL','class' => 'form-control','id' => 'searchdrop']);
        echo Html::textInput('textsearch',$text,['class' => 'form-control','id'=> 'searchbox']);
    ?>
      <?php 
            echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']);
//            echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
  
    <?php ActiveForm::end(); ?>

</div>
