<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Url;


?>

    <?php $form = ActiveForm::begin([
			'id'=>$arsip->formName(),
			'enableClientValidation' => true,
			'options'=>['enctype' => 'multipart/form-data'],
		]);
	?>


<?= $form->field($arsip, 'IMG_BASE64')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*','multiple' => true
    ],
]) ?>

 <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


	<?php ActiveForm::end(); ?>