<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use crm\mastercrm\models\Customers;

/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Kategoricus */
/* @var $form yii\widgets\ActiveForm */
// $drop = Kategoricus::find()->select('CUST_KTG_NM')
												// ->where('CUST_KTG_PARENT = 0')
												// ->all();


 $data_cus = Customers::getNameColumn();
 
 
$options = [];

foreach ($data_cus as $key => $value) {
  # code...
  $options[$key] = $value;
}

?>



<div class="kategoricus-form">

    <?php $form = ActiveForm::begin([
	  'id'=>$model->formName(),
      'enableClientValidation' => true,

	]); ?>


      <?= $form->field($model, 'checkbox_export')->checkboxList($options ,
      ['inline'=>true])->label(false) ?>

    <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'export' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>