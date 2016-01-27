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
$config = ['template'=>"{input}\n{error}\n{hint}"]
?>

<div class="barangalias-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName(),
      'enableClientValidation'=>true,
      'enableAjaxValidation'=>true,
      'action'=>'/master/customers/create-alias'
    ]); ?>

    <?= $form->field($model, 'KD_CUSTOMERS')->textInput(['value'=>$id->CUST_KD,'readonly'=>true])->label('Kode Customers') ?>

    <?= $form->field($model, 'CUST_NM')->textInput(['value'=>$nama,'disabled'=>true]) ?>

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
<?php

$this->registerJs("

   $('form#{$model->formName()}').on('beforeSubmit',function(e)
    {
        var \$form = $(this);
        $.post(
            \$form.attr('action'),
            \$form.serialize()

        )
            .done(function(result){
			        if(result == 1 )
                {
                  $(document).find('#formalias').modal('hide');
                  $('form#{$model->formName()}').trigger('reset');
                  }
                else{
                      console.log(result)
                    }

            });

return false;


});


 ",$this::POS_END);
