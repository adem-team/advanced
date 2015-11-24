<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\master\models\Suplier;
//use lukisongroup\master\models\Perusahaan;
use lukisongroup\master\models\Tipebarang;
use lukisongroup\hrd\models\Corp;
use kartik\widgets\Select2;

use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Barangumum */
/* @var $form yii\widgets\ActiveForm */

// dropdown data

 $dropcorp = ArrayHelper::map(Corp::find()->all(), 'CORP_ID', 'CORP_NM');
 $droptype = ArrayHelper::map(Tipebarang::find()->where(['STATUS' => 1])->all(), 'KD_TYPE', 'NM_TYPE');
 $dropkat = ArrayHelper::map(Kategori::find()->where(['STATUS' => 1])->all(), 'KD_KATEGORI', 'NM_KATEGORI');
 $dropunit = ArrayHelper::map(Unitbarang::find()->where(['STATUS' => 1])->all(), 'KD_UNIT', 'NM_UNIT');
 $dropsuplier = ArrayHelper::map(Suplier::find()->where(['STATUS' => 1])->all(), 'KD_SUPPLIER', 'NM_SUPPLIER');
 
?>

<!-- /* enableClientValidation */
   /* validasi ajax */ -->

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL,
                                   
                                       'id'=>'updateumum',
                                       'enableClientValidation' => true,
                                       'options' => ['enctype' => 'multipart/form-data'],
//                                        'enableClientValidation' => true,
                                        ]);
            
            ?>

   
       
    
    <?= $form->field($model, 'KD_CORP')->dropDownList($dropcorp,['prompt'=>' -- Pilih Salah Satu --','disabled'=>true])->label('Group Perusahaan') ?>
    
    <?= $form->field($model, 'KD_BARANG')->textInput(['maxlength' => true, 'readonly'=>true]) ?>

    <?= $form->field($model, 'NM_BARANG')->textInput(['maxlength' => true]) ?>	
	
   <?= $form->field($model, 'KD_TYPE')->widget(Select2::classname(), [
        'data' => $droptype,
        'options' => ['placeholder' => 'Pilih KD TYPE ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],
    ]);?>
    <?= $form->field($model, 'KD_KATEGORI')->widget(Select2::classname(), [
        'data' => $dropkat,
        'options' => ['placeholder' => 'Pilih KD Kategori ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],
    ]);?>
	
   
        
     <?= $form->field($model, 'KD_UNIT')->widget(Select2::classname(), [
    'data' => $dropunit,
    'options' => ['placeholder' => 'Pilih KD Unit ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>
     
    <?=$form->field($model, 'KD_SUPPLIER')->widget(Select2::classname(), [
    'data' => $dropsuplier,
    'options' => ['placeholder' => 'Pilih KD SUPPLIER ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>

    <?= $form->field($model, 'PARENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HPP')->textInput() ?>

    <?= $form->field($model, 'HARGA')->textInput() ?>

    <?= $form->field($model, 'BARCODE')->textInput(['maxlength' => true]) ?>
    <?php
    
   
          echo $form->field($model, 'image')->widget(FileInput::classname(), [
    'options'=>['accept'=>'image/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]
	]);
    
    ?>
   

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'KD_CAB')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_DEP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ?>

    <!--$form->field($model, 'UPDATED_BY')->hiddenInput(['value'=>Yii::$app->user->identity->username])->label(false) ?>-->

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
         <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i>&nbsp;&nbsp;update Barang' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div><br/><br/>

     <?php ActiveForm::end(); ?>

</div>
