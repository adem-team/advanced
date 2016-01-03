<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

use lukisongroup\master\models\Suplier;
use lukisongroup\master\models\Barangumum;
use lukisongroup\master\models\Nmperusahaan;
use lukisongroup\purchasing\models\Purchasedetail;
use lukisongroup\esm\models\Barang;
/* @var $this yii\web\View */
/* @var $poHeader lukisongroup\poHeaders\esm\po\Purchaseorder */

$this->title = 'Detail PO';
$this->params['breadcrumbs'][] = ['label' => 'Purchaseorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$y=4;
?>

 <?php 
        $sup = Suplier::find()->where(['KD_SUPPLIER'=>$poHeader->KD_SUPPLIER])->one(); 
        $pod = Purchasedetail::find()->where(['KD_PO'=>$poHeader->KD_PO])->all(); 

        $ship = Nmperusahaan::find()->where(['ID' => $poHeader->SHIPPING])->one(); 
        $bill = Nmperusahaan::find()->where(['ID' => $poHeader->BILLING])->one(); 
		
		/* $x=10;
		function ax(){
			return '10';
		}
		 */
		/* function formulaAmount($summary, $data, $widget){
				//$calculate = dataCell($model, $key, $index);
				//$p = compact('model', 'key', 'index');
				return '<div>'.$summary * $this->model().',</div>
						<div>'.min($data).'</div>
						<div>'.$summary.'</div>
						<div>100,0</div>
						<div><b>10000,0</b></div>'; 
		}; */

 ?>

<div class="container" style="font-family: tahoma ;font-size: 8pt;">
	<!-- Header !-->
	<div>
		<div style="width:240px; float:left;">
			<?php echo Html::img('@web/img_setting/kop/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>	
		</div>
		<div style="padding-top:40px;">
			<!-- <h5 class="text-left"><b>FORM PERMINTAAN BARANG & JASA</b></h5> !-->				
			<h4 class="text-left"><b>PURCHASE ORDER</b></h4>				
		</div>
		<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
		<hr style="height:1px;margin-top: 1px; margin-bottom: 10px;">
		
	</div>
	<!-- Title HEADER Descript !-->	
	<div>
		<div style="width:250px; float:left">
			<dl>
				<dt><b><?= $sup->NM_SUPPLIER; ?></b></dt>				
				<dt><?= $sup->ALAMAT; ?></dt>				
				<dt><?= $sup->KOTA; ?></dt>
				<dt style="width:80px; float:left;">Telp / Fax</dt>
				<dd>: <?= $sup->TLP; ?> / <?= $sup->FAX; ?></dd>     	  
				
				<dt style="width:80px; float:left;">Email</dt>
				<dd>: <?= $sup->EMAIL; ?></dd>     	  
				
			</dl>
		</div>
		<div style="float:left; margin-left:160px">
			<dl>
				<!-- Date !-->
				<dt style="width:80px; float:left;">Date</dt>
				<dd>: <?php echo date('d-M-Y'); ?></dd>
				<!-- PO NO !-->
				<dt style="width:80px; float:left;">No. Order</dt>
				<dd>: <?= $poHeader->KD_PO; ?></dd>  
				<!-- Purchese Order Created !-->
				<dt style="width:80px; float:left;">Order By</dt>
				<dd>: <?php echo "alam@lukison.com"; ?></dd>     
				<!-- Estimasi Time Arrival!-->
				<dt style="width:80px; float:left;">ETA</dt>
				<dd>: <?= $poHeader->ETD; ?></dd>   
				<!-- Estimasi Time Delevery !-->
				<dt style="width:80px; float:left;">ETD</dt>
				<dd>: <?= $poHeader->ETA; ?></dd> 				
			</dl>
		</div>
	</div>
	<!-- Title GRID PO Detail !-->	
	<div>
		<?php 
		
			$gridColumns = [
					[
						/* Attribute Serial No */
						'class'=>'kartik\grid\SerialColumn',
						//'contentOptions'=>['class'=>'kartik-sheet-style'],
						'width'=>'10px',
						'header'=>'No.',
						'hAlign'=>'center',
						'headerOptions'=>[
							//'class'=>'kartik-sheet-style'							
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
						'attribute'=>'QTY',
						'label'=>'Qty',						
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
					[/* Attribute Unit Barang */
						'attribute'=>'NM_UNIT',
						'mergeHeader'=>true,
						'label'=>'UoM',										
						'vAlign'=>'middle',	
						'hAlign'=>'right',	
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
									'text-align'=>'left',		
									'width'=>'100px',
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
						]						
					],
					[
						/* Attribute Unit Barang */
						'attribute'=>'HARGA',
						'mergeHeader'=>true,
						'label'=>'Price',										
						'vAlign'=>'middle',	
						'hAlign'=>'right',	
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
							'style'=>[
									'text-align'=>'right',		
									'width'=>'150px',
									'font-family'=>'tahoma',
									'font-size'=>'8pt',									
							]
						],
						'format'=>['decimal', 2],
						'pageSummary'=>function ($summary, $data, $widget) { 
										return '<div>Sub Total [ IDR ]</div>
												<div>Discount| </div>
												<div>TAX| 0% </div>
												<div>Delevery.Cost</div>
												<div><b>GRAND TOTAL [ IDR ]</b></div>'; 
									},
						'pageSummaryOptions' => [
							'style'=>[
									'font-family'=>'tahoma',
									'font-size'=>'8pt',	
									'text-align'=>'right',
									'border-left'=>'0px',																
							]
						],
					],
					[
						'class'=>'kartik\grid\FormulaColumn', 
						'header'=>'Amount', 
						'mergeHeader'=>true,
						'vAlign'=>'middle',
						'hAlign'=>'right', 
						//'width'=>'7%',					
						'value'=>function ($model, $key, $index, $widget) { 
							$p = compact('model', 'key', 'index');
							return $widget->col(3, $p) != 0 ? $widget->col(3, $p) * $widget->col(5, $p) : 0;
							//return $widget->col(3, $p) != 0 ? $widget->col(5 ,$p) * 100 / $widget->col(3, $p) : 0;
						},						
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
							'style'=>[
									'text-align'=>'right',		
									'width'=>'150px',
									'font-family'=>'tahoma',
									'font-size'=>'8pt',									
							]
						],	
						'pageSummaryFunc'=>GridView::F_SUM,
						'pageSummary'=>true,
						'pageSummary'=>function ($summary, $data, $widget) use ($poHeader)	{	
								/*Definition*/
								$subtotal=$summary;
								$discount=($poHeader->DISC)/100;
								$tax=($poHeader->PAJAK)/100;
								$delevery=$poHeader->DELIVERY_COST;
								/*Calculate ptr.nov*/
								$ttlDiscount=$poHeader->DISC!=0 ? $discount*$subtotal:0.00;
								$ttlTax = $poHeader->PAJAK!=0 ? $tax*$subtotal :0.00;
								$ttlDelevery=$poHeader->DELIVERY_COST!=0 ? $ttlDelevery:0.00;
								$grandTotal=$subtotal + $ttlDiscount + $ttlTax + $ttlDelevery;					
								
								//return formulaAmount($summary, $data, $widget);
								return '<div>'.$subtotal.',</div>
									<div>'.$ttlDiscount.'</div>
									<div>'.$ttlTax.'</div>
									<div>'.$ttlDelevery.'</div>	
									<div><b>'.$grandTotal.'</b></div>';  
						},
						'pageSummaryOptions' => [
							'style'=>[
									'text-align'=>'right',		
									'width'=>'100px',
									'font-family'=>'tahoma',
									'font-size'=>'8pt',	
									//'text-decoration'=>'underline',
									//'font-weight'=>'bold',
									//'border-left-color'=>'transparant',		
									'border-left'=>'0px',									
							]
						],											
						'footer'=>true,						
					],
					/* [
						// Attribute Status Detail RO 
						'attribute'=>'STATUS',
						'options'=>['id'=>'test-ro'],						
						'label'=>'#',
						'hAlign'=>'center',
						'vAlign'=>'middle',
						'mergeHeader'=>true,
						'contentOptions'=>['style'=>'width: 100px'],
						'format' => 'html', 
						'value'=>function ($poHeader, $key, $index, $widget) { 
									return statusProcessRo($poHeader);
						},
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'10px',
								'font-family'=>'tahoma',
								'font-size'=>'8pt',
								'background-color'=>'rgba(0, 15, 118, 0.3)', 
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
					], */
				/* [
					'class'=>'kartik\grid\FormulaColumn', 
					'header'=>'Buy %<br>(100 * B/BS)', 
					'vAlign'=>'middle',
					'hAlign'=>'right', 
					'width'=>'7%',
					'footer'=>true
				] */
			];
			
			echo GridView::widget([
				'id'=>'po-process',
				'dataProvider'=> $dataProvider,				
				/* 'footerRowOptions'=>[
					['style'=>['class'=>'text-left info',]], 
				], */
				//'footerRowOptions'=>['style'=>'background-color:rgba(0, 95, 218, 0.3); align:center;border:0.1px solid'],
					'showPageSummary' => true,
					//'pageSummaryRowOptions'=>[
				//],
				//'summary' => "{begin} - {end} {count} {totalCount} {page} {pageCount}",
				/*  'afterFooter'=>[
					[
						'columns'=>[
							['content'=>'Quantity', 'options'=>['colspan'=>2, 'class'=>'text-center info']], 
							['content'=>'Remark', 'options'=>['colspan'=>2, 'class'=>'text-center info']], 
							//['content'=>'Action Status ', 'options'=>['colspan'=>1,  'class'=>'text-center info']], 
						],
					]
				],   */
				/* 'pageSummaryRowOptions'=>[
					['attribute'=>'HARGA',],
					['attribute'=>'QTY',],
				], */
				//'filterModel' => ['STATUS'=>'10'],
				//'headerRowOptions'=>['style'=>'background-color:rgba(0, 95, 218, 0.3); align:center;border:0.1px solid'],
				//	'filterRowOptions'=>['style'=>'background-color:rgba(0, 95, 218, 0.3); align:center;border:0.1px solid'],
				/* 'beforeHeader'=>[
					[
						'columns'=>[
							['content'=>'Quantity', 'options'=>[
									'colspan'=>3, 
									'class'=>'text-center info',
									'style'=>[
										'width'=>'10px',
										'font-family'=>'tahoma',
										'font-size'=>'8pt',																	
									]
								]
							], 
							['content'=>'Remark', 'options'=>[
									'colspan'=>2, 
									'class'=>'text-center info',
									'style'=>[
										'width'=>'10px',
										'font-family'=>'tahoma',
										'font-size'=>'8pt',							
									]
								]
							], 
							//['content'=>'Action Status ', 'options'=>['colspan'=>1,  'class'=>'text-center info']], 
						],
					]
				],  */
				'columns' => $gridColumns,
				'pjax'=>true,
				'pjaxSettings'=>[
				'options'=>[
					'enablePushState'=>false,
					'id'=>'ro-process',
				   ],						  
				],
				'panel' => [
					'footer'=>false,
					'heading'=>false,						
				],
				'toolbar'=> [
					//'{items}',
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
	</div>
	<!-- Title BOTTEM Descript !-->	
	<div>
		<div style="width:290px;float:left;">
			<dl>
				<dt><h6><u><b>Shipping Address :</b></u></h6></dt>
				<dt><?php echo '<b>'.$ship->NM_ALAMAT.'</b>'; ?></dt> 				
				<dt><?php echo $ship->ALAMAT_LENGKAP; ?></dt>				
				<dt><?php echo $sup->KOTA; ?></dt>

				<dt style="width:80px; float:left;">Tlp</dt>
				<dd>:	<?php echo $ship->TLP;?></dd>     	  
				
				<dt style="width:80px; float:left;">FAX</dt>
				<dd>:	<?php echo $ship->FAX; ?></dd>     	  
				
				<dt style="width:80px; float:left;">CP</dt>
				<dd>:	<?php echo $ship->CP; ?></dd> 
			</dl>
		</div>
		<div style="float:left; margin-left:60px">
			<dl>
				<dt><h6><u><b>Billing Address :</b></u></h6></dt>
				<dt><?php echo '<b>'.$ship->NM_ALAMAT.'</b>'; ?></dt>				
				<dt><?php echo $ship->ALAMAT_LENGKAP; ?></dt>				
				<dt><?= $sup->KOTA; ?></dt>

				<dt style="width:80px; float:left;">Tlp</dt>
				<dd>:	<?php echo $ship->TLP;?></dd>     	  
				
				<dt style="width:80px; float:left;">FAX</dt>
				<dd>:	<?php echo $ship->FAX; ?></dd>     	  
				
				<dt style="width:80px; float:left;">CP</dt>
				<dd>:	<?php echo $ship->CP; ?></dd> 
			</dl>
		</div>		
	</div>	
	<!-- PO Note !-->	
	<div style="font-family: tahoma ;font-size: 8pt;">
		<dt><b>General Notes :</b></dt>
		<hr style="height:1px;margin-top: 1px; margin-bottom: 1px;">	
		<dd><?php echo 'Input Note grid' .	$poHeader->NOTE; ?></dd><br/><br/><br/><br/>     
		<hr style="height:1px;margin-top: 1px;">
	</div>
	<!-- Signature PO !-->	
	<div>
		<table id="tblRo" class="table table-bordered" style="width:360px;font-family: tahoma ;font-size: 8pt;">
			<!-- Tanggal!-->
			 <tr>
				<!-- Tanggal Pembuat RO!-->
				<th style="text-align: center; height:20px">
					<div style="text-align:center;">
						<?php
							$placeTgl1=$poHeader->SIG1_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG1_TGL,'date') :'';
							echo '<b>Tanggerang</b>,' . $placeTgl1;  
						?>
					</div> 
				
				</th>		
				<!-- Tanggal Pembuat RO!-->
				<th style="text-align: center; height:20px">
					<div style="text-align:center;">
						<?php
							$placeTgl2=$poHeader->SIG2_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG2_TGL,'date') :'';
							echo '<b>Tanggerang</b>,' . $placeTgl2;  
						?>
					</div> 
				
				</th>		
				<!-- Tanggal PO Approved!-->				
				<th style="text-align: center; height:20px">
					<div style="text-align:center;">
						<?php
							$placeTgl3=$poHeader->SIG3_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG3_TGL,'date') :'';
							echo '<b>Tanggerang</b>,' . $placeTgl3;  
						?>
					</div> 				
				</th>	
				
			</tr>
			<!-- Signature !-->
			 <tr>
				<th style="text-align: center; vertical-align:middle;width:180; height:60px">	
					<?php 
						$ttd1 = $poHeader->SIG1_SVGBASE64!=0 ?  '<img src="'.$poHeader->SIG1_SVGBASE64.'" height="120" width="150"></img>' : '';
						echo $ttd1;
					?> 				
				</th>								
				<th style="text-align: center; vertical-align:middle;width:180">
					<?php 
						$ttd2 = $poHeader->SIG2_SVGBASE64!=0 ?  '<img src="'.$poHeader->SIG2_SVGBASE64.'" height="120" width="150"></img>' : '';
						echo $ttd2;
					?> 	
				</th>
				<th style="text-align: center; vertical-align:middle;width:180">
					<?php 
						$ttd3 = $poHeader->SIG3_SVGBASE64!=0 ?  '<img src="'.$poHeader->SIG3_SVGBASE64.'" height="120" width="150"></img>' : '';
						echo $ttd3;
					?> 	
				</th>
			</tr>
			<!--Nama !-->
			 <tr>
				<th style="text-align: center; vertical-align:middle;height:20; background-color:rgba(0, 95, 218, 0.3);text-align: center;">
					<div>		
						<?php
							$sigNm1=$poHeader->SIG1_NM!='none' ? '<b>'.$poHeader->SIG1_NM.'</b>' : 'none';
							echo $sigNm1;
						?>
					</div>
				</th>								
				<th style="text-align: center; vertical-align:middle;height:20; background-color:rgba(0, 95, 218, 0.3);text-align: center;">
					<div>		
						<?php
							$sigNm2=$poHeader->SIG2_NM!='none' ? '<b>'.$poHeader->SIG2_NM.'</b>' : 'none';
							echo $sigNm2;
						?>
					</div>
				</th>
				<th style="text-align: center; vertical-align:middle;height:20; background-color:rgba(0, 95, 218, 0.3);text-align: center;">
					<div>		
						<?php
							$sigNm3=$poHeader->SIG3_NM!='none' ? '<b>'.$poHeader->SIG3_NM.'</b>' : 'none';
							echo $sigNm3;
						?>
					</div>
				</th>
			</tr>
			<!-- Department|Jbatan !-->
			 <tr>
				<th style="text-align: center; vertical-align:middle;height:20">
					<div>		
						<b><?php  echo 'Purchaser'; ?></b>
					</div>
				</th>								
				<th style="text-align: center; vertical-align:middle;height:20">
					<div>		
						<b><?php  echo 'F & A'; ?></b>
					</div>
				</th>
				<th style="text-align: center; vertical-align:middle;height:20">
					<div>		
						<b><?php  echo 'Director'; ?></b>
					</div>
				</th>
			</tr>
		</table>
	</div>	
</div>



