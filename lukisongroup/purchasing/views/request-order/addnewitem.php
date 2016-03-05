<?php

use \Yii;
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\builder\Form;
use kartik\widgets\TouchSpin;
use yii\web\JsExpression;
use yii\data\ActiveDataProvider;

use lukisongroup\purchasing\models\ro\RodetailSearch;

use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\hrd\models\Corp;
use lukisongroup\master\models\Suplier;
use kartik\money\MaskMoney;
use kartik\widgets\SwitchInput;
use kartik\checkbox\CheckboxX;



 $corp = Yii::$app->getUserOpt->Profile_user()->emp->EMP_CORP_ID;
// $userCorp = ArrayHelper::map(Corp::find()->all(), 'CORP_ID', 'CORP_NM');
// $brgType = ArrayHelper::map(Tipebarang::find()->where(['PARENT'=>0,'CORP_ID'=>$corp])->orderBy('NM_TYPE')->all(), 'KD_TYPE', 'NM_TYPE');
$brgUnit = ArrayHelper::map(Unitbarang::find()->orderBy('NM_UNIT')->all(), 'KD_UNIT', 'NM_UNIT');
// $brgKtg = ArrayHelper::map(Kategori::find()->where(['PARENT'=>0,'STATUS'=>1,'CORP_ID'=>$corp])->orderBy('NM_KATEGORI')->all(), 'KD_KATEGORI', 'NM_KATEGORI');
$brgUmum = ArrayHelper::map(Barang::find()->where(['PARENT'=>0,'STATUS'=>1,'KD_CORP'=>$corp])->orderBy('NM_BARANG')->all(), 'KD_BARANG', 'NM_BARANG');
// $dropsup = ArrayHelper::map(Suplier::find()->all(), 'KD_SUPPLIER', 'NM_SUPPLIER');
?>
	<?php
	/*
	 * DESCRIPTION FORM AddItem
	 * Form Add Items Hanya ada pada Form Edit | ACTION addItem
	 * Items Barang tidak bisa di input Duplicated. | Unix by KD_RO dan KD_BARANG
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	?>

	<div  style="padding-top:20">
		<!-- Render create form -->
			<?php
			/* echo $this->render('_form', [
						'roDetail' => $roDetail,
					]); */
          $profile= Yii::$app->getUserOpt->Profile_user();
          // $corp = Yii::$app->getUserOpt->Profile_user()->EMP_ID;
          // $Corp1 = Employe::find()->where(['KD_CORP'=>$corp])->asArray()->one();
          $corp = Yii::$app->getUserOpt->Profile_user()->emp->EMP_CORP_ID;

			?>
			<?php
				$form = ActiveForm::begin([
					'id'=>'additem-update',
					'enableClientValidation' => true,
					'enableAjaxValidation' => true,
					'method' => 'post',
					'action' => ['/purchasing/request-order/additem_saved'],
					  // 'validationUrl'=>Url::toRoute('/purchasing/request-order/valid')
				]);
				?>

				<?= $form->field($roDetail, 'addnew')->radioList([
				'1' => 'Add New Item ',
				'2' => ' Add item',
		 ],
		['item' => function($index, $label, $name, $checked, $value) {
																			$return = '<label class="modal-radio">';
																			$return .= '<input type="radio" id="ada" name="' . 'AdditemValidation[addnew]'. '" value="' . $value . '" tabindex="-1">';
																			$return .= '<i></i>';
																			$return .= '<span>' . ucwords($label) . '</span>';
																			$return .= '</label>';

																			return $return;
																	}
															])->label(false)?>



			  <?=  $form->field($roDetail, 'kD_CORP',['template' => "{input}"])->hiddenInput(['value'=>$corp,'readonly' => true]) ?>
			<?php  echo $form->field($roDetail, 'kD_RO',['template' => "{input}"])->textInput(['value'=>$roHeader->KD_RO,'type' =>'hidden']) ?>
			<div id="Kdbg">
			<?= $form->field($roDetail, 'kD_BARANG')->widget(Select2::classname(), [
						'data' =>$brgUmum,
						'options' => [
							'placeholder' => 'Pilih  Barang ...'
					],
						'pluginOptions' => [
							'allowClear' => true
						],
				])->label('Nama Barang') ?>
			</div>




				<div id="Nbrg">
				<?= $form->field($roDetail, 'nM_BARANG')->textInput(['maxlength' => true])->label('Nama Item Baru') ?>
					</div>

				<div id="hrg">

				<?= $form->field($roDetail, 'hARGA')->widget(MaskMoney::classname(), [
					'pluginOptions' => [
							'prefix' => 'Rp',
						 'precision' => 2,
							'allowNegative' => false
					]
				])->label('Harga') ?>

			</div>
			<?php
				echo $form->field($roDetail, 'uNIT')->widget(Select2::classname(), [
						'data' => $brgUnit,
						'options' => ['placeholder' => 'Pilih Unit Barang ...'],
						'pluginOptions' => [
							'allowClear' => true
						],
					]);


			?>


			<?php echo  $form->field($roDetail, 'rQTY')->textInput(['maxlength' => true, 'placeholder'=>'Jumlah Barang']); ?>


			<?php echo $form->field($roDetail, 'nOTE')->textarea(array('rows'=>2,'cols'=>5))->label('Informasi');?>

		    <div class="form-group">
			   <!-- Html::submitButton($roDetail->isNewRecord ? 'Create' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?> -->
				 <?php echo Html::submitButton('SAVE',['class' => 'btn btn-primary','id'=>'btn']); ?>
			</div>
			<?php ActiveForm::end(); ?>
			</div>
</div>
<?php
  $this->registerJs('

  $("div#additemvalidation-addnew").click(function()
  {
      var val = $("#ada:checked").val();
      if(val === "1")
      {
      		$("#Kdbg").hide();
					$("#Nbrg").show();
					$("#hrg").show();


      }
    else{
					$("#Kdbg").show();
					$("#Nbrg").hide();
					$("#hrg").hide();
      }



  });

  // $("#btn").click(function(){
  //   var val = $("#ada:checked").val();
  //   var sel = $("select#additemvalidation-kd_barang").val();
  //   var newitem = $("#additemvalidation-nm_barang").val();
  //    if(sel == "" && val == "2")
  //   {
  //     alert("tolong di isi Field Barang");
  //                return false;
  //   }
  //   else if(val == "1" && newitem == "")
  //   {
  //     alert("tolong di isi Item Barang");
  //       return false;
  //   }
  //   else{
  //      return true;
  //   }
  // })




	',$this::POS_READY);
