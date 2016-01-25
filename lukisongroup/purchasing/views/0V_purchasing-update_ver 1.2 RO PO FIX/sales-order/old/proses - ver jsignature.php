<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use yii\helpers\Json;
use lukisongroup\assets\AppAssetJqueryJSignature;
AppAssetJqueryJSignature::register($this); 
/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\ro\Requestorder */

$this->sideCorp = 'ESM Request Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_esm';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Data Master');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

	/* $this->registerJs("
			var  jsonData= $.ajax({
			  url: 'http://api.lukisongroup.com/login/signatures?id=2',
			  type: 'GET',
			  dataType:'json',			
			  async: false
			  }).responseText;		  
			  var myData = jsonData;
			  sig = myData;
			  //alert(sig);
	",$this::POS_BEGIN) ;  */

?>

<?php
	 /* $this->registerJs('
		$(document).ready(function($) {	 
				
				$("#redrawSignature").signature();				
				$("#redrawSignature").signature({disabled: true});				
				$("#redrawSignature").signature({
					change: function(event, ui) { 
						$("#redrawSignature").signature("draw", sig);										
					}
				});
		});	
		$(document).ready(function($) {	 
				$("#SVGSignature").signature();
				$("#SVGSignature").signature({
					change: function(event, ui) { 
						$("#SVGSignature").signature("draw", {"lines":[[[77,171.83],[77,170.83],[77,168.83],[77,166.83],[77,164.83],[77,161.83],[77,157.83],[80,151.83],[84,144.83],[88,136.83],[92,128.83],[99,118.83],[107,108.83],[113,101.83],[121,93.83],[129,85.83],[139,79.83],[152,73.83],[161,68.83],[169,65.83],[174,63.83],[179,62.83],[182,61.83],[185,61.83],[187,61.83],[188,61.83],[189,62.83],[190,63.83],[191,65.83],[191,68.83],[191,71.83],[192,74.83],[193,77.83],[193,79.83],[193,82.83],[193,83.83],[193,84.83],[193,86.83],[193,87.83],[192,89.83],[190,90.83],[188,90.83],[184,91.83],[180,91.83],[171,91.83],[163,91.83],[149,91.83],[137,91.83],[121,91.83],[108,91.83],[96,91.83],[86,91.83],[76,91.83],[68,91.83],[61,91.83],[56,91.83],[49,91.83],[45,91.83],[41,91.83],[36,91.83],[31,91.83],[27,91.83],[26,91.83],[25,90.83],[24,90.83]],[[72,103.83],[68,103.83],[65,103.83],[63,103.83],[61,103.83],[57,104.83],[55,105.83],[53,106.83],[52,107.83],[50,108.83],[49,109.83],[49,110.83],[49,112.83],[49,114.83],[49,116.83],[50,119.83],[54,123.83],[58,127.83],[62,130.83],[69,134.83],[80,138.83],[91,141.83],[104,143.83],[119,144.83],[132,144.83],[146,144.83],[161,143.83],[182,140.83],[194,136.83],[208,131.83],[218,128.83],[223,124.83],[224,124.83],[225,122.83],[225,121.83],[224,119.83],[222,117.83],[220,116.83],[219,115.83],[213,114.83],[207,113.83],[196,113.83],[183,113.83],[172,113.83],[159,113.83],[148,114.83],[139,116.83],[129,118.83],[123,121.83],[121,122.83],[119,124.83],[119,125.83],[119,127.83],[119,128.83],[119,131.83],[121,134.83],[128,137.83],[135,139.83],[147,141.83],[159,142.83],[174,143.83],[186,143.83],[198,143.83],[205,142.83],[208,141.83],[210,140.83],[209,139.83],[207,139.83],[201,139.83],[193,139.83],[186,139.83],[182,141.83],[181,142.83],[181,143.83],[181,144.83],[182,146.83],[184,147.83],[190,149.83],[199,149.83],[214,149.83],[227,149.83],[242,149.83],[252,149.83],[259,149.83],[260,149.83],[262,149.83],[264,149.83],[267,149.83],[269,149.83],[270,149.83],[271,148.83]]]});						
					}
				});
			
				
				 $("#SVGSignature").signature();
				$("#redrawSignature").signature();
				$("#redrawSignature").signature({disabled: true});				
				$("#SVGSignature").signature({
					change: function(event, ui) { 
						$("#redrawSignature").signature("draw", sig);
						var coba=$("#redrawSignature").signature("toSVG");	
						 document.getElementById("ptrSvg").innerHTML = coba;							
					}
				}); 
				
		});					   
	',$this::POS_BEGIN); */ 
	?>
	<?php
		
	?>
	<?php
		 $this->registerJs('
				$(document).ready(function($) {
					$("#signature1").jSignature();
					
					//$("#signature1").bind("change", function(e){ 
						//alert("teset"); 
						//var data="image/jsignature;base30,1B4_1EZ7_2P00376553_1I55300Z102_5xZ4735_1yZ1020"
						//var datapair =("image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMjYiIGhlaWdodD0iNDUiPjxwYXRoIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2U9InJnYigwLCAwLCAxMzkpIiBmaWxsPSJub25lIiBkPSJNIDEgNDQgYyAwLjA5IC0wLjE2IDMuNiAtNS44OCA1IC05IGMgMS42IC0zLjU1IDIuNDMgLTcuMzggNCAtMTEgYyAxLjggLTQuMTUgMy43NiAtOC4wOCA2IC0xMiBjIDEuOCAtMy4xNiAzLjkgLTYuNDQgNiAtOSBsIDMgLTIiLz48L3N2Zz4=")
						//var datapair = $("#signature1").jSignature("getData","svgbase64");
						//try{
							var i = new Image();							
							i.src = "data:" + "image/svg+xml;base64" + "," + "PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMjYiIGhlaWdodD0iNDUiPjxwYXRoIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2U9InJnYigwLCAwLCAxMzkpIiBmaWxsPSJub25lIiBkPSJNIDEgNDQgYyAwLjA5IC0wLjE2IDMuNiAtNS44OCA1IC05IGMgMS42IC0zLjU1IDIuNDMgLTcuMzggNCAtMTEgYyAxLjggLTQuMTUgMy43NiAtOC4wOCA2IC0xMiBjIDEuOCAtMy4xNiAzLjkgLTYuNDQgNiAtOSBsIDMgLTIiLz48L3N2Zz4="; 
							$(i).appendTo($("#signature2"));
							
							var j = new Image();
							j.src = "data:" + "image/svg+xml;base64" + "," + "PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iNjgiIGhlaWdodD0iMzUiPjxwYXRoIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2U9InJnYigwLCAwLCAxMzkpIiBmaWxsPSJub25lIiBkPSJNIDEgMTggYyAwLjAzIDAuMDcgMS4xMyAzLjI3IDIgNCBjIDAuOCAwLjY3IDIuODIgMC40MSA0IDEgYyA1LjkxIDIuOTUgMTIuMTcgNy41MyAxOCAxMCBjIDIuMjggMC45NyA1LjMzIDEgOCAxIGMgNi42MiAwIDEzLjkgMC4wNSAyMCAtMSBjIDMgLTAuNTIgNi42IC0yLjI5IDkgLTQgYyAxLjkgLTEuMzYgNC41NSAtMy45MiA1IC02IGMgMC45OCAtNC41MyAwLjQ4IC0xMi4xOSAwIC0xNyBjIC0wLjEgLTEuMDIgLTEuMjIgLTIuMjIgLTIgLTMgbCAtMyAtMiIvPjwvc3ZnPg==",
							$(j).appendTo($("#signature3"));
							
							//$("#signature2").jSignature("setData", "data:" + datapair.join(","));
						//} catch (ex) {

						//}
					//})
					
					//datapair = $sigdiv.jSignature("getData","base30");
					//$sigdiv.jSignature("setData", "data:" + datapair.join(",")) 
					
					//var $sigdiv = $("#signature1");
					//datapair = $("#signature1").jSignature("getData","base30");
					// $sigdiv.jSignature("setData","data:" + datapair.join(","));
					
					//var datapair = $sigdiv.jSignature("getData", "svgbase64") 
					//	var i = new Image()
					//	i.src = "data:" + datapair[0] + "," + datapair[1] 
					//	$(i).appendTo($("#someelement")
					
					//$("#signature2").jSignature("setData", "data:" + "image/jsignature;base30","1B4_1EZ7_2P00376553_1I55300Z102_5xZ4735_1yZ1020"")
					
					//BUTTON CLICK CHECK DATA SAVE
					$("#btnSave").click(function(){
						var sigData = $("#signature1").jSignature("getData","svgbase64");
						$("#hiddenSigData").val(sigData);
						alert(sigData);
					});
				});
			
		 ',$this::POS_BEGIN);
	?>

<div class="requestorder-view" style="margin:0px 20px;">
    <center>
		<h2 style="margin-bottom:0px;"><b>Form Permintaan Barang</b></h2>
		<h3 style="margin-top:0px;">Nomor : <?php echo $reqro->KD_RO; ?></h3>
	</center>

    <form action="/purchasing/request-order/simpanproses" method="post">
    <table class="table table-striped" style="background-color:#fff; border:1px solid #7D7DB2; ">
        <thead style="background-color:#A1A1E6; ">
            <th>No.</th>            
            <th>Kode Barang</th>
			<th>Nama Barang</th>
            <th>Quantity</th>
            <th>Satuan Barang</th>
            <th>Catatan</th>
            <th></th>
        </thead>


        <tbody>
		<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
		<input type="hidden" name="kd" value="<?php echo $reqro->KD_RO; ?>" />
        <?php 
			$sts = 1; $no=0; 
			foreach($detro as $ro){ 
			$no=$no+1; 
			
			if($ro->STATUS == 3) {} else { if($ro->STATUS == 0 ){ $sts=0; }
		?>
            <tr>
                <td><?php echo $no; ?></td>
				<td><?php echo $ro->KD_BARANG; ?></td>
                <td><?php echo $ro->NM_BARANG; ?></td>                
                <td><?php echo $ro->RQTY; ?></td>
                <td><?php echo $ro->UNIT; ?></td>
                <td><?php echo $ro->NOTE; ?></td>
                <td><?php if($ro->STATUS == 0){ ?><input type="checkbox" value="<?php echo $ro->ID; ?>" name="ck[]" /><?php } else { echo '<i class="fa fa-check" style="color:blue;"></i>'; } ?></td>
            </tr>
			<?php } } ?>
        </tbody>
    </table>
	
	<!-- div style="text-align:left; float:left;">
	<?php 
		echo Html::a('<i class="fa fa-print fa-fw"></i> Cetak', ['cetakpdf','kd'=>$reqro->KD_RO], ['target' => '_blank', 'class' => 'btn btn-warning']);
	?>
	</div -->
	
	<div style="text-align:right;padding-left:5px; " class="pull-right" >
		<?php if($sts == 0){ ?><button type="submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;&nbsp;Terima RO</button><?php } ?>
	</div>
	<div style="text-align:right; ">
		<a href="/purchasing/request-order" class="btn btn-info" role="button">Kembali</a>
	</div>
	<div style="clear:both;"></div>

	<?php 
		$tgl = explode(' ',$reqro->CREATED_AT);
		$awl = explode('-',$tgl[0]); 
		$blnAwl = date("F", mktime(0, 0, 0, $awl[1], 1));
	?>
	 <!-- YANG MENGAJUKAN !-->
	<div class="row">
	  <div class="col-md-4">
		  <b>Tanggerang, <?php echo $awl[2].' - '.$blnAwl.' - '.$awl[0];  ?></b><br/>
			yang mengajukan,
		  <br/>
		  
	  
		<div  id="signature1"></div> 
		<!--
			<div  id="SVGSignature"></div>
			<div  id="ptrSvg"></div> 
		!-->
	  
		<?php echo $employ->EMP_NM.' '.$employ->EMP_NM_BLK; ?>
	  </div>
	  
	  <!-- YANG MEYETUJUI !-->
	  <div class="col-md-4">
		  <b>Tanggerang, <?php echo $awl[2].' - '.$blnAwl.' - '.$awl[0];  ?></b><br/>
			yang Menyetujui,
		  <br/>		  
	 
	  <img  id="signature2"></img> 
	  <!--
	  <div  id="SVGSignature"></div>
	  <div  id="ptrSvg"></div> !-->
	   
		<?php echo $employ->EMP_NM.' '.$employ->EMP_NM_BLK; ?>
		<button id="btnSave" type="button">test get </button>
	  </div>
	  <div class="col-md-4">
	  <img  id="signature3"></img> 
	  <textarea id="hiddenSigData"></textarea>
	  </div>
	</div>



</div>

