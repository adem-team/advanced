<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterjadwalkerjaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="masterjadwalkerja-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        //'options' => ['data-pjax'=>true],
    ]); ?>
    
     <?php 
    
        if(isset($_GET['typeSearch']))
        {
            $type = $_GET['typeSearch'];
        } else {
            $type = NULL;
        }

        if(isset($_GET['textsearch']))
        {
            $text = $_GET['textsearch'];
        } else {
            $text = NULL;
        }
        
        
        $yearnw = date('o');
        $monthnw = date('n');
        $yearf = $yearnw+1;
        $array = array();
        for($i = $yearnw-3;$i<=$yearf;$i++)
        {
            $array[$i] = $i;
            
        }
        
        if(isset($_GET['tahun']))
        {
            $yearnw = $_GET['tahun'];
        } else {
            $yearnw = date('o');
        }
        
        if(isset($_GET['bulan']))
        {
            $monthnw = $_GET['bulan'];
        } else {
            $monthnw = date('n');
        }
        
        echo Html::dropDownList('tahun',$yearnw,$array,['prompt'=>'Select Year','class' => 'form-control','id' => 'year']);
        echo Html::dropDownList('bulan',$monthnw,['1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'],['prompt'=>'Select Month','class' => 'form-control','id' => 'month']);
        echo Html::dropDownList('typeSearch',$type,['1'=>'Customer ID', '2'=>'Customer Name','3'=>'Area ID','4'=>'Area Name'],['prompt'=>'ALL','class' => 'form-control','id' => 'searchdrop']);
        echo Html::textInput('textsearch',$text,['class' => 'form-control','id'=> 'searchbox']);
    ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
