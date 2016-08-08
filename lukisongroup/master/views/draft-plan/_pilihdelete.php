<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="draft-plan-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName()]); ?>

	<?= $form->field($model, 'CUST_ID')->widget(Select2::classname(), [
					'data' => $cus,
					'options' => ['placeholder' => 'Pilih ...'],
					'pluginOptions' => [
						'allowClear' => true
						 ],
				])->label('Pilih Customers');
	?>
   


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Delete' : 'Delete', ['class' => $model->isNewRecord ? 'btn btn-danger' : 'btn btn-danger',  'data-confirm'=>'Anda yakin ingin delete',]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
