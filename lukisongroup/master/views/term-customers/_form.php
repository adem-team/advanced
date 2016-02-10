<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use lukisongroup\master\models\Customers;
use lukisongroup\hrd\models\Corp;
use lukisongroup\master\models\Distributor;
use kartik\widgets\DatePicker;
use kartik\label\LabelInPlace;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termcustomers */
/* @var $form yii\widgets\ActiveForm */
$data = Customers::find()->all();
$to = "CUST_GRP";
$from = "CUST_NM";

$data1 = Corp::find()->all();
$to1 = "CORP_ID";
$from1 = "CORP_NM";

$data2 = Distributor::find()->all();
$to2 = 'KD_DISTRIBUTOR';
$from2 = "NM_DISTRIBUTOR";

$config = ['template'=>"{input}\n{error}\n{hint}"];


?>
<div class="termcustomers-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName(),

    ]); ?>

    <?= $form->field($model, 'NM_TERM', $config)->widget(LabelInPlace::classname())?>

    <?= $form->field($model, 'CUST_KD')->widget(Select2::classname(),[
  		'options'=>[  'placeholder' => 'Select Customers parent ...'
  		],
  		'data' =>$model->data($data,$to,$from)
  	]);?>



    <?= $form->field($model, 'CUST_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_SIGN')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'PRINCIPAL_KD')->widget(Select2::classname(),[
  		'options'=>[  'placeholder' => 'Select Nama Principal ...'
  		],
  		'data' =>$model->data($data1,$to1,$from1)
  	]);?>

    <?= $form->field($model, 'PRINCIPAL_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PRINCIPAL_SIGN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DIST_KD')->widget(Select2::classname(),[
      'options'=>[  'placeholder' => 'Select Nama Distributor ...'
      ],
      'data' =>$model->data($data2,$to2,$from2)
    ]);?>

    <?= $form->field($model, 'DIST_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DIST_SIGN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DCRP_SIGNARURE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'PERIOD_START')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'select  ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ],
    'pluginEvents'=>[
            'show' => "function(e) {show}",
                ],

    ])  ?>

    <?= $form->field($model, 'PERIOD_END')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'select  ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ],
    'pluginEvents'=>[
            'show' => "function(e) {show}",
                ],
    ])  ?>

    <?= $form->field($model, 'TARGET_TEXT')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'TARGET_VALUE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'RABATE_CNDT')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'GROWTH')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TOP', $config)->widget(LabelInPlace::classname(), [
        'type' => LabelInPlace::TYPE_TEXTAREA
    ]) ?>

    <?php
      if(!$model->IsNewRecord)
      {
        	echo $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']);
      }

     ?>




    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
