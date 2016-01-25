<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\widgets\SwitchInput;
use lukisongroup\hrd\models\Corp;

$userCorp = ArrayHelper::map(Corp::find()->all(), 'CORP_ID', 'CORP_NM');

	$aryParent= [
		  ['PARENT' => 0, 'PAREN_NM' => 'UMUM'],		  
		  ['PARENT' => 1, 'PAREN_NM' => 'PRODAK'],
	];	
	$valParent = ArrayHelper::map($aryParent, 'PARENT', 'PAREN_NM');
?>

<div class="tipebarang-form">

    <?php $form = ActiveForm::begin([
                'id'=>'createtipe',
                'enableClientValidation' => true,
		'type' => ActiveForm::TYPE_HORIZONTAL,
		'method' => 'post',
		'action' => ['tipebarang/simpan'],
		]); 
	?>
	<?= $form->field($model, 'CORP_ID')->dropDownList($userCorp, ['id'=>'rodetail-kd_type'])->label('Type'); ?>
	<?= $form->field($model, 'PARENT')->dropDownList($valParent); ?>
    <?= $form->field($model, 'NM_TYPE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    
	
    <?=  $form->field($model, 'STATUS')->radioList(['1'=>'Aktif','0'=>'Tidak Aktif']) ?>

  <div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i>&nbsp;&nbsp; Tambah Tipe Barang' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
