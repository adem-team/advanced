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

$kode_so = Yii::$app->getRequest()->getQueryParam('id');
$ary = $aryProviderSoDetail->getModels();


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
				'font-size'=>'12pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'12pt',
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
				'font-size'=>'12pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'90px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'12pt'
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
				'width'=>'300px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'12pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'200px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'12pt'
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
				'width'=>'90px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'12pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'90px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'12pt',
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
				'font-size'=>'12pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'12pt',
			]
		],
		'pageSummaryOptions' => [
			'style'=>[
					'font-family'=>'tahoma',
					'font-size'=>'12pt',
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
				'font-size'=>'12pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'100px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'12pt',
			]
		],
		'pageSummaryOptions' => [
			'style'=>[
					'font-family'=>'tahoma',
					'font-size'=>'12pt',
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
				'font-size'=>'12pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'12pt',
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
				'text-valign'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'12pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'12pt',
			]
		],
		'pageSummaryOptions' => [
			'style'=>[
					'font-family'=>'tahoma',
					'font-size'=>'12pt',
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
				'font-size'=>'12pt',
				'background-color'=>'rgba(74, 206, 231, 1)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'12pt',
			]
		],
		'pageSummaryOptions' => [
			'style'=>[
				'font-family'=>'tahoma',
				'font-size'=>'12pt',
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
				'font-size'=>'12pt',
				'background-color'=>'rgba(74, 206, 231, 1)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'12pt',
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
				'font-size'=>'12pt',
				'background-color'=>'rgba(74, 206, 231, 1)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'12pt',
			]
		],
		'pageSummaryOptions' => [
			'style'=>[
					'font-family'=>'tahoma',
					'font-size'=>'12pt',
					'text-align'=>'right',
					'border-left'=>'0px',
			]
		],
	],
];

