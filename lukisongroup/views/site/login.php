<?php
require('_index_nologin.php');
use yii\helpers\Html;
use kartik\icons\Icon;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use yii\bootstrap\Modal;
//use kartik\widgets\FileInput;
//echo $pk_emp.'ok';
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,]);
$formlogin= FormGrid::widget([
//echo  FormGrid::widget([
    'model'=>$model,
    'form'=>$form,
    'autoGenerateColumns'=>true,
    'rows'=>[
        [
            'contentBefore'=>'<legend class="text-info"><small>User Login</small></legend>',
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
            'columns'=>1,
            'attributes'=>[
                'actions'=>[    // embed raw HTML content
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
    Modal::begin([
        'id' => 'modal_login',
        //'header' => '<h2>Hello world</h2>'
    ]);
        echo $formlogin;
    Modal::end();
    ActiveForm::end()
?>
</div>




