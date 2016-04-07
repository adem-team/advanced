<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use lukisongroup\purchasing\models\pr\Podetail;
use lukisongroup\purchasing\models\pr\Purchasedetail;
use lukisongroup\master\models\Unitbarang;

?>

<?php
/* $form = ActiveForm::begin([
    'method' => 'post',
    'action' => ['/purchasing/purchase-order/simpan'],
]); */


	echo GridView::widget([
		'id'=>'gv-ropo',
        'dataProvider' => $roDetailProvider,
        'columns' => [
			[/* Attribute Serial No */
				'class'=>'kartik\grid\SerialColumn',
				'width'=>'10px',
				'header'=>'No.',
				'hAlign'=>'center',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'background-color'=>'rgba(0, 95, 218, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
					]
				],
				'pageSummaryOptions' => [
					'style'=>[
							'border-right'=>'0px',
					]
				]
			],
			[/* Attribute Items Barang */
				'attribute'=>'KD_BARANG',
				'label'=>'SKU',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'mergeHeader'=>true,
				'format' => 'raw',
				'headerOptions'=>[
					//'class'=>'kartik-sheet-style'
					'style'=>[
						'text-align'=>'center',
						'width'=>'150px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'background-color'=>'rgba(0, 95, 218, 0.3)',
					]
				],
				'contentOptions'=>[
					'is'=>'kd-brg',
					'style'=>[
						'width'=>'150px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
					]
				],
				'pageSummaryOptions' => [
					'style'=>[
							'border-left'=>'0px',
							'border-right'=>'0px',
					]
				]
			],
			[/* Attribute Items Barang */
				'label'=>'Items Name',
				'attribute'=>'NM_BARANG',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'mergeHeader'=>true,
				'format' => 'raw',
				'headerOptions'=>[
					//'class'=>'kartik-sheet-style'
					'style'=>[
						'text-align'=>'center',
						'width'=>'200px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'background-color'=>'rgba(0, 95, 218, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'width'=>'200px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
					]
				],
				'pageSummaryOptions' => [
					'style'=>[
							'border-left'=>'0px',
							'border-right'=>'0px',
					]
				]
			],
			[/* Attribute Request Quantity */
				'attribute'=>'SQTY',
				'label'=>'S.Qty',
				'vAlign'=>'middle',
				'hAlign'=>'center',
				'mergeHeader'=>true,
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'60px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'background-color'=>'rgba(0, 95, 218, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
							'text-align'=>'right',
							'width'=>'60px',
							'font-family'=>'tahoma',
							'font-size'=>'8pt',
							//'border-right'=>'0px',
					]
				],
				'pageSummaryOptions' => [
					'style'=>[
							'border-left'=>'0px',
							'border-right'=>'0px',
					]
				]
			],
			[/* Attribute Request Quantity */
				'attribute'=>'PQTY',
				'label'=>'P.Qty',
				'vAlign'=>'middle',
				'hAlign'=>'center',
				'mergeHeader'=>true,
				'value'=>function($model, $key, $index, $column) {
					// SUM QRY KD_RO AND KD_BARANG (HANYA Ada qty item barang pada RO)
					//Purchasedetail::find()->where(['KD_RO'=>$dataKdRo,'KD_BARANG'=>$roDetail->KD_BARANG])->ALL();
					//$countQtyTaken=Purchasedetail::find(SUM('QTY'))->where(['KD_RO' => $model->KD_RO,'KD_BARANG' => $model->KD_BARANG])->all();
					/*SUM QTY Dimana KD_RO DAN KD BARANG = jika requestorder->SQTY=Purchesedetail->QTY makan niali 0 => Hidden*/
					$pqtyTaken= "SELECT SUM(QTY) as QTY FROM p0002 WHERE STATUS<>3 AND KD_RO='".$model->KD_RO. "' AND KD_BARANG='".$model->KD_BARANG ."' GROUP BY KD_BARANG";
					$countQtyTaken=Purchasedetail::findBySql($pqtyTaken)->one();
					//print_r($countQtyTaken->QTY);
					if($countQtyTaken){
						$qtyInPo=$countQtyTaken->QTY!=''? $countQtyTaken->QTY :0;
					}else{
						$qtyInPo=0;
					}

					return $qtyInPo;
				},
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'60px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'background-color'=>'rgba(0, 95, 218, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
							'text-align'=>'right',
							'width'=>'60px',
							'font-family'=>'tahoma',
							'font-size'=>'8pt',
							//'border-right'=>'0px',
					]
				],
				'pageSummaryOptions' => [
					'style'=>[
							'border-left'=>'0px',
							'border-right'=>'0px',
					]
				]
			],
			[/* Attribute Unit Barang */
				'attribute'=>'UNIT',
				'mergeHeader'=>true,
				'label'=>'UoM',
				'vAlign'=>'middle',
				'hAlign'=>'right',
				'value'=>function($model){
							$model=Unitbarang::find()->where('KD_UNIT="'.$model->UNIT. '"')->one();
							if (count($model)!=0){
								$UnitNm=$model->NM_UNIT;
							}else{
								$UnitNm='Not Set';
							}
							return $UnitNm;
				},
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'150px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'background-color'=>'rgba(0, 95, 218, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
							'text-align'=>'left',
							'width'=>'150px',
							'font-family'=>'tahoma',
							'font-size'=>'8pt',
							'border-left'=>'0px',
					]
				],
				'pageSummaryOptions' => [
					'style'=>[
							'border-left'=>'0px',
							'border-right'=>'0px',
					]
				],
				'pageSummary'=>function ($summary, $data, $widget){
								return 	'<div>Sub Total :</div>
										<div>Discount :</div>
										<div>TAX :</div>
										<div>Delevery.Cost :</div>
										<div><b>GRAND TOTAL :</b></div>';
							},
				'pageSummaryOptions' => [
					'style'=>[
							'font-family'=>'tahoma',
							'font-size'=>'8pt',
							'text-align'=>'right',
							'border-left'=>'0px',
							'border-right'=>'0px',
					]
				],
			],
			[/* Attribute Harga */
				'attribute'=>'HARGA',
				'label'=>'Price',
				'vAlign'=>'middle',
				'hAlign'=>'center',
				'mergeHeader'=>true,
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'100px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'background-color'=>'rgba(0, 95, 218, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
							'text-align'=>'right',
							'width'=>'100px',
							'font-family'=>'tahoma',
							'font-size'=>'8pt',
							//'border-right'=>'0px',
					]
				],
				'pageSummaryOptions' => [
					'style'=>[
							'border-left'=>'0px',
							'border-right'=>'0px',
					]
				]
			],

          	[/* Attribute TMP_CK CheckboxColumn */
				'class'=>'kartik\grid\CheckboxColumn',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'20px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'background-color'=>'rgba(0, 95, 218, 0.3)',

					]
				],
				'contentOptions'=>[
					'readonly'=>true,
					'style'=>[
							'text-align'=>'center',
							'width'=>'20px',
							'font-family'=>'tahoma',
							'font-size'=>'8pt',
							'border-left'=>'0px',
					]
				],
				/* 'checkboxOptions' => function($model, $key, $index, $column) {
					 return ['checked' => true];
				},  */
				'checkboxOptions' => [
					'is'=>'ck-gv',
          'class' => 'simple',
					'style'=>[
						'text-align'=>'left',
						'width'=>'20px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'border-left'=>'0px',
					],
					//'value' =>function ($model, $key, $index, $column){ return ['value' => $model->KD_RO];}
                ],
				'rowSelectedClass' => GridView::TYPE_WARNING,

				//'class'=>'kartik\grid\EditableColumn',
				//'attribute'=>'STT_SEND_PO',
			/* 	'editableOptions' => function($model, $key, $index, $widget) {
					return [
						'id'=>'cek-stt-po',
						'header' => 'Buy Amount',
						'inputType' => kartik\editable\Editable::INPUT_CHECKBOX_X,

					];
				}, */

				'checkboxOptions' => function ($model, $key, $index, $column)use ($kdpo) {
					$poDetail=Purchasedetail::find()->where('STATUS<>3 AND KD_PO="'.$kdpo.'" AND KD_RO="'.$model->KD_RO.'" AND KD_BARANG="'.$model->KD_BARANG.'"')->one();
					if ($poDetail){
						return ['checked' => $model->TMP_CK, 'hidden'=>true];

					}else{
						/*FORMULA*/
						$pqtyTaken= "SELECT SUM(QTY) as QTY FROM p0002 WHERE STATUS<>3 AND KD_RO='".$model->KD_RO."' AND KD_BARANG='" .$model->KD_BARANG."' GROUP BY KD_BARANG";
						$countQtyTaken=Purchasedetail::findBySql($pqtyTaken)->one();
						if($countQtyTaken){
							$qtyInPo=$countQtyTaken->QTY!=''? $countQtyTaken->QTY :0;
						}else{
							$qtyInPo=0;
						}
						//$qtyInPo=$countQtyTaken!=''? $countQtyTaken->QTY :0;
						$actualQty=$model->SQTY - $qtyInPo;
						if($actualQty>0){
							return ['checked' => $model->TMP_CK];
						}else{
							return ['checked' => $model->TMP_CK, 'hidden'=>true];
						}
					}
				}
			],
        ],
		'pjax'=>true,
		'pjaxSettings'=>[
		 'options'=>[
			'enablePushState'=>true,
			'id'=>'gv-ropo',
		   ],
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
    ]);


