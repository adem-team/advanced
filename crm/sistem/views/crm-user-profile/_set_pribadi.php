<?php
/* extensions */
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\SwitchInput;
use kartik\widgets\DatePicker;


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
      <div class="col-sm-3">
      <?php
      $foto_profile = $profile->IMG_BASE64 !=''? 'data:image/jpeg;base64,'.$profile->IMG_BASE64:Yii::getAlias("@HRD_EMP_UploadUrl").'/'.'default.jpg';

      echo $image = '<img style="width:80%; margin-bottom:5%; height:80%",class="img-responsive img-thumbnail", src="'.$foto_profile.'"></img>';
      ?>
      </div>
     <div class="col-sm-9">
     <?= $form->field($model, 'TGL_LAHIR')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter Born date ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ],
    'pluginEvents'=>[
         'show' => "function(e) {errror}",
             ],
]) ?>
		<?= $form->field($model, 'ALAMAT')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'KTP')->textInput(['maxlength' => true])?>

     <?=$form->field($model, 'GENDER')->widget(SwitchInput::classname(), [
       'pluginOptions' => [
        // 'handleWidth'=>10,
        'onText' => 'male',
        'offText' => 'female',
    ],
    
     ]) ?>
    </div>
    </div>


		<div class="form-group">
				<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i>&nbsp;&nbsp;add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>


    <?php ActiveForm::end(); ?>

</div>
