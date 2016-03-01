<?php

use \Yii;
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\hrd\models\Corp;
use kartik\money\MaskMoney;
use yii\helpers\Url;



// $userCorp = ArrayHelper::map(Corp::find()->where('CORP_STS<>3')->all(), 'CORP_ID', 'CORP_NM');
$brgUnit = ArrayHelper::map(Unitbarang::find()->where('STATUS<>3')->orderBy('NM_UNIT')->all(), 'KD_UNIT', 'NM_UNIT');
// $brgType = ArrayHelper::map(Tipebarang::find()->where('PARENT=0 AND STATUS<>3')->orderBy('NM_TYPE')->all(), 'KD_TYPE', 'NM_TYPE');
// $brgKtg  = ArrayHelper::map(Kategori::find()->where('PARENT=0 AND STATUS<>3')->orderBy('NM_KATEGORI')->all(), 'KD_KATEGORI', 'NM_KATEGORI');
// $brgUmum = ArrayHelper::map(Barang::find()->where('PARENT=0 AND STATUS<>3')->orderBy('NM_BARANG')->all(), 'KD_BARANG', 'NM_BARANG');

/* $this->registerJs("
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    ",$this::POS_HEAD);
 */
 $corp = Yii::$app->getUserOpt->Profile_user()->emp->EMP_CORP_ID;
 // print_r($corp);
 // die();
 $data = ArrayHelper::map(Barang::find()->where(['KD_CORP'=> $corp])->all(),'KD_BARANG','NM_BARANG')

 // print_r($data);
 // die();


