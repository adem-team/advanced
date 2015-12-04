<?php

use \yii;
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use kartik\builder\Form;
use kartik\widgets\TouchSpin;
use lukisongroup\master\models\Barangumum;
use lukisongroup\esm\models\Barang;
use yii\web\JsExpression;
use yii\data\ActiveDataProvider;
use lukisongroup\purchasing\models\RodetailSearch;
use lukisongroup\master\models\Unitbarang;
/* @var $this yii\web\View */
/* @var $model crm\salespromo\models\Stock_gudang */
/* @var $form yii\widgets\ActiveForm */

//$cust = ArrayHelper::map(Customer::find(), 'CUST_KD', 'CUST_NM');
/*TEST ARRAY*/
$data = [
    "red" => "red",
    "green" => "green",
    "blue" => "blue",
    "orange" => "orange",
    "white" => "white",
    "black" => "black",
    "purple" => "purple",
    "cyan" => "cyan",
    "teal" => "teal"
]; 
/* $cust = ArrayHelper::map(Customer::find()->orderBy('CUST_NM')->all(), 'CUST_KD', 'CUST_NM');  */
$brgUmum = ArrayHelper::map(Barangumum::find()->orderBy('NM_BARANG')->all(), 'KD_BARANG', 'NM_BARANG'); 
//$url = \yii\helpers\Url::to(['/salespromo/stock-gudang/cust-list']);

/* $this->registerJs("
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};			
    ",$this::POS_HEAD);
 */

 //$newCode=\Yii::$app->ambilkonci->getRoCode();
 $searchModel1 = new RodetailSearch();
 //$dataProvider1 = $searchModel1->search_listbyro(Yii::$app->request->queryParams,'2015.11.27.RO.0001');
 $dataProvider1 = $searchModel1->search_listbyro('2015.11.27.RO.0001');
 
 
?>

	
	<div  style="padding-top:20">
		<!-- Render create form -->   		
			<?php $form = ActiveForm::begin([
			'id'=>'roInput',
			'enableClientValidation' => true,
			'method' => 'post',
			'action' => ['/purchasing/request-order/simpanfirst'],
				]);
			?>
			<?= $form->field($roDetail, 'CREATED_AT',['template' => "{input}"])->textInput(['value'=>date('Y-m-d H:i:s'),'readonly' => true]) ?>

			<?php
				 echo $form->field($roDetail, 'KD_BARANG')->widget(Select2::classname(), [		
					'data' => $brgUmum,
					'options' => ['placeholder' => 'Search for a barang umum ...'],
					'pluginOptions' => [
						'id'=>'id-brg',
						//'multiple' => true
						//'allowClear' => true
						//'maximumInputLength' => 3
					], 		
				]);
			?>

			<?php 
				//echo  $form->field($roDetail, 'UNIT')->textInput(['placeholder'=>'Unit Barang'])->label('Unit Barang'); 
				
			?>
			<?php echo  $form->field($roDetail, 'RQTY')->textInput(['maxlength' => true, 'placeholder'=>'Jumlah Barang']); ?>

			<?php echo $form->field($roDetail, 'NOTE')->textarea(array('rows'=>2,'cols'=>5))->label('Informasi');?>

			<?php //= $form->field($roDetail, 'NM_BARANG')->textInput(['maxlength' => true]) ?>			
			
			 <div class="form-group">
				<?= Html::submitButton($roDetail->isNewRecord ? 'Create' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
			
			<?php ActiveForm::end(); ?>	
	</div>
	<?php
		 echo GridView::widget([
					'id'=>'ro-form',
					'dataProvider'=> $dataProvider1,
					//'filterModel' => $searchModel,					
					'columns' => [
							[
								'attribute'=>'KD_RO',
								//'mergeHeader'=>true,
								//'group'=>true,
							],
							[
								'label'=>'Tanggal Pembuatan',
								'attribute'=>'CREATED_AT'								
							],			
							[
								'label'=>'Nama Barang',
								'attribute'=>'NM_BARANG',
								//'mergeHeader'=>true,
							],
							[
								'label'=>'Qty',
								'attribute'=>'RQTY',
								//'mergeHeader'=>true,
							],
							[
								'attribute'=>'UNIT',
								'mergeHeader'=>true,
								'value'=>function ($model, $key, $index, $widget) { 
									$masterUnit = Unitbarang::find()->where(['KD_UNIT'=>$model->UNIT])->one();
									return $masterUnit->NM_UNIT;
								}								
							]
					],
					'export' => false,
					'toggleData'=>false,
					'panel' => [
						//'heading'=>'<h3 class="panel-title">'. Html::encode($this->title).'</h3>',
						'type'=>'success',
					],					
				]);	 

	
	?>
</div>

