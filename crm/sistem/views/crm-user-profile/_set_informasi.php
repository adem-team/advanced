<?php
/* extensions */
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\FileInput;


?>

<div class="profile-form">

    <?php $form = ActiveForm::begin([
			'type' => ActiveForm::TYPE_HORIZONTAL,
			'method' => 'post',
			'id'=>$model->formName(),
      'enableClientValidation' => true,
		]);
	?>

    <div class="row">
      <div class="col-sm-6">
      <?php
      $foto_profile = $profile->IMG_BASE64 !=''? 'data:image/jpeg;base64,'.$profile->IMG_BASE64:Yii::getAlias("@HRD_EMP_UploadUrl").'/'.'default.jpg';

      echo $image = '<img style="width:80%; margin-bottom:5%; height:80%",class="img-responsive img-thumbnail", src="'.$foto_profile.'"></img>';
      ?>
      </div>
     <div class="col-sm-6">
		<?= $form->field($model, 'ALAMAT')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'TLP_HOME')->textInput(['maxlength' => true])?>
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
