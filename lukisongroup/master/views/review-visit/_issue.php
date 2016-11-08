<?php

use yii\helpers\Url;
use kartik\helpers\Html;
use kartik\widgets\Select2;
use kartik\form\ActiveForm;

?>


<?php $form = ActiveForm::begin([
			'type' => ActiveForm::TYPE_HORIZONTAL,
			'method' => 'post',
			'action' =>['/master/review-visit/proses-berita','id'=>$id],
			 'id'=>'form-berita-id',
             'enableClientValidation' => true,
		]);
	?>
	<?php
	echo $form->field($model, 'status')->widget(Select2::classname(), [
    'data' => $valStt,
    'options' => ['placeholder' => 'Select...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label(false);

	?>

	<div class="form-group">
			<div class="col-sm-10">
				<?= Html::submitButton('<i class="fa fa-plus"></i>&nbsp;&nbsp;Submit', ['class' =>'btn btn-primary btn-sm']) ?>
			</div>
		</div>

    <?php ActiveForm::end(); ?>