$_gvSoDetailPdf= GridView::widget([
	'id'=>'gv-so-detail-pdf',
	'dataProvider'=> $aryProviderSoDetail,
	'showPageSummary' => true,	
	'columns' => $soDetailColumn,
	'pjax'=>true,
	'hover'=>true, //cursor select
	'responsive'=>true,
	'responsiveWrap'=>true,
	'bordered'=>true,
	'striped'=>'4px',
	'autoXlFormat'=>true,
	'export' => false,
	'toolbar'=> [
		''
		
	 ],
	'panel'=>[
		'type'=>GridView::TYPE_SUCCESS,
		'heading'=>false,//tombolCreate($cust_kd,$kode_so,$user_id,$ary[0]['CUST_NM'],$tgl),//$this->render('indexTimelineStatus'),//false //'<div> NO.SO :'.date("d-M-Y")
		'before'=>' SO NO : '. $ary[0]['KODE_REF'],//$kode_SO,
		'after'=>false,
		'footer'=>false,//'<div>asd dsadas ad asd asdas d asd as d ad as d asd wrfddsfds sdf sdfsdf sdf sdfsdfsdfds fsd fsd fds fdsfdsfdsf dsfdsf sdf sd</div>'		
	]
]);
?>
<div class="container-fluid" style="font-family: tahoma ;font-size: 8pt;padding-top:20px">
	<!-- Header !-->	
	<div class="row">
		<div class="col-md-12">
		
			<!-- HEADER PRINCIPEL !-->		
			<div style="width:210px;float:left">
				<dl>
					<dt style="font-family: verdana, arial, sans-serif ;font-size: 11pt;">
						PT EFENBI SUKSES MAKMUR
					</dt>
					<dd></dd>
					<dt>
						Ruko Demansion Blok C12
					</dt>
					<dd></dd>
					<dt >
						Jalan jalur Sutera Timur
					</dt>
					<dd></dd>
					<dt >
						Alam sutera - Tangerang
					</dt>
					<dd></dd>
					<dt>					
						Telp : 021-30448598-99 /fax 021-30448597
					</dt>
				</dl>
			</div>			
			<div style="width:210px;font-family: verdana, arial, sans-serif ;font-size: 11pt;float:left">
				<?php echo '.';?>
			</div>
			
			<!-- HEADER CUSTOMER !-->		
			<div style="width:210px;float:left">
				<dl>
					<?php
						$infoCustTgl=Yii::$app->formatter->asDate($soHeaderData->TGL,'php:Y-m-d');
						$infoCustId=$soHeaderData->CUST_ID;
						$infoCustNm=$soHeaderData->cust->CUST_NM;
						$infoCustAlamat=$soHeaderData->cust->ALAMAT;
						$infoCustTlp=$soHeaderData->cust->TLP1;
						$infoCustTglKirim=$soHeaderData->TGL_KIRIM;
					?>
					<dt style="width:100px; float:left;">Tanggal </dt>
					<dd>: <?=$infoCustTgl?></dd>
					<dt style="width:100px; float:left;">Kode Cust</dt>
					<dd>: <?=$infoCustId?></dd>
					<dt style="width:100px; float:left;">Customer </dt>
					<dd>: <?=$infoCustNm?></dd>
					<dt style="width:100px; float:left;">Alamat  </dt>
					<dd>: <?=$infoCustAlamat?></dd>
					<dt style="width:100px; float:left;">Telp   </dt>
					<dd>: <?=$infoCustTlp?></dd>
					<dt style="width:100px; float:left;">Tgl Kirim  </dt>
					<dd>: <?=$infoCustTglKirim?></dd>
				</dl>
			</div>
		</div>
	
		<!-- TITLE !-->	
		<div class="col-md-12 text-center"  style="float:left;font-family: verdana, arial, sans-serif ;font-size: 14pt;">
			<b>SALES ORDER</b>	
		</div>
		
		<!-- Title GRID PO Detail !-->
		<div class="col-md-12">
			<?=$_gvSoDetailPdf?>
		</div>
		
		<!-- Title BOTTEM Descript !-->
		<div class="row">
			<div class="col-md-12" style="font-family: tahoma ;font-size: 9pt;float:left;">
				<div class="col-md-4" style="width:250px;float:left;">
					<dl>
						<?php
							$shipNm= $soHeaderData->cust->CUST_NM !='' ? $soHeaderData->cust->CUST_NM: 'Shipping Not Set';
							$shipAddress= $soHeaderData->cust->ALAMAT_KIRIM!='' ? $soHeaderData->cust->ALAMAT_KIRIM :'Address Not Set';
							$shipPhone= $soHeaderData->cust->TLP1!='' ? $soHeaderData->cust->TLP1 : 'Phone Not Set';
							$shipFax= $soHeaderData->cust->FAX!='' ? $soHeaderData->cust->FAX : 'Fax Not Set';
							$shipPic= $soHeaderData->cust->PIC!='' ? $soHeaderData->cust->PIC : 'PIC not Set';
						?>
						<dt><h6><u><b>Shipping Address :</b></u></h6></dt>
						<dt style="width:300px;font-family: verdana, arial, sans-serif ;font-size: 11pt;">
							<?=$shipNm; ?>
						</dt>
						<dt ><?=$shipAddress;?></dt>					
						<dt style="width:80px; float:left;">Tlp</dt>
						<dd>:	<?=$shipPhone;?></dd>
						<dt style="width:80px; float:left;">FAX</dt>
						<dd>:	<?=$shipFax; ?></dd>
						<dt style="width:80px; float:left;">CP</dt>
						<dd>:	<?=$shipPic; ?></dd>
					</dl>		
				</div>
				<div class="col-md-4" style="width:280px;float:left;">
					<dl>
						<?php
							$destinationNm= $soHeaderData->dest->NM_DISTRIBUTOR !='' ?  $soHeaderData->dest->NM_DISTRIBUTOR: 'none';
							$destinationAddress= $soHeaderData->dest->ALAMAT!='' ? $soHeaderData->dest->ALAMAT :'none';
							$destinationPhone= $soHeaderData->dest->TLP1!='' ? $soHeaderData->dest->TLP1 : 'Phone Not Set';
							$destinationFax= $soHeaderData->dest->FAX!='' ? $soHeaderData->dest->FAX : 'Fax Not Set';
							$destinationPic= $soHeaderData->dest->PIC!='' ? $soHeaderData->dest->PIC : 'PIC not Set';
						?>
						<dt><h6><u><b>Destination :</b></u></h6></dt>
						<dt style="width:300px;font-family: verdana, arial, sans-serif ;font-size: 11pt;"><?=$destinationNm; ?></dt>
						<dt><?=$destinationAddress;?></dt>						
						<dt style="width:80px; float:left;">Tlp</dt>
						<dd>:	<?=$destinationPhone;?></dd>
						<dt style="width:80px; float:left;">FAX</dt>
						<dd>:	<?=$destinationFax; ?></dd>
						<dt style="width:80px; float:left;">CP</dt>
						<dd>:	<?=$destinationPic; ?></dd>
					</dl>
				</div>
			</div>
		</div>
	
		<!-- PO Term Of Payment !-->
		<div class="col-md-12">
			<div style="font-family: tahoma ;font-size: 9pt;">
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
		<div class="col-md-12">
			<div  style="margin-top:10px;font-family: tahoma ;font-size: 9pt;">
				<dt><u><b>General Notes :</b></u></dt>
				<!-- <hr style="height:1px;margin-top: 1px; margin-bottom: 1px;font-family: tahoma ;font-size:8pt;">!-->
				<div>
					<div style="margin-left:5px">
						<dd><?=$soHeaderData->NOTE;?></dd>
					</div>
				</div>
				<hr style="height:1px;margin-top: 1px;">
			</div>
		</div>	
		
		<!-- Signature PO !-->
		<div class="col-md-12">
			<table id="tblRo" class="table table-bordered" style="width:360px;font-family: tahoma ;font-size: 8pt;">
				<!-- Tanggal!-->
				<tr>
					<!-- Tanggal Pembuat RO!-->
					<th  class="col-md-1" style="text-align: center; height:20px">
						<div style="text-align:center;">
							<?php
								$tgl1=$soHeaderData->sign1Tgl!='' ? Yii::$app->ambilKonvesi->convert($soHeaderData->sign1Tgl,'date') :'';
								$signTgl1='<b>Tanggerang</b>, '.$tgl1;
							?>
							<?=$signTgl1?>
						</div>

					</th>
					<!-- Tanggal Pembuat RO!-->
					<th class="col-md-1" style="text-align: center; height:20px">
						<div style="text-align:center;">
							<?php
								$tgl2=$soHeaderData->sign2Tgl!='' ? Yii::$app->ambilKonvesi->convert($soHeaderData->sign2Tgl,'date') :'';
								$signTgl2='<b>Tanggerang</b>, '.$tgl2;
							?>
							<?=$signTgl2?>
						</div>

					</th>
					<!-- Tanggal PO Approved!-->
					<th class="col-md-1" style="text-align: center; height:20px">
						<div style="text-align:center;">
							<?php
								$tgl3=$soHeaderData->sign3Tgl!='' ? Yii::$app->ambilKonvesi->convert($soHeaderData->sign3Tgl,'date') :'';
								$signTgl3='<b>Tanggerang</b>, '.$tgl3;
							?>
							<?=$signTgl3?>
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
							$sign1 = $soHeaderData->sign1!=''?'<img style="width:80; height:40px" src='.$soHeaderData->sign1.'></img>' :'';
						?>
						<?=$sign1?>
					</th>
					<th class="col-md-1" style="text-align: center; vertical-align:middle">
						<?php
							$sign2 = $soHeaderData->sign2!=''?'<img style="width:80; height:40px" src='.$soHeaderData->sign2.'></img>' :'';
						?>
						<?=$sign2?>
					</th>
					<th  class="col-md-1" style="text-align: center; vertical-align:middle">
						<?php
							$sign3 = $soHeaderData->sign3!=''?'<img style="width:80; height:40px" src='.$soHeaderData->sign3.'></img>' :'';
						?>
						<?=$sign3?>
					</th>
				</tr>
				<!--Nama !-->
				<tr>
					<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
						<div>
							<?php
								$sign1NM = $soHeaderData->sign1Nm!=''?$soHeaderData->sign1Nm:'';
							?>
							<?=$sign1NM?>
						</div>
					</th>
					<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
						<div>
							<?php
								$sign2NM = $soHeaderData->sign2Nm!=''?$soHeaderData->sign2Nm:'';
							?>
							<?=$sign2NM?>
						</div>
					</th>
					<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
						<div>
							<?php
								$sign2NM = $soHeaderData->sign2Nm!=''?$soHeaderData->sign2Nm:'';
							?>
							<?=$sign2NM?>
						</div>
					</th>
				</tr>
				<!-- Department|Jbatan !-->
				 <tr>
					<th style="text-align: center; vertical-align:middle;height:20">
						<div>
							<b><?php  echo 'SALES MD'; ?></b>
						</div>
					</th>
					<th style="text-align: center; vertical-align:middle;height:20">
						<div>
							<b><?php  echo 'ADMIN'; ?></b>
						</div>
					</th>
					<th style="text-align: center; vertical-align:middle;height:20">
						<div>
							<b><?php  echo 'CAM'; ?></b>
						</div>
					</th>
				</tr>
			</table>
		</div>
	</div>
</div>
