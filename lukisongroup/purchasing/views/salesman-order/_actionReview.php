<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;



$kode_so = Yii::$app->getRequest()->getQueryParam('id');
$ary = $aryProviderSoDetail->getModels();

/*
 * Tombol Create
 * 
*/
function tombolCreate($cust_kd,$kode_so,$user_id,$cust_nm,$tgl){

			$title1 = Yii::t('app', 'ADD NEW ITEM');
			$options1 = [ 'id'=>'new-add-create',
							'data-toggle'=>"modal",
							'data-target'=>"#new-add",
							'class' => 'btn btn-success btn-sm',
			];
			$icon1 = '<span class="fa fa-plus fa-lg"></span>';
			$url = Url::toRoute(['/purchasing/salesman-order/create-new-add','cust_kd'=>$cust_kd,'user_id'=>$user_id,'id'=>$kode_so,'cust_nm'=>$cust_nm,'tgl'=>$tgl]);
			$label1 = $icon1 . ' ' . $title1;
			$content = Html::a($label1,$url,$options1);
			return $content;
		 }

 
 $soDetailColumn= [
	/*No Urut*/
	[
		'class'=>'kartik\grid\SerialColumn',
		'contentOptions'=>['class'=>'kartik-sheet-style'],
		'width'=>'10px',
		'header'=>'No.',
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
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
	/*CREATE_AT Tanggal Pembuatan*/
	[
		'class'=>'kartik\grid\EditableColumn',
		'attribute'=>'TGL',
		'label'=>'Create At',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'90px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'90px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt'
			]
		],
	],	
	/*CREATE_AT Tanggal Pembuatan*/
	[
		'attribute'=>'NM_BARANG',
		'label'=>'SKU',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'250px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'250px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt'
			]
		],
	],						
	/*NM_UNIT*/
	[
		// 'class'=>'kartik\grid\EditableColumn',
		'attribute'=>'NM_UNIT',
		'label'=>'UNIT',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'group'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'80px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'80px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		],
	],
	/*QTY_PCS*/
	[
		'attribute'=>'SO_QTY',
		'label'=>'QTY/Pcs',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'group'=>true,
		'format'=>['decimal',2],
		'pageSummaryFunc'=>GridView::F_SUM,
		'pageSummary'=>true,
		'value'=>function($model){
			return round($model['SO_QTY'],0,PHP_ROUND_HALF_UP);
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		],
		'pageSummaryOptions' => [
			'style'=>[
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'text-align'=>'right',
					'border-left'=>'0px',
			]
		],
	],
	/*UNIT_BRG*/
	[
		'attribute'=>'SO_QTY',
		'label'=>'QTY/Karton',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'group'=>true,
		'value'=>function($model){
			return round($model['UNIT_BRG'],0,PHP_ROUND_HALF_UP);
		},
		'format'=>['decimal',2],
		'pageSummaryFunc'=>GridView::F_SUM,
		'pageSummary'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'100px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'100px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		],
		'pageSummaryOptions' => [
			'style'=>[
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'text-align'=>'right',
					'border-left'=>'0px',
			]
		],
	],
	/*HARGA_SALES_PCS*/
	[

		'attribute'=>'HARGA_SALES',
		'label'=>'PRICE/Pcs',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'group'=>true,
		'format'=>['decimal',2],
		'value'=>function($model){
			return round($model['HARGA_SALES'],0,PHP_ROUND_HALF_UP);
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		],
	],
	/*SUB TTL SO*/
	[
		'attribute'=>'SUB_TOTAL',
		'label'=>'SUB.TOTAL',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'group'=>true,
		'format'=>['decimal',2],
		'pageSummaryFunc'=>GridView::F_SUM,
		'pageSummary'=>true,
		'value'=>function($model){
			return round($model['SUB_TOTAL'],0,PHP_ROUND_HALF_UP);
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		],
		'pageSummaryOptions' => [
			'style'=>[
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'text-align'=>'right',
					'border-left'=>'0px',
			]
		],
	],
	/*SUBMIT_QTY*/
	#editable
	[
		'class'=>'kartik\grid\EditableColumn',
		'attribute'=>'SUBMIT_QTY',
		'refreshGrid'=>true,
		'label'=>'PREMIT QTY/Pcs',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'editableOptions' => [
			'header' => 'PREMIT QTY/Pcs',
			'inputType' => \kartik\editable\Editable::INPUT_MONEY,
			'size' => 'xs',
			],
		'group'=>true,
		'format'=>['decimal',2],
		'pageSummaryFunc'=>GridView::F_SUM,
		'pageSummary'=>true,
		'value'=>function($model){
			return round($model['ID'],0,PHP_ROUND_HALF_UP);
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(74, 206, 231, 1)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		],
		'pageSummaryOptions' => [
			'style'=>[
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'text-align'=>'right',
					'border-left'=>'0px',
			]
		],
	],
	/*SUBMIT_QTY*/
	#editable
	[
		'class'=>'kartik\grid\EditableColumn',
		'attribute'=>'SUBMIT_PRICE',
		'refreshGrid'=>true,
		'label'=>'PREMIT PRICE/Pcs',
		'editableOptions' => [
			'header' => 'PREMIT PRICE/Pcs',
			'inputType' => \kartik\editable\Editable::INPUT_MONEY,
			'size' => 'xs',
			],
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'group'=>true,
		'format'=>['decimal',2],
		'value'=>function($model){
			return round($model['SUBMIT_PRICE'],0,PHP_ROUND_HALF_UP);
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(74, 206, 231, 1)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		]
	],
	/*SUB TTL SUBMIT SO*/
	[
		'attribute'=>'SUBMIT_SUB_TOTAL',
		'label'=>'PREMIT SUB.TOTAL',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'group'=>true,
		'format'=>['decimal',2],
		'pageSummaryFunc'=>GridView::F_SUM,
		'pageSummary'=>true,
		'value'=>function($model){
			return round($model['SUBMIT_SUB_TOTAL'],0,PHP_ROUND_HALF_UP);
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(74, 206, 231, 1)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		],
		'pageSummaryOptions' => [
			'style'=>[
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'text-align'=>'right',
					'border-left'=>'0px',
			]
		],
	],
];

