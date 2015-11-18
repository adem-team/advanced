<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\hrd\organisasi */
/* @var $form yii\widgets\ActiveForm */

$array = lukisongroup\models\hrd\Organisasi::find()->distinct()
                                                    ->all();
                                          
 
$dataparent = yii\helpers\ArrayHelper::map($array, 'id','title');


$datastatik = [
    "1" => "a",
    "2" => "b",
    "3" => "c",
];
//  $drop = ArrayHelper::map(Corp::find()->all(), 'CORP_ID', 'CORP_NM');

?>

<div class="organisasi-form">

    <?php $form = ActiveForm::begin([
        'id'=>'creupdt',
        'enableClientValidation' => true,
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <!--$form->field($model, 'id')->textInput(['maxlength' => true]) ?>-->
    
     <?=$form->field($model, 'parent')->widget(Select2::classname(), [
    'data' => $dataparent,
    'options' => ['placeholder' => 'pilih  ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

   

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    
     <?=$form->field($model, 'gambar')->widget(FileInput::classname(), [
    'options'=>['accept'=>'image/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]
	]);
	?>

     <!--$form->field($model, 'image')->fileInput() ?>-->

    
     
    <?= $form->field($model, 'itemType')->widget(Select2::classname(), [
    'data' => $datastatik,
//    'value' => ['-', '-'],
    'options' => ['placeholder' => 'pilih  ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
