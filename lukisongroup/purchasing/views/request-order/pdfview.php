<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use lukisongroup\master\models\Unitbarang;

$this->title = $roHeader->KD_RO;
$this->params['breadcrumbs'][] = ['label' => 'Request Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
	/*
	 * STATUS Prosess Request Order
	 * 1. PROCESS	=0 		| Pertama RO di buat
	 * 2. PENDING	=1		| Ro Tertunda
	 * 3. APPROVED	=101	| Ro Sudah Di Approved
	 * 4. COMPLETED	=10		| Ro Sudah selesai | RO->PO->RCVD
	 * 5. DELETE	=3 		| Ro Di hapus oleh pembuat petama, jika belum di Approved
	 * 6. REJECT	=4		| Ro tidak di setujui oleh Atasan manager keatas
	 * 7. UNKNOWN	<>		| Ro tidak valid
	*/
	function statusProcessRo($model){
		if($model->STATUS==0 or $model->STATUS==1){
			return Html::img('@web/img_setting/kop/check_box_normal-20.png',  ['style'=>'width:12px;height:12px;']);
		}elseif ($model->STATUS==101 or  $model->STATUS==10){
			return Html::img('@web/img_setting/kop/check_box_true-20.png',  ['class' => 'pnjg', 'style'=>'width:12px;height:12px;']);
		}else{
			return Html::img('@web/img_setting/kop/check_box_false-20.png',  ['class' => 'pnjg', 'style'=>'width:12px;height:12px;']);
		};	
	}
?>

<div class="container" style="font-family: tahoma;font-size: 8pt;">
	<!-- Header !-->
	<div>
		<div style="width:240px; float:left;">
			<?php echo Html::img('@web/img_setting/kop/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>	
		</div>
		<div style="padding-top:40px;">
			<!-- <h5 class="text-left"><b>FORM PERMINTAAN BARANG & JASA</b></h5> !-->				
			<h4 class="text-left"><b>REQUEST ORDER</b></h4>				
		</div>
		
		<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
		<hr style="height:1px;margin-top: 1px; margin-bottom: 10px;">
	</div>
	<!-- Title Descript !-->
	<div>
		<dl>
			  <dt style="width:100px; float:left;">Date</dt>
			  <dd>: <?php echo date('d-M-Y'); ?></dd>
			  <dt style="width:100px; float:left;">Nomor</dt>
			  <dd>: <?php echo Html::encode($this->title); ?></dd>     	  
			  <dt style="width:100px; float:left;">Departement</dt>	 
			  <dd>: 
				<?php 
					if (count($dept)!=0){
						echo $dept->DEP_NM;
					}else{
						echo 'Dept Set';
					}
				?>
			</dd>
		</dl>
	</div>
	<!-- Table Grid List RO Detail !-->
	<div>
		<?php 
			echo GridView::widget([
				'id'=>'ro-process',
				'dataProvider'=> $dataProvider,
				//'filterModel' => ['STATUS'=>'10'],
				'headerRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.3); align:center'],
				'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.3); align:center'],
				'beforeHeader'=>[
					[
						'columns'=>[
							['content'=>'', 'options'=>['colspan'=>2,'class'=>'text-center info',]], 
							['content'=>'Quantity', 'options'=>[
									'colspan'=>3, 
									'class'=>'text-center info',
									'style'=>[
										'width'=>'10px',
										'font-family'=>'tahoma, arial, sans-serif',
										'font-size'=>'8pt',										
									]
								]
							], 
							['content'=>'Remark', 'options'=>[
									'colspan'=>2, 
									'class'=>'text-center info',
									'style'=>[
										'width'=>'10px',
										'font-family'=>'tahoma, arial, sans-serif',
										'font-size'=>'8pt',
									]
								]
							], 
							//['content'=>'Action Status ', 'options'=>['colspan'=>1,  'class'=>'text-center info']], 
						],
					]
				], 
				'columns' => [
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
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>'center',
								'width'=>'10px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
							]
						], 
					],						
					/* ['attribute'=>'ID',], */
					[		
						/* Attribute Items Barang */
						'label'=>'Items',
						'attribute'=>'NM_BARANG',
						//'hAlign'=>'left',	
						//'vAlign'=>'middle',
						'mergeHeader'=>true,
						'format' => 'raw',	
						'headerOptions'=>[
							//'class'=>'kartik-sheet-style'							
							'style'=>[
								'text-align'=>'center',
								'width'=>'200px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'width'=>'200px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
							]
						], 
					],
					[
						/* Attribute Request Quantity */
						'attribute'=>'RQTY',
						'label'=>'R.Qty',						
						'vAlign'=>'middle',
						'hAlign'=>'center',	
						'mergeHeader'=>true,
						'headerOptions'=>[
							//'class'=>'kartik-sheet-style'							
							'style'=>[
								'text-align'=>'center',
								'width'=>'40px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
									'width'=>'40px',
									'font-family'=>'tahoma, arial, sans-serif',
									'font-size'=>'8pt',
							]
						]									
					],
					[
						/* Attribute Submit Quantity */
						'attribute'=>'SQTY',	
						'label'=>'S.Qty',
						'mergeHeader'=>true,											
						'vAlign'=>'middle',	
						'hAlign'=>'center',
						'headerOptions'=>[
							//'class'=>'kartik-sheet-style'							
							'style'=>[
								'text-align'=>'center',
								'width'=>'40px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
									'width'=>'40px',
									'font-family'=>'tahoma, arial, sans-serif',
									'font-size'=>'8pt',
							]
						]							
					],
					[
						/* Attribute Unit Barang */
						'attribute'=>'UNIT',
						'mergeHeader'=>true,
						'label'=>'Unit',										
						'vAlign'=>'middle',	
						'hAlign'=>'right',	
						'headerOptions'=>[
							//'class'=>'kartik-sheet-style'							
							'style'=>[
								'text-align'=>'center',
								'width'=>'150px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
						],						
						'contentOptions'=>[
							'style'=>[
									//'text-align'=>'left',		
									'width'=>'150px',
									'font-family'=>'tahoma, arial, sans-serif',
									'font-size'=>'8pt',
							]
						],		
						'value'=>function($model){
							$model=Unitbarang::find()->where('KD_UNIT="'.$model->UNIT. '"')->one();
							if (count($model)!=0){
								$UnitNm=$model->NM_UNIT;
							}else{
								$UnitNm='Not Set';
							}
							return $UnitNm;
						}
					],
					[
						/* Attribute Unit Barang */
						'attribute'=>'NOTE',
						'label'=>'Noted',
						'hAlign'=>'left',						
						'mergeHeader'=>true,
						'headerOptions'=>[
							//'class'=>'kartik-sheet-style'							
							'style'=>[
								'text-align'=>'center',
								'width'=>'200px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
						],			
						'contentOptions'=>[
							'style'=>[
									'width'=>'200px',
									'font-family'=>'tahoma, arial, sans-serif',
									'font-size'=>'8pt',
							]
						],		
					],
					[
						/* Attribute Status Detail RO */
						'attribute'=>'STATUS',
						'options'=>['id'=>'test-ro'],						
						'label'=>'#',
						'hAlign'=>'center',
						'vAlign'=>'middle',
						'mergeHeader'=>true,
						'contentOptions'=>['style'=>'width: 100px'],
						'format' => 'html', 
						'value'=>function ($model, $key, $index, $widget) { 
									return statusProcessRo($model);
						},
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'10px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)', 
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>'center',
								'width'=>'10px',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
							]
						], 										
					],
				],
				'pjax'=>true,
				'pjaxSettings'=>[
				'options'=>[
					'enablePushState'=>false,
					'id'=>'ro-process',
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
	</div>
	
	<div>
		<?php 
			$tgl1 = explode(' ',$roHeader->CREATED_AT);
			$awl1 = explode('-',$tgl1[0]); 
			$blnAwl1 = date("F", mktime(0, 0, 0, $awl1[1], 1));
			
			function tgl2signature($tgl){
				if($tgl<>0){
					$tgl2 = explode(' ',$tgl);
					$awl2 = explode('-',$tgl2[0]); 
					$blnAwl2 = date("F", mktime(0, 0, 0, $awl2[1], 1));
					$TglSign=' '.$awl2[2].'-'.$blnAwl2.'-'.$awl2[0];
					return $TglSign;
				}
				return '';				
			}
			
		?>
		<table id="tblRo" class="table table-bordered" style="width:360px;font-family: tahoma;font-size: 8pt;">
			<!-- Tanggal!-->
			 <tr>
				<!-- Tanggal Pembuat RO!-->
				<th style="text-align: center; height:20px">
					<div style="margin-left:50px">
						Tanggerang, <?php echo tgl2signature($roHeader->SIG1_TGL);  ?>
					</div> 
				
				</th>		
				<!-- Tanggal RO Approved!-->				
				<th style="text-align: center; height:20px">
					<div style="margin-left:50px">
						Tanggerang, <?php echo tgl2signature($roHeader->SIG2_TGL);  ?>
					</div> 				
				</th>
				<!-- Tanggal RO Approved!-->				
				<th style="text-align: center; height:20px">
					<div style="margin-left:50px">
						Tanggerang, <?php echo tgl2signature($roHeader->SIG3_TGL);  ?>
					</div> 				
				</th>				
			</tr>
			<!--Keterangan !-->
			 <tr>
				<th style="background-color:rgba(126, 189, 188, 0.3);text-align: center; height:20px">
					  Created
				</th>								
				<th style="background-color:rgba(126, 189, 188, 0.3);text-align: center; height:20px">
					  Checked
				</th>
				<th style="background-color:rgba(126, 189, 188, 0.3);text-align: center; height:20px">
					  Approved
				</th>				
			</tr>
			<!-- Signature !-->
			 <tr>
				<th style="text-align: center; vertical-align:middle;width:120; height:60px">
					<img src="<?php echo $roHeader->SIG1_SVGBASE64;?> height='120' width='150'"></img>
				</th>								
				<th style="text-align: center; vertical-align:middle;width:120">
					<img src="<?php echo $roHeader->SIG2_SVGBASE64;?> height='120' width='150'"></img>
				</th>
				<th style="text-align: center; vertical-align:middle;width:120">
					<img src="<?php echo $roHeader->SIG3_SVGBASE64;?> height='120' width='150'"></img>
				</th>
			</tr>
			<!--Nama !-->
			 <tr>
				<th style="text-align: center; vertical-align:middle;height:20">
					<div>		
						<b><?php  echo $roHeader->SIG1_NM; ?></b>
					</div>
				</th>								
				<th style="text-align: center; vertical-align:middle;height:20">
					<div>		
						<b><?php  echo $roHeader->SIG2_NM; ?></b>
					</div>
				</th>
				<th style="text-align: center; vertical-align:middle;height:20">
					<div>		
						<b><?php  echo $roHeader->SIG3_NM; ?></b>
					</div>
				</th>
			</tr>
		</table>
	</div>
	</th>
	<!-- RO Note !-->	
	<div  style="font-family: tahoma;font-size: 8pt;">
		<dt><b>General Notes :</b></dt>
		<hr style="height:1px;margin-top: 1px; margin-bottom: 1px;">	
		<dd><?php echo 'Input Note grid'; ?></dd><br/><br/><br/><br/>     
		<hr style="height:1px;margin-top: 1px;">
	</div>
</div>

		

	



