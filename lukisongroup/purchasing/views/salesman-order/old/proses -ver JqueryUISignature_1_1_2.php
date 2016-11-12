<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use yii\helpers\Json;
use lukisongroup\assets\AppAssetJquerySignature_1_1_2;
AppAssetJquerySignature_1_1_2::register($this); 
/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\ro\Requestorder */

$this->sideCorp = 'ESM Request Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_esm';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Data Master');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

	$this->registerJs("
			var  jsonData= $.ajax({
			  url: 'http://api.lukisongroup.com/login/signatures?id=2',
			  type: 'GET',
			  dataType:'json',			
			  async: false
			  }).responseText;		  
			  var myData = jsonData;
			  sig = myData;
			  //alert(sig);
	",$this::POS_BEGIN) ; 

?>

<?php
	 $this->registerJs('
		$(document).ready(function($) {	 
				$("#redrawSignature").signature();
				$("#redrawSignature").signature({disabled: true});				
				$("#redrawSignature").signature({
					change: function(event, ui) { 
						$("#redrawSignature").signature("draw", sig);											
					}
				});
				
				/* $("#SVGSignature").signature();
				$("#redrawSignature").signature();
				$("#redrawSignature").signature({disabled: true});				
				$("#SVGSignature").signature({
					change: function(event, ui) { 
						$("#redrawSignature").signature("draw", sig);
						var coba=$("#redrawSignature").signature("toSVG");	
						 document.getElementById("ptrSvg").innerHTML = coba;							
					}
				}); */
				
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
	
	<div style="text-align:right;">
		<?php if($sts == 0){ ?><button type="submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;&nbsp;Terima RO</button><?php } ?>
	</div>
	<div style="clear:both;"></div>

	<?php 
		$tgl = explode(' ',$reqro->CREATED_AT);
		$awl = explode('-',$tgl[0]); 
		$blnAwl = date("F", mktime(0, 0, 0, $awl[1], 1));
	?>
	<div class="row">
	  <div class="col-md-8"></div>
	  <div class="col-md-4">
		  <b>Tanggerang, <?php echo $awl[2].' - '.$blnAwl.' - '.$awl[0];  ?></b><br/>
			yang mengajukan,
		  <br/>
		  
	  
	  <div  id="redrawSignature"></div> 
	 <!--
	  <div  id="SVGSignature"></div>
	  <div  id="ptrSvg"></div> !-->
	  
		<?php echo $employ->EMP_NM.' '.$employ->EMP_NM_BLK; ?>
	  </div>
	</div>



</div>

