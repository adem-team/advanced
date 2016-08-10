<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use lukisongroup\master\models\DraftPlan;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="draft-plan-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName()]); ?>

    <?= $form->field($model, 'TGL_START')->widget(Select2::classname(), [
					'data' => DraftPlan::getYearsList(),
					'options' => ['placeholder' => 'Pilih Tahun ...'],
					'pluginOptions' => [
						'allowClear' => true
						 ],
				])->label('YEAR') ?>


	 <?= $form->field($model, 'GEO_ID')->widget(Select2::classname(), [
                'data' => $geo,
                'options' => ['placeholder' => 'Pilih ...'],
                'pluginOptions' => [
                    'allowClear' => true
                     ],
            ])->label('List Geografis');?>

    <?= $form->field($model, 'SUB_GEO')->widget(DepDrop::classname(), [
						'type'=>DepDrop::TYPE_SELECT2,
						'options'=>['placeholder'=>'Select ...'],
						'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
						'pluginOptions'=>[
							'depends'=>['draftplangroup-geo_id'],
							 'initialize' => true,
							  'loadingText' => 'Loading  ...',
							'url' => Url::to(['/master/draft-plan/lis-geo-sub']),
						]
					])->label('AREA GROUP') 
					?>


 		

            <?= $form->field($model, 'USER_ID')->widget(Select2::classname(), [
                'data' => $user,
                'options' => ['placeholder' => 'Pilih User ...'],
                'pluginOptions' => [
                    'allowClear' => true
                     ],
            ])->label('Pilih User');?>

            <?= $form->field($model, 'ODD_EVEN')->widget(Select2::classname(), [
                'data' => $opt,
                'options' => ['placeholder' => 'Pilih ...'],
                'pluginOptions' => [
                    'allowClear' => true
                     ],
            ])->label('Options Jeda Pekan');?>



            <?= $form->field($model, 'DAY_ID')->widget(DepDrop::classname(), [
					'type'=>DepDrop::TYPE_SELECT2,
					'options'=>['placeholder'=>'Select ...'],
					'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
					'pluginOptions'=>[
						'depends'=>['draftplangroup-odd_even'],
						 'initialize' => true,
						  'loadingText' => 'Loading  ...',
						'url' => Url::to(['/master/draft-plan/lisday']),
					]
				])->label('Setel Hari') ?>
				

            <?= $form->field($model, 'PROSES_ID')->widget(Select2::classname(), [
                'data' => $proses,
                'options' => ['placeholder' => 'Pilih ...'],
                'pluginOptions' => [
                    'allowClear' => true
                     ],
            ])->label('Options Libur');?>
					



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Create', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary',  'data-confirm'=>'Anda yakin ingin Ganti Jadwal',]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
