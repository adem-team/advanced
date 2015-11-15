<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterAreaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-area-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
        'options'=>['data-pjax' => true ],
    ]); 
    
//    print_r($_POST['category']);
//    die();

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

//    echo \kartik\select2\Select2::widget([
//        'name' => 'category',
//        'data' => ['1'=>'ID', '2'=>'Description'],
//        'options' => ['placeholder' => 'ALL'],
//        'pluginOptions' => [
//            'allowClear' => true
//        ],
//      ]);

    echo Html::dropDownList('typeSearch',$type,
                        ['1'=>'ID', '2'=>'Description'],
                        ['prompt'=>'ALL','class'=>'form-control','id' => 'searchdrop']) ;
    
        echo Html::textInput('textsearch',$text,['id' => 'searchbox', 'class' => 'form-control']);
        echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']);

    ActiveForm::end(); ?>


</div>