$_gvSoDetail= GridView::widget([
	'id'=>'gv-so-detail-md-inbox',
	'dataProvider'=> $aryProviderSoDetail,
	// 'filterModel' => $searchModelDetail,
	'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
	'showPageSummary' => true,
	/*
		'beforeHeader'=>[
			[
				'columns'=>[
					['content'=>'List Permintaan Barang & Jasa', 'options'=>['colspan'=>4, 'class'=>'text-center success']],
					['content'=>'Action Status ', 'options'=>['colspan'=>6, 'class'=>'text-center warning']],
				],
				'options'=>['class'=>'skip-export'] // remove this row from export
			]
		],
	*/
	'columns' => $soDetailColumn,
	'pjax'=>true,
	'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-so-detail-md-inbox',
		   ],
	],
	'hover'=>true, //cursor select
	'responsive'=>true,
	'responsiveWrap'=>true,
	'bordered'=>true,
	'striped'=>'4px',
	'autoXlFormat'=>true,
	'export' => false,
	'toolbar'=> [
		 ['content'=>tombolCreate($cust_kd,$kode_so,$user_id,$ary[0]['CUST_NM'],$tgl)],
	 ],
	'panel'=>[
		'type'=>GridView::TYPE_INFO,
		'heading'=>false //'<div> NO.SO :'.date("d-M-Y")
		
	],
]);

?>