?>


    <?php $form = ActiveForm::begin([
			'id'=>'roInput',
			'enableClientValidation' => true,
        // 'enableAjaxValidation'=>true,
			'method' => 'post',
			'action' => ['/purchasing/request-order/simpanfirst'],
      // 'validationUrl'=>Url::toRoute('/purchasing/request-order/valid')
		]);
	?>
	<?php //= $form->errorSummary($model); ?>

    <!-- $form->field($roDetail, 'CREATED_AT',['template' => "{input}"])->hiddenInput(['value'=>date('Y-m-d H:i:s'),'readonly' => true]) ?> -->


    <?= $form->field($model, 'NEW')->radioList([
    '1' => 'New ',
    '2' => ' Search',
],
['item' => function($index, $label, $name, $checked, $value) {
                                  $return = '<label class="modal-radio">';
                                  $return .= '<input type="radio" name="' . 'new'. '" value="' . $value . '" tabindex="-1">';
                                  $return .= '<i></i>';
                                  $return .= '<span>' . ucwords($label) . '</span>';
                                  $return .= '</label>';

                                  return $return;
                              }
                          ])->label(false)?>


    <div id="tes">

  <?=  $form->field($roDetail, 'KD_BARANG')->widget(Select2::classname(), [
				'data' => $data,
				'options' => ['id'=>'purchaseorder-top',
          'placeholder' => 'Pilih Nama Barang ...'
      ],
				'pluginOptions' => [
					'allowClear' => true
				],
		])->label('Nama Barang') ?>

  </div>



     <?=  $form->field($roDetail, 'NM_BARANG')->textInput(['maxlength' => true, 'placeholder'=>'New Item'])->label('New Item Barang')?>

     <div id="hrg">

     <?= $form->field($roDetail, 'HARGA')->widget(MaskMoney::classname(), [
       'pluginOptions' => [
           'prefix' => 'Rp',
          'precision' => 2,
           'allowNegative' => false
       ]
     ]) ?>

   </div>

     <?php

      echo  $form->field($roDetail, 'KD_CORP')->hiddenInput(['value'=>$corp])->label(false);

     echo  $form->field($roDetail, 'RQTY')->textInput(['maxlength' => true, 'placeholder'=>'Jumlah Barang']);

     echo $form->field($roDetail, 'UNIT')->widget(Select2::classname(), [
         'data' => $brgUnit,
         'options' => ['placeholder' => 'Pilih Unit Barang ...'],
         'pluginOptions' => [
           'allowClear' => true
         ],
     ]);

 		 echo $form->field($roDetail, 'NOTE')->textarea(array('rows'=>2,'cols'=>5))->label('Informasi');


		// echo $form->field($roDetail, 'KD_CORP')->dropDownList($userCorp,[
		// 		'id'=>'rodetail-kd_corp',
		// 		'prompt'=>' -- Pilih Salah Satu --',
		// 	])->label('Perusahaan');
    //
		// echo $form->field($roDetail, 'KD_TYPE')->widget(DepDrop::classname(), [
		// 	'type'=>DepDrop::TYPE_SELECT2,
		// 	'data' => $brgType,
		// 	'options' => ['id'=>'rodetail-kd_type'],
		// 	'pluginOptions' => [
		// 		'depends'=>['rodetail-kd_corp'],
		// 		'url'=>Url::to(['/purchasing/request-order/corp-type']), /*Parent=0 barang Umum*/
		// 		'initialize'=>true,
		// 	],
		// ]);
    //
		// echo $form->field($roDetail, 'KD_KATEGORI')->widget(DepDrop::classname(), [
		// 	'type'=>DepDrop::TYPE_SELECT2,
		// 	'data' => $brgKtg,
		// 	'options' => ['id'=>'rodetail-kd_kategori'],
		// 	'pluginOptions' => [
		// 		'depends'=>['rodetail-kd_corp','rodetail-kd_type'],
		// 		'url'=>Url::to(['/purchasing/request-order/type-kat']),
		// 		'initialize'=>true,
		// 	],
		// ]);
    //
		// echo $form->field($roDetail, 'KD_BARANG')->widget(DepDrop::classname(), [
		// 	'type'=>DepDrop::TYPE_SELECT2,
		// 	'data' => $brgUmum,
		// 	'options' => ['id'=>'rodetail-kd_barang'],
		// 	'pluginOptions' => [
		// 		'depends'=>['rodetail-kd_kategori'],
		// 		'url'=>Url::to(['/purchasing/request-order/brgkat']),
		// 		'initialize'=>true,
		// 	],
		// ]);
    //
		// echo $form->field($roDetail, 'NM_BARANG')->hiddenInput(['value' => ''])->label(false);
		// /* echo $form->field($roDetail, 'UNIT')->widget(DepDrop::classname(), [
		// 	'type'=>DepDrop::TYPE_DEFAULT,
		// 	'data' => $brgUnit,
		// 	'options' => ['id'=>'rodetail-unit','readonly'=>true,'selected'=>false],
		// 	'pluginOptions' => [
		// 		'depends'=>['rodetail-kd_kategori','rodetail-kd_barang'],
		// 		'url'=>Url::to(['/purchasing/request-order/brgunit']),
		// 		//'initialize'=>true,
		// 		'placeholder' => false,
		// 	],
		// ]);  */

    //

?>
    <div class="form-group">
      <?= Html::submitButton($roDetail->isNewRecord ? 'Create' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


	<?php ActiveForm::end(); ?>
<?php
  $this->registerJs('

  $("div#dynamicmodel-new").click(function()
  {
      var val = $("input[name=new]:checked").val();

      // alert(val);
      if(val === "2")
      {
      		$("#rodetail-nm_barang").hide();
          $("label[for=rodetail-nm_barang]").hide();
          $("#tes").show();
          $("label[for=rodetail-kd_barang]").show();
          $("#hrg").hide();

          // if(sel == "")
          // {
          //
          // }

      }
      else{
        $("#rodetail-nm_barang").show();
        $("label[for=rodetail-nm_barang]").show();
        $("#tes").hide();
        $("label[for=rodetail-kd_barang]").hide();
        $("#hrg").show();
      }


  });

  $("form#roInput").on("submit", function() {
     var sel = $("#purchaseorder-top").val();
       var val = $("input[name=new]:checked").val();
      if( sel === "" && val === "2")
      {

            alert("tolong di isi Field Barang");
              return false;

      }
      else{
          return true;
      }


  });


	',$this::POS_READY);
