<?php
/* extensions */
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\FileInput;

/* namespace models */
use lukisongroup\hrd\models\Corp;

$drop = ArrayHelper::map(Corp::find()->where(['CORP_STS' => 1])->all(), 'CORP_ID', 'CORP_NM');
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

      </div>
     <div class="col-sm-6">
    <?= $form->field($model, 'KD_DISTRIBUTOR')->widget(Select2::classname(), [
      'data' => $drop,
      'options' => ['placeholder' => 'Pilih Perusahaan ...'],
      'pluginOptions' => [
        'allowClear' => true
         ],
    ]);?>

    <?= $form->field($model, 'CORP_ID')->widget(Select2::classname(), [
      'data' => $dropunit,
      'options' => ['placeholder' => 'Pilih Perusahaan ...'],
      'pluginOptions' => [
        'allowClear' => true
         ],
    ]);?>

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
