<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use lukisongroup\master\models\Customer;
use lukisongroup\esm\models\Barang;
/* @var $this yii\web\View */
/* @var $searchModel crm\salespromo\models\Stock_gudangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock Gudang Customer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-gudang-index">
	<div style="margin-left:15px; margin-right:15px">
		<h3><?= Html::encode($this->title) ?></h3>
		<h4><?php echo '<h6>Tanggal : ' . Yii::$app->ambilKonvesi->convert(date('Y-m-d'),'date').'</h6>';?></h4>
		<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

		
	
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],				
				'WAKTU',
				//'ID',				
				[
					'attribute'=>'CUST_KD',
					'format' => 'html',
					'value'=>function($model, $key, $index, $widget) { 
								$cus_atrb = Customer::find()->where(['CUST_KD'=>$model->CUST_KD])->one();
								if (count($cus_atrb)==0){
									return '<div style="color:red"> CUST_KD Changed </div>';
								}else{
									return $cus_atrb['CUST_NM'];
								}							
							},
				],
				[
					'attribute'=>'KD_BARANG',
					'format' => 'html',
					'value'=>function($model, $key, $index, $widget) { 
								$brg_atrb = Barang::find()->where(['KD_BARANG'=>$model->KD_BARANG])->one();
								if (count($brg_atrb)==0){
									return '<div style="color:red"> KD_BARANG Changed </div>';
								}else{
									return $brg_atrb['NM_BARANG'];
								}									
							},
				],
				// 'NM_BARANG',
				[
					'label'=>'Stock-Unit',
					'hAlign'=>'right',
					'attribute'=>'STOCK_GUDANG_UNIT'
				],
				[
					'label'=>'Stock-PCS',
					'hAlign'=>'right',
					'attribute'=>'STOCK_GUDANG_PCS',
				],				 
				// 'PRODAK_LINE',
				// 'CORP_ID',
				// 'KD_DISTRIBUTOR',
				// 'KD_SUBDIST',
				 'CREATED_BY',
				// 'UPDATED_BY',
				// 'UPDATED_TIME',
				// 'STATUS',
				//'WAKTU',

				//['class' => 'yii\grid\ActionColumn'],
			],
			'pjax'=>true,
                        'pjaxSettings'=>[
                        'options'=>[
	                'enablePushState'=>false,
	                'id'=>'active',
                            ],
                          ],
			'toolbar' => [
				'{export}',
			],
			'panel' => [
				//'heading'=>'<h3 class="panel-title">'.Html::encode($this->title).'</h3>',
				'type'=>'warning',
				'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Stock Gudang ',
						['modelClass' => 'customer',]),'/salespromo/stock-gudang/create',[
							'data-toggle'=>"modal",
								'data-target'=>"#stock-gudang",							
									'class' => 'btn btn-success'						
												]),	
				'showFooter'=>false,
			],
			'export' =>['target' => GridView::TARGET_BLANK],
			'exportConfig' => [
				GridView::PDF => [ 'filename' => 'customer'.'-'.date('ymdHis') ],
				GridView::EXCEL => [ 'filename' => 'customer'.'-'.date('ymdHis') ],
			],
		]); ?>
		
<?php
	$this->registerJs("
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
        $('#stock-gudang').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            var title = button.data('title') 
            var href = button.attr('href') 
            modal.find('.modal-title').html(title)
            modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
            $.post(href)
                .done(function( data ) {
                    modal.find('.modal-body').html(data)					
                });
            }),			
    ",$this::POS_READY);
    
    Modal::begin([
        'id' => 'stock-gudang',
        'header' => '<h4 class="modal-title">Input Stock Gudang</h4>',
    ]);
    Modal::end();
	
?>
	</div>
</div>
