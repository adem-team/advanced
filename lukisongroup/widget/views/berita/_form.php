<?php
/* extensions */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Berita */
/* @var $form yii\widgets\ActiveForm */



?>


    <?php $form = ActiveForm::begin([
      'id'=>$model->formName(),
      'enableClientValidation' => true,
      'enableAjaxValidation'=>true,
      'validationUrl'=>Url::toRoute('/widget/berita/valid-berita-acara')
    ]); ?>


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
			<?= $form->field($model, 'JUDUL')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'ISI')->widget(CKEditor::className(), [
				'options' => ['rows' => 6],
				'preset' => [
						//'height' => 400,
						'toolbarGroups' => [
							['name' => 'document', 'groups' => ['mode', 'document', 'doctools']],
							['name' => 'clipboard', 'groups' => ['clipboard', 'undo']],
							['name' => 'editing', 'groups' => [ 'find', 'selection', 'spellchecker']],
							['name' => 'forms'],
							'/',
							['name' => 'basicstyles', 'groups' => ['basicstyles', 'colors','cleanup']],
							['name' => 'paragraph', 'groups' => [ 'list', 'indent', 'blocks', 'align', 'bidi' ]],
							['name' => 'links'],
							['name' => 'insert'],
							'/',
							['name' => 'styles'],
							['name' => 'blocks'],
							['name' => 'colors'],
							['name' => 'tools'],
							['name' => 'others'],
						],
					],
			])->label('Peristiwa/Kejadian'); ?>

			<?php 
				echo \kato\DropZone::widget([
					 'options' => [
						 'maxFilesize' => '2',
						 'acceptedFiles'=>'image/*,application/pdf',
						 'url'=>'/widget/berita/upload-berita-acara'
					 ],
					 'clientEvents' => [
						 'complete' => "function(file){console.log(file)}",
						 'removedfile' => "function(file){alert(file.name + ' is removed')}"
					 ],
				]);
			?>

			<?=  $form->field($model, 'KD_DEP')->widget(Select2::classname(),['data' => $datadep,'options' => ['placeholder' => 'Select ...'],])->label('Send to Dept'); ?>

			<?=  $form->field($model, 'USER_CC')->widget(Select2::classname(),['data' =>$dataemploye,
			'options' => ['placeholder' => 'Select ...','multiple'=>true],]) 
			?>



         <!-- $form->field($model, 'USER_CC')->widget(DepDrop::classname(), [
           'options' => ['placeholder' => 'Select ...'],
           'type' => DepDrop::TYPE_SELECT2,
           'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
           'pluginOptions'=>[
                'depends'=>['berita-kd_dep'],
                'url' => Url::to(['/widget/berita/cari-user-berita']),
                'loadingText' => 'Loading ...',
        ]
        ]) ?> -->


      </div>
      </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
