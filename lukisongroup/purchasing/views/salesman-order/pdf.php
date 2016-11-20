<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

// use lukisongroup\master\models\Suplier;
// use lukisongroup\master\models\Barangumum;
// use lukisongroup\master\models\Nmperusahaan;
// use lukisongroup\purchasing\models\pr\Purchasedetail;
// use lukisongroup\esm\models\Barang;
/* @var $this yii\web\View */
/* @var $poHeader lukisongroup\poHeaders\esm\po\Purchaseorder */

// $this->title = 'Detail PO';
// $this->params['breadcrumbs'][] = ['label' => 'Purchaseorders', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;

// $y=4;

$this->title = 'Sales Order';
$this->params['breadcrumbs'][] = $this->title;
$this->sideCorp = 'Sales Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_customers';


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
		'attribute'=>'TGL',
		'label'=>'DATE',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'filter'=>false,
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
		]
	],						
	/*NM_UNIT*/
	[
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
		'attribute'=>'SUBMIT_QTY',
		'label'=>'PREMIT QTY/Pcs',
		'hAlign'=>'right',
		'vAlign'=>'middle',		
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
		'attribute'=>'SUBMIT_PRICE',
		'label'=>'PREMIT PRICE/Pcs',		
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

$_gvSoDetailPdf= GridView::widget([
	'id'=>'gv-so-detail-pdf',
	'dataProvider'=> $aryProviderSoDetail,
	//'showPageSummary' => true,	
	'columns' => $soDetailColumn,
	'pjax'=>true,
	// 'pjaxSettings'=>[
		// 'options'=>[
			// 'enablePushState'=>false,
			// 'id'=>'gv-so-detail-pdf',
		   // ],
	// ],
	'hover'=>true, //cursor select
	'responsive'=>true,
	'responsiveWrap'=>true,
	'bordered'=>true,
	'striped'=>'4px',
	'autoXlFormat'=>true,
	'export' => false,
	// 'toolbar'=> [
		// ''
		
	 // ],
	// 'panel'=>[
		// 'type'=>GridView::TYPE_SUCCESS,
		// 'heading'=>false,//tombolCreate($cust_kd,$kode_so,$user_id,$ary[0]['CUST_NM'],$tgl),//$this->render('indexTimelineStatus'),//false //'<div> NO.SO :'.date("d-M-Y")
		// 'before'=>'SO NO : '. $kode_SO,
		// 'after'=>false,
		// 'footer'=>'<div>asd dsadas ad asd asdas d asd as d ad as d asd wrfddsfds sdf sdfsdf sdf sdfsdfsdfds fsd fsd fds fdsfdsfdsf dsfdsf sdf sd</div>'		
	// ]
]);
?>

 <?php
        // $sup = Suplier::find()->where(['KD_SUPPLIER'=>$poHeader->KD_SUPPLIER])->one();
        // $pod = Purchasedetail::find()->where(['KD_PO'=>$poHeader->KD_PO])->all();

        // $ship = Nmperusahaan::find()->where(['ID' => $poHeader->SHIPPING])->one();
        // $bill = Nmperusahaan::find()->where(['ID' => $poHeader->BILLING])->one();

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
	<!-- Title GRID PO Detail !-->
	<div class="row" >
		<div class="col-md-12">
			<?=$_gvSoDetailPdf?>
		</div>
	</div>
	<!-- Title BOTTEM Descript !-->
	<div class="row">
		<div class="col-md-4" style="width:290px;float:left;">
			<dl>
				<?php
					// $shipNm= $ship !='' ? $ship->NM_ALAMAT : 'Shipping Not Set';
					// $shipAddress= $ship!='' ? $ship->ALAMAT_LENGKAP :'Address Not Set';
					// $shipCity= $ship!='' ? $ship->KOTA : 'City Not Set';
					// $shipPhone= $ship!='' ? $ship->TLP : 'Phone Not Set';
					// $shipFax= $ship!='' ? $ship->FAX : 'Fax Not Set';
					// $shipPic= $ship!='' ? $ship->CP : 'PIC not Set';
				?>
				<dt><h6><u><b>Shipping Address :</b></u></h6></dt>
				<dt><?=$shipNm; ?></dt>
				<dt><?=$shipAddress;?></dt>
				<dt><?=$shipCity?></dt>
				<dt style="width:80px; float:left;">Tlp</dt>
				<dd>:	<?=$shipPhone;?></dd>
				<dt style="width:80px; float:left;">FAX</dt>
				<dd>:	<?=$shipFax; ?></dd>
				<dt style="width:80px; float:left;">CP</dt>
				<dd>:	<?=$shipPic; ?></dd>
			</dl>
		</div>
		<div class="col-md-4">
			<dl>
				<?php
					// $billNm= $bill !='' ? $bill->NM_ALAMAT : 'Billing Not Set';
					// $billAddress= $bill!='' ? $bill->ALAMAT_LENGKAP :'Address Not Set';
					// $billCity= $bill!='' ? $bill->KOTA : 'City Not Set';
					// $billPhone= $bill!='' ? $bill->TLP : 'Phone Not Set';
					// $billFax= $bill!='' ? $bill->FAX : 'Fax Not Set';
					// $billPic= $bill!='' ? $bill->CP : 'PIC not Set';
				?>
				<dt><h6><u><b>Billing Address :</b></u></h6></dt>
				<dt><?=$billNm;?></dt>
				<dt><?=$billAddress;?></dt>
				<dt><?=$billCity;?></dt>

				<dt style="width:80px; float:left;">Tlp</dt>
				<dd>:	<?=$billPhone;?></dd>

				<dt style="width:80px; float:left;">FAX</dt>
				<dd>:	<?=$billFax;?></dd>

				<dt style="width:80px; float:left;">CP</dt>
				<dd>:	<?=$billPic;?></dd>
			</dl>
		</div>
	</div>
	<!-- PO Term Of Payment !-->
	<div  class="row">
		<div  class="col-md-12" style="font-family: tahoma ;font-size: 9pt;">
			<dt><u><b>Term Of Payment :</b></u></dt>
			<!-- <hr style="height:1px;margin-top: 1px; margin-bottom: 1px;font-family: tahoma ;font-size:8pt;">!-->
			<div>
				<div style="margin-left:5px">
					<dt style="width:80px; float:left;"><?php //echo $poHeader->TOP_TYPE; ?></dt>
					<dd><?php //echo $poHeader->TOP_DURATION; ?></dd>
						<!-- <br/>!-->
				</div>
			</div>
		</div>
	</div>
	<!-- PO Note !-->
	<div  class="row">
		<div  class="col-md-12" style="margin-top:10px;font-family: tahoma ;font-size: 9pt;">
			<dt><u><b>General Notes :</b></u></dt>
			<!-- <hr style="height:1px;margin-top: 1px; margin-bottom: 1px;font-family: tahoma ;font-size:8pt;">!-->
			<div>
				<div style="margin-left:5px">
					<dd><?php //echo $poHeader->NOTE; ?></dd>
					<dt>Invoice exchange can be performed on Monday through Tuesday time of 09:00AM-16:00PM</dt>
				</div>
			</div>
			<hr style="height:1px;margin-top: 1px;">
		</div>
	</div>
	<!-- Signature PO !-->
	<div class="row">
		<table id="tblRo" class="table table-bordered" style="width:360px;font-family: tahoma ;font-size: 8pt;">
			<!-- Tanggal!-->
			 <tr>
				<!-- Tanggal Pembuat RO!-->
				<th style="text-align: center; height:20px">
					<div style="text-align:center;">
						<?php
							//$placeTgl1=$poHeader->SIG1_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG1_TGL,'date') :'';
							//echo '<b>Tangerang</b>,' . $placeTgl1;
						?>
					</div>

				</th>
				<!-- Tanggal Pembuat RO!-->
				<th style="text-align: center; height:20px">
					<div style="text-align:center;">
						<?php
							//$placeTgl2=$poHeader->SIG2_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG2_TGL,'date') :'';
							//echo '<b>Tangerang</b>,' . $placeTgl2;
						?>
					</div>

				</th>
				<!-- Tanggal PO Approved!-->
				<th style="text-align: center; height:20px">
					<div style="text-align:center;">
						<?php
							//$placeTgl3=$poHeader->SIG3_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG3_TGL,'date') :'';
							//echo '<b>Tangerang</b>,' . $placeTgl3;
						?>
					</div>
				</th>

			</tr>
			<!-- Signature !-->
			 <tr>
				<th style="text-align: center; vertical-align:middle;width:180; height:60px">
					<?php
						// $ttd1 = $poHeader->SIG1_SVGBASE64!='' ?  '<img src="'.$poHeader->SIG1_SVGBASE64.'" height="60" width="150"></img>' : '';
						// echo $ttd1;
					?>
				</th>
				<th style="text-align: center; vertical-align:middle;width:180">
					<?php
						// $ttd2 = $poHeader->SIG2_SVGBASE64!='' ?  '<img src="'.$poHeader->SIG2_SVGBASE64.'" height="60" width="150"></img>' : '';
						// echo $ttd2;
					?>
				</th>
				<th style="text-align: center; vertical-align:middle;width:180">
					<?php
          /**
          *if po header status equal four then reject
          *@author wawan
          */
          // if($poHeader->STATUS == 4)
          // {
            // $ttd3 = "<h4> <b> Reject </b></h4>";
          // }else{
            // $ttd3 = $poHeader->SIG3_SVGBASE64!='' ?  '<img src="'.$poHeader->SIG3_SVGBASE64.'" height="60" width="150"></img>' : '';
          // }
          // echo $ttd3;

					?>
				</th>
			</tr>
			<!--Nama !-->
			 <tr>
				<th style="text-align: center; vertical-align:middle;height:20; background-color:#88b3ec;text-align: center;">
					<div>
						<?php
							// $sigNm1=$poHeader->SIG1_NM!='none' ? '<b>'.$poHeader->SIG1_NM.'</b>' : 'none';
							// echo $sigNm1;
						?>
					</div>
				</th>
				<th style="text-align: center; vertical-align:middle;height:20; background-color:#88b3ec;text-align: center;">
					<div>
						<?php
							// $sigNm2=$poHeader->SIG2_NM!='none' ? '<b>'.$poHeader->SIG2_NM.'</b>' : 'none';
							// echo $sigNm2;
						?>
					</div>
				</th>
				<th style="text-align: center; vertical-align:middle;height:20; background-color:#88b3ec;text-align: center;">
					<div>
						<?php
							// $sigNm3=$poHeader->SIG3_NM!='none' ? '<b>'.$poHeader->SIG3_NM.'</b>' : 'none';
							// echo $sigNm3;
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
