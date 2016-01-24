<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

use lukisongroup\hrd\models\Corp;
use lukisongroup\master\models\Tipebarang;

$userCorp = ArrayHelper::map(Corp::find()->where('CORP_STS<>3')->all(), 'CORP_ID', 'CORP_NM');
$typeBrg = ArrayHelper::map(Tipebarang::find()->where('STATUS<>3')->all(), 'KD_TYPE', 'NM_TYPE');

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
	<?= $form->field($model, 'CORP_ID')->dropDownList($userCorp, ['id'=>'kategori-kd_corp'])->label('Corporate'); ?>
	<?php 
		echo $form->field($model, 'KD_TYPE')->widget(DepDrop::classname(), [
			'type'=>DepDrop::TYPE_SELECT2,
			'data' => $typeBrg,
			'options' => ['id'=>'kategori-kd_type'],
			'pluginOptions' => [
				'depends'=>['kategori-parent','kategori-kd_corp'],
				'url'=>Url::to(['/master/kategori/ktg-type']),
				'initialize'=>true,
			], 		
		]);
	?>
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
