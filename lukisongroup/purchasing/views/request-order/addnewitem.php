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
			?>
			<?php
				$form = ActiveForm::begin([
					'id'=>'additem-update',
					'enableClientValidation' => true,
					// 'enableAjaxValidation' => true,
					'method' => 'post',
					'action' => ['/purchasing/request-order/save-new-add'],
					  // 'validationUrl'=>Url::toRoute('/purchasing/request-order/valid')
				]);
				?>

				<?= $form->field($model, 'addNEW')->radioList([
				'1' => 'Add New Item ',
				'2' => ' Add item',
		],
		['item' => function($index, $label, $name, $checked, $value) {
																			$return = '<label class="modal-radio">';
																			$return .= '<input type="radio" name="' . 'newadd'. '" value="' . $value . '" tabindex="-1">';
																			$return .= '<i></i>';
																			$return .= '<span>' . ucwords($label) . '</span>';
																			$return .= '</label>';

																			return $return;
																	}
															])->label(false)?>

			  <!-- echo $form->field($roDetail, 'cREATED_AT',['template' => "{input}"])->hiddenInput(['value'=>date('Y-m-d H:i:s'),'readonly' => true]) ?> -->
			<?php  echo $form->field($roDetail, 'KD_RO',['template' => "{input}"])->textInput(['value'=>$roHeader->KD_RO,'type' =>'hidden']) ?>
			<div id="Kdbg">
			<?= $form->field($roDetail, 'KD_BARANG')->widget(Select2::classname(), [
						'data' =>$brgUmum,
						'options' => ['id'=>'top',
							'placeholder' => 'Pilih  Barang ...'
					],
						'pluginOptions' => [
							'allowClear' => true
						],
				]) ?>
			</div>


				<div id="Nbrg">
				<?= $form->field($roDetail, 'NAMA_BARANG')->textInput(['maxlength' => true])->label('Nama Item Baru') ?>
					</div>

				<div id="hrg">

				<?= $form->field($roDetail, 'HARGA')->widget(MaskMoney::classname(), [
					'pluginOptions' => [
							'prefix' => 'Rp',
						 'precision' => 2,
							'allowNegative' => false
					]
				])->label('Harga') ?>

			</div>
			<?php
				echo $form->field($roDetail, 'UNIT')->widget(Select2::classname(), [
						'data' => $brgUnit,
						'options' => ['placeholder' => 'Pilih Unit Barang ...'],
						'pluginOptions' => [
							'allowClear' => true
						],
					]);


			?>


			<?php echo  $form->field($roDetail, 'RQTY')->textInput(['maxlength' => true, 'placeholder'=>'Jumlah Barang']); ?>


			<?php echo $form->field($roDetail, 'NOTE')->textarea(array('rows'=>2,'cols'=>5))->label('Informasi');?>

		    <div class="form-group">
				<?php //echo Html::submitButton($roDetail->isNewRecord ? 'Save' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				<?php echo Html::submitButton('SAVE',['class' => 'btn btn-primary']); ?>
			</div>
			<?php ActiveForm::end(); ?>
			</div>
</div>
<?php
  $this->registerJs('

  $("div#dynamicmodel-addnew").click(function()
  {
      var val = $("input[name=newadd]:checked").val();
      // alert(val);
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


	',$this::POS_READY);
