<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use lukisongroup\models\hrd\Seq;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\hrd\Jobdesc */
/* @var $form yii\widgets\ActiveForm */

// array
$array = Seq::find()->all();
$arraygf = lukisongroup\models\hrd\Groupfunction::find()->all();
$arraydep = \lukisongroup\models\hrd\Dept::find()->all();
$arraysub = lukisongroup\models\hrd\Deptsub::find()->all();
$arraycorp = lukisongroup\models\hrd\Corp::find()->all();
$arrayjob = lukisongroup\models\hrd\Jobgrade::find()->all();


//data
$datadep = yii\helpers\ArrayHelper::map($arraydep, 'DEP_ID','DEP_NM');
$datagf = yii\helpers\ArrayHelper::map($arraygf, 'GF_ID','GF_NM');
$datasqid = yii\helpers\ArrayHelper::map($array, 'SEQ_ID','SEQ_NM');
$datasub =  yii\helpers\ArrayHelper::map($arraysub, 'DEP_SUB_ID', 'DEP_ID');
$datacorp = yii\helpers\ArrayHelper::map($arraycorp, 'CORP_ID', 'CORP_NM');
$datajob = yii\helpers\ArrayHelper::map($arrayjob, 'JOBGRADE_ID','JOBGRADE_NM');
$datastatus = ['0'=>'Tidak aktif',
                '1'=> 'aktif'
                        ]

?>

<!--<div class="jobdesc-form">-->
<div class="row">
            
             <!--<div class="col-lg-3"></div>-->
             <div class="col-sm-12">

    <?php $form = ActiveForm::begin([
        'id' => 'cre',
         'enableClientValidation' => true, 
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'JOBSDESK_TITLE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JOBGRADE_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JOBGRADE_DCRP')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'JOBGRADE_STS')->textInput() ?>

   
    
    <?=$form->field($model, 'JOBSDESK_IMG')->widget(FileInput::classname(), [
    'options'=>['accept'=>'image/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]
	]);
	?>

    <?= $form->field($model, 'JOBSDESK_PATH')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SORT')->textInput() ?>

   
    
      <?= $form->field($model, 'CORP_ID')->widget(Select2::classname(), [
    'data' => $datacorp,
    'options' => ['placeholder' => 'pilih  ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

    <!--$form->field($model, 'DEP_ID')->textInput(['maxlength' => true]) ?>-->
    
      <?= $form->field($model, 'DEP_SUB_ID')->widget(Select2::classname(), [
    'data' => $datasub,
    'options' => ['placeholder' => 'pilih  ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

     <!--$form->field($model, 'DEP_SUB_ID')->textInput(['maxlength' => true]) ?>-->

     <?= $form->field($model, 'DEP_ID')->widget(Select2::classname(), [
    'data' => $datadep,
    'options' => ['placeholder' => 'pilih  ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>
      <?= $form->field($model, 'GF_ID')->widget(Select2::classname(), [
    'data' => $datagf,
    'options' => ['placeholder' => 'pilih  ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

   
    
     <?=$form->field($model, 'SEQ_ID')->widget(Select2::classname(), [
    'data' => $datasqid,
    'options' => ['placeholder' => 'pilih  ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

    
     
      <?= $form->field($model, 'JOBGRADE_ID')->widget(Select2::classname(), [
    'data' => $datajob,
    'options' => ['placeholder' => 'pilih  ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>
    
      <?= $form->field($model, 'STATUS')->widget(Select2::classname(), [
    'data' => $datastatus,
    'options' => ['placeholder' => 'pilih  ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

   
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  

    <?php ActiveForm::end(); ?>

</div>
</div>
