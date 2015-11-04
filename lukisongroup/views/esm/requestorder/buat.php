<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use lukisongroup\models\esm\ro\Requestorder;
use lukisongroup\models\esm\ro\RequestorderSearch;


use yii\helpers\ArrayHelper;
use lukisongroup\models\master\Perusahaan;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\ro\Requestorder */
/* @var $form yii\widgets\ActiveForm */



$this->sideCorp = 'ESM Request Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_esm';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Data Master');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

	$model = new Requestorder();

?>

<div class="requestorder-form" style="margin:0px 20px;">

    <?php // $form = ActiveForm::begin(); ?>
	<?php
		$form = ActiveForm::begin([
			'method' => 'post',
			'action' => ['esm/requestorder/create'],
		]);
	?>
	
<div class="row">
	<div class="col-md-6 col-sm-6"><?= $form->field($model, 'KD_RO')->textInput(['maxlength' => true]) ?></div>
	<div class="col-md-6 col-sm-6"><?= $form->field($model, 'ID_USER')->textInput(['maxlength' => true]) ?></div>
</div>

<div class="row">
	<div class="col-md-6 col-sm-6"><?= $form->field($model, 'KD_CAB')->textInput(['maxlength' => true]) ?></div>
	
	<?php
		$drop = ArrayHelper::map(Perusahaan::find()->all(), 'KD_CORP', 'NM_CORP');
	?>
	<div class="col-md-6 col-sm-6"><?= $form->field($model, 'KD_CORP')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Perusahaan') ?></div>
</div>


    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATED_ALL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DATA_ALL')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
zdefr
</div>
