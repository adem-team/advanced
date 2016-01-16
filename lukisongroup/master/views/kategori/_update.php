<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;

	$aryParent= [
		  ['PARENT' => 0, 'PAREN_NM' => 'UMUM'],		  
		  ['PARENT' => 1, 'PAREN_NM' => 'PRODAK'],
	];	
	$valParent = ArrayHelper::map($aryParent, 'PARENT', 'PAREN_NM');
?>



    <?php $form = ActiveForm::begin([
                'id'=>'updatekat',
                'enableClientValidation' => true,
		'type' => ActiveForm::TYPE_HORIZONTAL,]); ?>

    <?PHP //= $form->field($model, 'KD_KATEGORI')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'PARENT')->dropDownList($valParent); ?>
    <?= $form->field($model, 'NM_KATEGORI')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'UPDATED_BY')->hiddenInput(['value'=>Yii::$app->user->identity->username])->label(false) ?>
	
    <?=  $form->field($model, 'STATUS')->radioList(['1'=>'Aktif','0'=>'Tidak Aktif']) ?>

  <div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : '<i class="fa fa-pencil"></i>&nbsp;&nbsp;Ubah Kategori', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
