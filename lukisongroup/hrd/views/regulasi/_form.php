<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use lukisongroup\hrd\models\Seq;
use kartik\widgets\DateTimePicker;
use kartik\label\LabelInPlace;






/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Regulasi */
/* @var $form yii\widgets\ActiveForm */

$array = Seq::find()->all();
$arraygf = lukisongroup\hrd\models\Groupfunction::find()->all();
$arraydep = \lukisongroup\hrd\models\Dept::find()->all();
$arraysub = lukisongroup\hrd\models\Deptsub::find()->all();
$arraycorp = lukisongroup\hrd\models\Corp::find()->all();
$arrayjob = lukisongroup\hrd\models\Jobgrade::find()->all();



//data
$datadep = yii\helpers\ArrayHelper::map($arraydep, 'DEP_ID','DEP_NM');
$datagf = yii\helpers\ArrayHelper::map($arraygf, 'GF_ID','GF_NM');
$datasqid = yii\helpers\ArrayHelper::map($array, 'SEQ_ID','SEQ_NM');
$datasub =  yii\helpers\ArrayHelper::map($arraysub, 'DEP_SUB_ID', 'DEP_ID');
$datacorp = yii\helpers\ArrayHelper::map($arraycorp, 'CORP_ID', 'CORP_NM');
$datajob = yii\helpers\ArrayHelper::map($arrayjob, 'JOBGRADE_ID','JOBGRADE_NM');

$datastatus = ['0'=>'Tidak aktif',
                '1'=> 'aktif'
                        ];



?>

<!--<div class="regulasi-form">-->

    <?php $form = ActiveForm::begin([
                    'id'=>'form',
                    'enableClientValidation'=> true
        
    ]); ?>

    <!--$form->field($model, 'ID')->textInput(['maxlength' => true]) ?>-->

    <?= $form->field($model, 'RGTR_TITEL')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'TGL')->widget(DateTimePicker::classname(), [
	'options' => ['placeholder' => 'pilih tanggal dan waktu ...'],
	'pluginOptions' => [
		'autoclose' => true
	],
        'pluginEvents'=>[
                            'show' => "function(e) {show}",
                            ],
]);?>




    <?= $form->field($model, 'RGTR_ISI')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'RGTR_DCRPT')->textarea(['rows' => 6]) ?>
	
	<?php $config = ['template'=>"{input}\n{error}\n{hint}"]; ?>
	
	
	<?=$form->field($model, 'SET_ACTIVE', $config)->widget(LabelInPlace::classname()); ?>

    
    
      <?=$form->field($model, 'CORP_ID')->widget(Select2::classname(), [
    'data' => $datacorp,
    'options' => ['placeholder' => 'pilih  ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>
    

   

     <?=$form->field($model, 'DEP_ID')->widget(Select2::classname(), [
    'data' => $datadep,
    'options' => ['placeholder' => 'pilih  ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>
    
     <?=$form->field($model, 'DEP_SUB_ID')->widget(Select2::classname(), [
    'data' => $datasub,
    'options' => ['placeholder' => 'pilih  ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

    
     <?=$form->field($model, 'GF_ID')->widget(Select2::classname(), [
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
    
    <?=$form->field($model, 'JOBGRADE_ID')->widget(Select2::classname(), [
    'data' => $datajob,
    'options' => ['placeholder' => 'pilih  ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>
    
    
     <?=$form->field($model, 'STATUS')->widget(Select2::classname(), [
    'data' => $datastatus,
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
