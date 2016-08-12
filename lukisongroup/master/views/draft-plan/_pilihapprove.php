<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="draft-plan-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(),
    	'enableClientValidation' => true,
        'enableAjaxValidation'=>true,
        'validationUrl'=>Url::toRoute('/master/draft-plan/valid-user')

    ]); ?>

    <?= $form->field($model, 'TGL')->widget(Select2::classname(), [
					'data' => $year,
					'options' => ['placeholder' => 'Pilih Tahun ...'],
					'pluginOptions' => [
						'allowClear' => true
						 ],
				])->label('YEAR') ?>


	 <!-- $form->field($model, 'CUST_ID')->widget(Select2::classname(), [
					'data' => $cus,
					'options' => ['placeholder' => 'Pilih ...'],
					'pluginOptions' => [
						'allowClear' => true
						 ],
				])->label('Pilih Customers'); -->

				<?= $form->field($model, 'CUST_ID')->widget(DepDrop::classname(), [
						'type'=>DepDrop::TYPE_SELECT2,
						'options'=>['placeholder'=>'Select ...'],
						'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
						'pluginOptions'=>[
							'depends'=>['draftplandetail-tgl'],
							 'initialize' => true,
							  'loadingText' => 'Loading  ...',
							'url' => Url::to(['/master/draft-plan/lis-cus-plan']),
						]
					])->label('Pilih Customers') ?>

					<?= $form->field($model, 'SCDL_GROUP_NM')->hiddenInput()->label(false); ?> 
	<!-- ?> -->
   


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Approve' : 'Approve', ['class' => $model->isNewRecord ? 'btn btn-info' : 'btn btn-info',  'data-confirm'=>'Anda yakin ingin Approve?',]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs("
$('#draftplandetail-cust_id').on('change',function(e){
e.preventDefault();
var idx = $(this).val();
   $.ajax({   
        url: '/master/draft-plan/val',
        dataType: 'json',
        type: 'GET',
        data:{id:idx},
        success: function (data, textStatus, jqXHR) {            $('#draftplandetail-scdl_group_nm').val(data)
        },
    });
});
  ",$this::POS_READY);
