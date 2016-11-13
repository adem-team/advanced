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

    <?= $form->field($model, 'NEW')->radioList([
    '1' => 'Request Investment ',
    '2' => 'Request Budget',
],
['item' => function($index, $label, $name, $checked, $value) {
                                  $return = '<label class="modal-radio">';
                                  $return .= '<input type="radio" id = "radiochek" name="' .'Requesttermheader[NEW]'. '" value="' . $value . '" tabindex="-1">';
                                  $return .= '<i></i>';
                                  $return .= '<span>' . ucwords($label) . '</span>';
                                  $return .= '</label>';

                                  return $return;
                              }
                          ])->label(false)?>



  <?=  $form->field($model, 'CUST_ID_PARENT')->widget(Select2::classname(), [
				'data' => $cus_data,
				'options' => [
          'placeholder' => 'Pilih Customers ...'
      ],
				'pluginOptions' => [
					'allowClear' => true
				],
		])->label('Customers') ?>

    <?=  $form->field($term_invest, 'ID_INVEST')->widget(Select2::classname(), [
          'data' => $data_invest,
          'options' => [
            'placeholder' => 'Pilih Investasi ...'
        ],
          'pluginOptions' => [
            'allowClear' => true
          ],
      ])->label('Investasi') ?>

       <?php echo $form->field($model, 'PERIOD_START')->widget(DatePicker::classname(), [
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

        <?php echo $form->field($model, 'PERIOD_END')->widget(DatePicker::classname(), [
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

      echo  $form->field($model, 'KD_CORP')->hiddenInput(['value'=>$corp])->label(false);

 		 echo $form->field($model, 'NOTE')->textarea(array('rows'=>2,'cols'=>5))->label('Program');


?>
    <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


	<?php ActiveForm::end(); ?>

