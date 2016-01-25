<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\widgets\SwitchInput;
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

<div class="kategori-form">

    <?php $form = ActiveForm::begin([
                'id'=>'createkat',
                'enableClientValidation' => true,
		'type' => ActiveForm::TYPE_HORIZONTAL,
		'method' => 'post',
		'action' => ['kategori/simpan'],
		]); ?>

    <?= $form->field($model, 'PARENT')->dropDownList($valParent,['id'=>'kategori-parent']); ?>
	
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

    <?=  $form->field($model, 'STATUS')->radioList(['1'=>'Aktif','0'=>'Tidak Aktif']) ?>
	
  <div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i>&nbsp;&nbsp; Tambah Kategori' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'tbk']) ?>
		</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
