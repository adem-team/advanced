<?php
require('index_nologin.php');
use yii\helpers\Html;
use kartik\icons\Icon;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use yii\bootstrap\Modal;
/* $this->registerCss("div#modal_login{ padding-right: 11000%;
												}"); */
//use kartik\widgets\FileInput;
//echo $pk_emp.'ok';
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,'id'=>'form']);

$formlogin= FormGrid::widget([
//echo  FormGrid::widget([
    'model'=>$model,
    'form'=>$form,
    'autoGenerateColumns'=>true,
    'rows'=>[
        [
            //'contentBefore'=>'<legend class="text-info"><small>User Login</small></legend>',
            'columns'=>1,
            'autoGenerateColumns'=>false,
            'attributes'=>[
                'employe_identity' => [
                    //'label'=>'Employee.ID',
                    'columns'=>2,
                    'attributes'=>[

                        'username'=>[
                            'type'=>Form::INPUT_TEXT,
                            'Form::SIZE_LARGE',
                            'options'=>['placeholder'=>'Enter username...'],
                            'columnOptions'=>['colspan'=>2],


                        ],

                    ]
                ],
            ],
        ],
        [
            //'contentBefore'=>'<legend class="text-info"><small>EMPLOYE IDENTITY</small></legend>',
            'columns'=>1,
            'autoGenerateColumns'=>false,
            'attributes'=>[
                'employe_identity' => [
                    //'label'=>'Employee.ID',
                    'columns'=>2,
                    'attributes'=>[

                        'password'=>[
                            'type'=>Form::INPUT_PASSWORD,
                            'options'=>['placeholder'=>'Enter Password...'],
                            'columnOptions'=>['colspan'=>2],
                        ],

                    ]
                ],
            ],
        ],
        [ //-Action Author: -ptr.nov-
            'columns'=>6,
            'attributes'=>[
                'actions'=>[    // embed raw HTML content
				'columns'=>7,
                    'type'=>Form::INPUT_RAW,
                    'value'=>  '<div style="text-align: right; margin-top: 25px">' .

                        Html::submitButton('Login', ['class'=>'btn btn-primary']) .
                        '</div>'
                ],
            ],
        ],
    ]

]);


?>
<!-- <div class="col-md-3 col-md-offset-5" style="margin-top: 10px"> !-->


<?php
//echo $formlogin; 
	/*   $this->registerJs('$(".modal").modal({
        backdrop: true,
        keyboard: true
		}).css({
		   padding-right: function () { 
			   return ($(document).padding-right("170px")),  
		   },
		   
		})',$this::POS_HEAD);  */
	 
    Modal::begin([
        'id' => 'modal_login',
        'header' => '<img src="http://lukisongroup.com/login_icon1.png" style="width:70px; height:50px"/>',
		'size' => Modal::SIZE_SMALL,
        'options' => ['class'=>'slide'],
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1);'
		], 
		/* 'options'=>[
			'style'=> 'display:bloack;padding-right:270px;'
		] */
	
    ]);
		echo $formlogin; 
		echo $form->field($model, 'POSITION_SITE')->hiddenInput(['value'=> 'ERP'])->label(false); /*SITE POSITION LOGIN*/
	Modal::end();
    ActiveForm::end() ;
	
?>

</div>