<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<div class="col-md-12">
		<div class="col-md-3" style="float:left">
			<div  class="row" >
				<dl>
					<dt style="width:300px; float:left;font-family: verdana, arial, sans-serif ;font-size: 11pt;">
						PT EFENBI SUKSES MAKMUR
					</dt>
					<dt style="width:100px; float:left;"></dt>
					<dt style="width:200px; float:left;">
						Ruko Demansion Blok C12
					</dt>
					<dt style="width:200px; float:left;">
						Jalan jalur Sutera Timur
					</dt>
					<dt style="width:200px; float:left;">
						Alam sutera - Tangerang
					</dt>
					<dt style="width:200px; float:left;">					
						Telp : 021-30448598-99 /fax 021-30448597
					</dt>
				</dl>
			</div>
		</div>
		<div class="col-md-5" style="padding-top:15px;">
		</div>
		<div class="col-md-3" style="float:left;padding-bottom:-100px">
			<dl>
				<dt style="width:100px; float:left;">Tanggal </dt>
				<dd>: <?php echo date('d-m-Y'); ?></dd>
				<dt style="width:100px; float:left;">Kode Cust</dt>
				<dd>: <?php echo $cust_kd  ?></dd>
				<dt style="width:100px; float:left;">Customer </dt>
				<dd>: <?php echo $ary[0]['CUST_NM']; ?></dd>
				<dt style="width:100px; float:left;">Alamat  </dt>
				<dd>: <?php echo $model_cus->ALAMAT; ?></dd>
				<dt style="width:100px; float:left;">Telp   </dt>
				<dd>: <?php echo $model_cus->TLP1; ?></dd>
				<dt style="width:100px; float:left;">Tgl Kirim  </dt>
				<dd>: <?php //echo $roHeader->KD_RO; ?></dd>
			</dl>
		</div>
	</div>
	<!-- HEADER !-->
	<div class="col-md-12 text-center"  style="float:left;font-family: verdana, arial, sans-serif ;font-size: 14pt;">
		<b>SALES ORDER</b>	
	</div>
	<!-- Title Descript !-->
	<div class="col-md-12">
		
	</div>
	<!-- Table Grid List SO Detail !-->
	<div class="col-md-12">
		<dl>
			<dt style="width:50px; float:left;">SO NO</dt>
			<dd>: <?= $kode_som ?></dd>
		</dl>
		<?=$_gvSoDetail?>
	</div>
	<!-- Signature !-->
		<div  class="col-md-12">
			<div  class="row" >
				<div class="col-md-6">
					<table id="tblRo" class="table table-bordered" style="font-family: tahoma ;font-size: 8pt;">
						<!-- Tanggal!-->
						 <tr>
							<!-- Tanggal Pembuat RO!-->
							<th  class="col-md-1" style="text-align: center; height:20px">
								<div style="text-align:center;">
									<?php
										//$placeTgl1=$poHeader->SIG1_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG1_TGL,'date') :'';
										echo '<b>Tanggerang</b>,';// . $placeTgl1;
									?>
								</div>

							</th>
							<!-- Tanggal Pembuat RO!-->
							<th class="col-md-1" style="text-align: center; height:20px">
								<div style="text-align:center;">
									<?php
										//$placeTgl2=$poHeader->SIG2_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG2_TGL,'date') :'';
										echo '<b>Tanggerang</b>,';// . $placeTgl2;
									?>
								</div>

							</th>
							<!-- Tanggal PO Approved!-->
							<th class="col-md-1" style="text-align: center; height:20px">
								<div style="text-align:center;">
									<?php
										//$placeTgl3=$poHeader->SIG3_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG3_TGL,'date') :'';
										echo '<b>Tanggerang</b>,';// . $placeTgl3;
									?>
								</div>
							</th>

						</tr>
						<!-- Department|Jbatan !-->
						 <tr>
							<th  class="col-md-1" style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
								<div>
									<b><?php  echo 'Created'; ?></b>
								</div>
							</th>
							<th class="col-md-1"  style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
								<div>
									<b><?php  echo 'Checked'; ?></b>
								</div>
							</th>
							<th class="col-md-1" style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
								<div>
									<b><?php  echo 'Approved'; ?></b>
								</div>
							</th>
						</tr>
						<!-- Signature !-->
						 <tr>
							<th class="col-md-1" style="text-align: center; vertical-align:middle; height:40px">
								<?php
									//$ttd1 = $poHeader->SIG1_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$poHeader->SIG1_SVGBASE64.'></img>' :SignCreated($poHeader);
									//echo $ttd1;
								?>
							</th>
							<th class="col-md-1" style="text-align: center; vertical-align:middle">
								<?php
									//$ttd2 = $poHeader->SIG2_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$poHeader->SIG2_SVGBASE64.'></img>' :SignChecked($poHeader);
									//echo $ttd2;
								?>
							</th>
							<th  class="col-md-1" style="text-align: center; vertical-align:middle">
								<?php
									/* if(getPermission())
									{
										if(getPermission()->BTN_SIGN3 == 0)
										{
											$ttd3 = '';
											echo $ttd3;

										}else{
											$ttd3 = $poHeader->SIG3_SVGBASE64!='' ?  '<img src="'.$poHeader->SIG3_SVGBASE64.'" height="60" width="150"></img>' : SignApproved($poHeader);
											echo $ttd3;
										}
									}else{
										$ttd3 = '';
										echo $ttd3;
									} */
								?>
							</th>
						</tr>
						<!--Nama !-->
						 <tr>
							<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
								<div>
									<?php
										/* $sigNm1=$poHeader->SIG1_NM!='none' ? '<b>'.$poHeader->SIG1_NM.'</b>' : 'none';
										echo $sigNm1; */
									?>
								</div>
							</th>
							<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
								<div>
									<?php
										/* $sigNm2=$poHeader->SIG2_NM!='none' ? '<b>'.$poHeader->SIG2_NM.'</b>' : 'none';
										echo $sigNm2; */
									?>
								</div>
							</th>
							<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
								<div>
									<?php
										/* $sigNm3=$poHeader->SIG3_NM!='none' ? '<b>'.$poHeader->SIG3_NM.'</b>' : 'none';
										echo $sigNm3; */
									?>
								</div>
							</th>
						</tr>
						<!-- Department|Jbatan !-->
						 <tr>
							<th style="text-align: center; vertical-align:middle;height:20">
								<div>
									<b><?php  //echo 'Purchaser'; ?></b>
								</div>
							</th>
							<th style="text-align: center; vertical-align:middle;height:20">
								<div>
									<b><?php  //echo 'F & A'; ?></b>
								</div>
							</th>
							<th style="text-align: center; vertical-align:middle;height:20">
								<div>
									<b><?php  //echo 'Director'; ?></b>
								</div>
							</th>
						</tr>
					</table>
				</div>
				<!-- Button Submit!-->
				<div style="text-align:right; margin-top:80px; margin-right:15px">
					<a href="/purchasing/salesman-order" class="btn btn-info btn-xs" role="button" style="width:90px">Back</a>
					<?php
					 echo Html::a('<i class="fa fa-print fa-fw"></i> Print', ['cetakpdf'], ['target' => '_blank', 'class' => 'btn btn-warning btn-xs']); ?>
					<?php //echo Html::a('<i class="fa fa-print fa-fw"></i> tmp Print', ['temp-cetakpdf','kdpo'=>$poHeader->KD_PO], ['target' => '_blank', 'class' => 'btn btn-warning btn-xs']); ?>

				</div>
			</div>
		</div>
</div>


<?php
/*
 * JS  CREATED
 * @author wawan
 * @since 1.2
*/
$this->registerJs("
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
		$('#new-add').on('show.bs.modal', function (event) {
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
		'id' => 'new-add',
		'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>New Item</b></h4></div>',
		// 'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
		]
	]);
Modal::end();