?>



<!--
	<input type="hidden" name="kdpo" value="<?php echo $kdpo; ?>" />
	<input type="hidden" name="kdro" value="<?php echo $kd_ro; ?>" />
	 input type="hidden" name="_csrf" value="< ?=Yii::$app->request->getCsrfToken()?>"
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Pilih Barang</button>
	</div>/ -->

<?php
	/*  ActiveForm::end();  */

	/*
	 * JS GRIDVIEW SEND_TO_PO | CheckboxColumn
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.2
	*/
	$this->registerJs("
			var target = $(this).attr('href');
			 $('#gv-ropo input[type=checkbox]').change(function(){
				 var roKode=\"".$kd_ro."\";
				 var poKode=\"".$kdpo."\";
				 var keysSelect = $('#gv-ropo').yiiGridView('getSelectedRows');
				 $.ajax({
					 url: '/purchasing/purchase-order/ck',
					 //cache: true,
					 type: 'POST',
					 data:{keysSelect:keysSelect,kdRo:roKode,kdpo:poKode},
					 dataType: 'json',
					 success: function(response) {
						 if (response.status== true ){
								 $.pjax.reload('#gv-po-detail');
								//  $.pjax.reload({container:'#gv-po-detail', timeout: 1000});
								 //alert(response.status);

						 }
							else {
								alert('SKU Item already exists ');
								$.pjax.reload('#gv-po-detail');
								//$('this').checked = false
								//document.getElementById('gv-ropo').checked = false;
								//$('#ck-gv').checked = false;
								//$('input:checkbox[name=checkme]').attr('checked',false);
							}
						}
					});
				});

	",$this::POS_READY);
