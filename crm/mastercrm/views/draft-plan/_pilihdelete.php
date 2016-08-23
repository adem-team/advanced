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

    <?php $form = ActiveForm::begin(['id'=>$model->formName()]); ?>

    <?= $form->field($model, 'TGL')->widget(Select2::classname(), [
					'data' => $year,
					'options' => ['placeholder' => 'Pilih Tahun ...'],
					'pluginOptions' => [
						'allowClear' => true
						 ],
				])->label('YEAR') ?>


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
					])->label('Pilih Customers') 
	?>
   


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Delete' : 'Delete', ['class' => $model->isNewRecord ? 'btn btn-danger' : 'btn btn-danger',  'data-confirm'=>'Anda yakin ingin delete',]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
