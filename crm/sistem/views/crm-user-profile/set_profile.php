<?php
/* extensions */
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;


?>

<div class="profile-form">

    <?php $form = ActiveForm::begin([
			'type' => ActiveForm::TYPE_HORIZONTAL,
			'method' => 'post',
			'id'=>$model->formName(),
      'enableClientValidation' => true,
			'options' => ['enctype' => 'multipart/form-data']
		]);
	?>

    <div class="row">
      <div class="col-sm-6">

        <?php
      echo $form->field($model, 'image')->widget(FileInput::classname(), [
      'pluginOptions' => ['browseIcon'=>'<i class="glyphicon glyphicon-folder-open"></i>',
                            'overwriteInitial'=>true,
                            'showCaption' => false,
                            'showClose' => false,
                            'browseLabel'=> '',
                            'removeLabel'=> '',
                            'removeIcon'=> '<i class="glyphicon glyphicon-remove"></i>',
                            'removeTitle'=> 'Cancel or reset changes',
                            'showUpload' => false,
                            'defaultPreviewContent' => '<img src="https://www.mautic.org/media/images/default_avatar.png" alt="Your Avatar" style="width:160px">'
                            ]])->label(false);?>

      </div>
     <div class="col-sm-6">
		<?= $form->field($model, 'NM_FIRST')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'NM_MIDDLE')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'NM_END')->textInput(['maxlength' => true])?>
    <?= $form->field($model, 'KD_SRC')->widget(Select2::classname(), [
			'data' => $distributor,
			'options' => ['placeholder' => 'Pilih Distributor ...'],
			'pluginOptions' => [
				'allowClear' => true
				 ],
		]);?>
    </div>
    </div>

    <?php
    /* if not equal to isNewRecord then dropdown status */
    if(!$model->isNewRecord)
    {
      	echo $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']);
    }

     ?>


		<div class="form-group">
				<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i>&nbsp;&nbsp;add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>


    <?php ActiveForm::end(); ?>

</div>
