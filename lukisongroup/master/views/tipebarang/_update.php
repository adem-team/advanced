<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
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
        'type' => ActiveForm::TYPE_HORIZONTAL,
              'id'=>'updatetipe',
                'enableClientValidation' => true,
            ]); ?>
	<?= $form->field($model, 'CORP_ID')->dropDownList($userCorp, ['id'=>'rodetail-kd_type'])->label('Type'); ?>
	<?= $form->field($model, 'PARENT')->dropDownList($valParent); ?>
    <?= $form->field($model, 'NM_TYPE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <!--$form->field($model, 'UPDATED_BY')->hiddenInput(['value'=>Yii::$app->user->identity->username])->label(false) ?>-->
	
    <?=  $form->field($model, 'STATUS')->radioList(['1'=>'Aktif','0'=>'Tidak Aktif']) ?>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
        <?= Html::submitButton('<i class="fa fa-pencil"></i>&nbsp;&nbsp; Ubah Tipe Barang', ['class' => 'btn btn-primary']) ?>
		</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
