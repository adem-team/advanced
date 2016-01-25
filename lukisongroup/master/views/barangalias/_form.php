<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use lukisongroup\master\models\barangalias;
use lukisongroup\master\models\Distributor;
use yii\helpers\Url;
use kartik\widgets\Select2;
use kartik\label\LabelInPlace;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Barangalias */
/* @var $form yii\widgets\ActiveForm */


$datadis = Distributor::find()->where('STATUS<>3')
                              ->all();
$todis = 'KD_DISTRIBUTOR';
$fromdis = 'NM_DISTRIBUTOR';
$drop = [1 =>'Prodak',0 =>'Umum'];
$config = ['template'=>"{input}\n{error}\n{hint}"]
?>

<div class="barangalias-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName(),
      'enableClientValidation'=>true
    ]); ?>



    <?php echo $form->field($model, 'KD_PARENT')->dropDownList($drop,
         ['prompt' => 'Pilih Jenis Barang']
      ); ?>


    <?= $form->field($model, 'KD_BARANG')->widget(DepDrop::classname(), [
      'type'=>DepDrop::TYPE_SELECT2,
      'pluginOptions' => [
        'depends'=>['barangalias-kd_parent'],
        'url'=>Url::to(['/master/barangalias/product']),
         'placeholder'=>'Select...',
      ],

    ])?>



    <?= $form->field($model, 'KD_ALIAS',$config)->widget(LabelInPlace::classname()); ?>


    <?= $form->field($model, 'KD_DISTRIBUTOR')->widget(Select2::classname(), [
      'data' => $model->data($datadis,$todis,$fromdis),
      'options' => ['placeholder' => 'Pilih KD DISTRIBUTOR ...'],
      'pluginOptions' => [
        'allowClear' => true
         ],
    ]);?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
