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
use kartik\widgets\DatePicker;

/* namespace models*/
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Terminvest;
use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\hrd\models\Corp;

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


        <?php echo $form->field($model, 'PERIODE_START')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Tgl Term Dibuat'],
                        'pluginOptions' => [
                            'todayHighlight' => true,
                            'autoclose'=>true,
                              'format' => 'yyyy-m-dd'
                        ],
                        'pluginEvents'=>[
                            'show' => "function(e) {show}",
                        ],
                    ]);
        ?>

        <?php echo $form->field($model, 'PERIODE_END')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Tgl Term Berakhir'],
                        'pluginOptions' => [
                            'todayHighlight' => true,
                            'autoclose'=>true,
                              'format' => 'yyyy-m-dd'
                        ],
                        'pluginEvents'=>[
                            'show' => "function(e) {show}",
                        ],
                    ]);
        ?>

    </div>

     <?php

 		 echo $form->field($model, 'INVESTASI_PROGRAM')->textarea(array('rows'=>2,'cols'=>5))->label('Program');


?>
    <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


	<?php ActiveForm::end(); ?>
<?php
