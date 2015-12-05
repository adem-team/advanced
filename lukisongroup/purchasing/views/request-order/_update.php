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

use lukisongroup\master\models\Barangumum;
use lukisongroup\esm\models\Barang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\purchasing\models\RodetailSearch;

$brgUnit = ArrayHelper::map(Unitbarang::find()->orderBy('NM_UNIT')->all(), 'KD_UNIT', 'NM_UNIT');
$brgKtg = ArrayHelper::map(Kategori::find()->orderBy('NM_KATEGORI')->all(), 'KD_KATEGORI', 'NM_KATEGORI');
$brgUmum = ArrayHelper::map(Barangumum::find()->orderBy('NM_BARANG')->all(), 'KD_BARANG', 'NM_BARANG'); 
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
					'id'=>'roInput',
					'enableClientValidation' => true,
					'method' => 'post',
					'action' => ['/purchasing/request-order/simpantambah'],
				]);
			?>
			
			<?= $form->field($roDetail, 'CREATED_AT',['template' => "{input}"])->textInput(['value'=>date('Y-m-d H:i:s'),'readonly' => true]) ?>
			<?= $form->field($roDetail, 'KD_RO',['template' => "{input}"])->textInput(['value'=>$roHeader->KD_RO,'readonly' => true]) ?>

			<?php
				 echo $form->field($roDetail, 'KD_KATEGORI')->dropDownList($brgKtg, ['id'=>'kat-id']);
				 
				 echo $form->field($roDetail, 'KD_BARANG')->widget(DepDrop::classname(), [
					'type'=>DepDrop::TYPE_SELECT2,
					'data' => $brgUmum,
					'options' => ['id'=>'brg-id'],
					'pluginOptions' => [
						'depends'=>['kat-id'],
						'url'=>Url::to(['/purchasing/request-order/brgkat']),
						'initialize'=>true,
					], 		
				]);
				
				echo $form->field($roDetail, 'UNIT')->widget(DepDrop::classname(), [
					'type'=>DepDrop::TYPE_DEFAULT,
					'data' => $brgUnit,
					'options' => ['id'=>'unit-id','readonly'=>true,'selected'=>false],
					'pluginOptions' => [
						'depends'=>['kat-id','brg-id'],
						'url'=>Url::to(['/purchasing/request-order/brgunit']),
						'initialize'=>true, 
						'placeholder' => false,
					], 		
				]); 
			?>
		
			<?php echo  $form->field($roDetail, 'RQTY')->textInput(['maxlength' => true, 'placeholder'=>'Jumlah Barang']); ?>

			<?php echo $form->field($roDetail, 'NOTE')->textarea(array('rows'=>2,'cols'=>5))->label('Informasi');?>

		    <div class="form-group">
				<?= Html::submitButton($roDetail->isNewRecord ? 'Add' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>

			
			<?php ActiveForm::end(); ?>
			</div>
		<?php
		 echo GridView::widget([
					'id'=>'ro-form',
					'dataProvider'=> $dataProvider,
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
									if (count($masterUnit)!=0){
										return $masterUnit->NM_UNIT;
									}else{
										return "Not Set";
									}
									
								}	 						
							],
							[
								'header'=>'Action',	
								'class' =>'yii\grid\ActionColumn',
								'template' => '{tambah} {link} {edit} {delete} {cetak}',
								'buttons' => [									
									'delete' => function ($url,$model) { if($model->STATUS == 0){ return Html::a('', ['hapusro','id'=>$model->KD_RO],['class'=>'fa fa-trash-o fa-lg', 'title'=>'Hapus RO','data-confirm'=>'Anda yakin ingin menghapus RO ini?']); } },
								],
							],	
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

