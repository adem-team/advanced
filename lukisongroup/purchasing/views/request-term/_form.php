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
 $brgUnit = ArrayHelper::map(Unitbarang::find()->where('STATUS<>3')->orderBy('NM_UNIT')->all(), 'KD_UNIT', 'NM_UNIT');
 $corp = Yii::$app->getUserOpt->Profile_user()->emp->EMP_CORP_ID;
 $query_cari_customers = Yii::$app->db_esm->createCommand('SELECT td.CUST_NM,th.TERM_ID,th.CUST_KD_PARENT FROM `t0000header` th INNER JOIN c0001 td on th.CUST_KD_PARENT = td.CUST_KD')->queryAll();

 $data_group_cus = ArrayHelper::map($query_cari_customers,'CUST_KD_PARENT','CUST_NM');
 $data_invest = ArrayHelper::map(Terminvest::find()->all(),'ID','INVES_TYPE')

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
				'data' => $data_group_cus,
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

    </div>




     <?php

      echo  $form->field($model, 'KD_CORP')->hiddenInput(['value'=>$corp])->label(false);

 		 echo $form->field($model, 'NOTE')->textarea(array('rows'=>2,'cols'=>5))->label('Program');


?>
    <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


	<?php ActiveForm::end(); ?>
<?php
  $this->registerJs('

  $("div#rodetail-new").click(function()
  {
      var val = $("#radiochek:checked").val();
      if(val === "2")
      {
      		$("#rodetail-nm_barang").hide();
          $("label[for=rodetail-nm_barang]").hide();
          $("#tes").show();
          $("label[for=rodetail-kd_barang]").show();
          $("#hrg").hide();

      }
      else{
        $("#rodetail-nm_barang").show();
        $("label[for=rodetail-nm_barang]").show();
        $("#tes").hide();
        $("label[for=rodetail-kd_barang]").hide();
        $("#hrg").show();
      }
  });

	',$this::POS_READY);
