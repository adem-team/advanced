<?php

use \Yii;
/*extensions*/
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\money\MaskMoney;
use yii\helpers\Url;

/* namespace models*/
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Terminvest;
use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\hrd\models\Corp;



/* array*/
 $data_invest = ArrayHelper::map(Terminvest::find()->all(),'ID','INVES_TYPE')

?>


    <?php $form = ActiveForm::begin([
			'id'=>$model->formName(),
			'enableClientValidation' => true,
			'method' => 'post',
		]);
	?>

    <?=  $form->field($model, 'INVESTASI_TYPE')->widget(Select2::classname(), [
          'data' => $data_invest,
          'options' => [
            'placeholder' => 'Pilih Investasi ...'
        ],
          'pluginOptions' => [
            'allowClear' => true
          ],
      ])->label('Investasi') ?>

    </div>

     <?php

 		 echo $form->field($model, 'INVESTASI_PROGRAM')->textarea(array('rows'=>2,'cols'=>5))->label('Program');


?>
    <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


	<?php ActiveForm::end(); ?>
<?php
