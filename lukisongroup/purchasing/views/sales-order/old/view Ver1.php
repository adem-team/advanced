<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\assets\AppAssetJqueryJSignature;
AppAssetJqueryJSignature::register($this); 

$this->sideCorp = 'ESM Request Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_esm';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Data Master');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

 $this->registerJs('
		$(document).ready(function($) {
			/* Data Signature1 from DB */
			var ro_datadb1 =\''. $reqro->SIG1_SVGBASE64 . '\'
				var i = new Image();							
					i.src = ro_datadb1
					$(i).appendTo($("#ro-view-sig1"));
			/* Data Signature2 from DB */
			var ro_datadb2 =\''. $reqro->SIG2_SVGBASE64 . '\'
				var j = new Image();							
					j.src = ro_datadb2
					$(j).appendTo($("#ro-view-sig2"));				
		});		
 ',$this::POS_BEGIN);
?>


<div class="container" style="font-family: verdana, arial, sans-serif ;font-size: 7pt;">
	<!-- HEADER !-->
	<div class="col-md-12">
		<div class="col-md-1" style="float:left;">
			<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>	
		</div>
		<div class="col-md-9" style="padding-top:40px;">
			<h3 class="text-center"><b>Form Permintaan Barang & Jasa</b></h3>				
		</div>
		<div class="col-md-11">
			<hr>
		</div>
	</div>
	<!-- Title Descript !-->
	<div class="col-md-11">
		<dl>
			  <dt style="width:100px; float:left;">Date</dt>
			  <dd>: <?php echo date('d-M-Y'); ?></dd>
			  <dt style="width:100px; float:left;">Nomor</dt>
			  <dd>: <?php echo $reqro->KD_RO; ?></dd>     	  
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
	<!-- Table List RO Detail !-->
	<div class="col-md-11">
		<table id="tblRo" class="table table-bordered" style="font-family: verdana, arial, sans-serif ;font-size: 7pt;">
			 <tr>
				<th rowspan="2" style="background-color:rgba(0, 95, 218, 0.3);text-align: center; vertical-align:middle;height:20">No.</th>								
				<th rowspan="2" style="background-color:rgba(0, 95, 218, 0.3);text-align: center; vertical-align:middle;height:20">Nama Barang</th>
				<th colspan="3" style="background-color:rgba(0, 95, 218, 0.3);text-align: center; vertical-align:middle;height:20">Quantity</th>
				<th rowspan="2" style="background-color:rgba(0, 95, 218, 0.3);text-align: center; vertical-align:middle;height:20">Catatan</th>
				<th rowspan="2" style="background-color:rgba(0, 95, 218, 0.3);text-align: center; vertical-align:middle;height:20">Status</th>
			</tr>
			<tr>
				<th style="background-color:rgba(0, 95, 218, 0.3);text-align: center;height:20">Request</th>
				<th style="background-color:rgba(0, 95, 218, 0.3);text-align: center;height:20">Submit</th>				
				<th style="background-color:rgba(0, 95, 218, 0.3);text-align: center;height:20">Unit</th>				
			</tr>    
			
			<?php $no=0; foreach($detro as $ro){$no=$no+1; ?>
				<tr>
					<td class="col-md-1"><?php echo $no; ?></td>
				   <!-- <td class="col-md-1"><?php //echo $ro->KD_BARANG; ?></td> !-->
					<td class="col-md-2"  style="vertical-align:middle;height:20"><?php echo $ro->NM_BARANG; ?></td>               
					<td class="col-md-1"  style="text-align: center;vertical-align:middle;height:20"><?php echo $ro->RQTY; ?></td>
					<td class="col-md-1"  style="text-align: center;vertical-align:middle;height:20"><?php echo $ro->SQTY; ?></td>
					<?php
						$model=Unitbarang::find()->where('KD_UNIT="'.$ro->UNIT. '"')->one();
						if (count($model)!=0){
							$UnitNm=$model->NM_UNIT;
						}else{
							$UnitNm='Not Set';
						}
					?>
					<td class="col-md-1" style="vertical-align:middle;height:20"><?php echo $UnitNm;//$ro->UNIT; ?></td>
					<td class="col-md-4" style="vertical-align:middle;height:20"><?php echo $ro->NOTE; ?></td>
					<td style="text-align:center;width:5">
						<?php 
							if($ro->STATUS == 1){ 
								echo '<i class="fa fa-check fa-fw" style="color:blue;"></i>';  
							} else { 
								echo '<i class="fa fa-question fa-fw" style="color:red;"></i>'; 
							}; 
						?>
					</td>
				</tr>
			<?php }  ?>
		</table>
	</div>
	<!-- Signature !-->
	<div  class="col-md-11">
		<?php 
			$tgl1 = explode(' ',$reqro->CREATED_AT);
			$awl1 = explode('-',$tgl1[0]); 
			$blnAwl1 = date("F", mktime(0, 0, 0, $awl1[1], 1));
			
			$tgl2 = explode(' ',$reqro->SIG2_TGL);
			$awl2 = explode('-',$tgl2[0]); 
			$blnAwl2 = date("F", mktime(0, 0, 0, $awl2[1], 1));		
			
		?>
		<div style="float:left;">
			<table id="tblRo" class="table table-bordered" style="width:550px;font-family: verdana, arial, sans-serif ;font-size: 7pt;">
				<!-- Tanggal!-->
				 <tr>
					<!-- Tanggal Pembuat RO!-->
					<th style="text-align: center; height:20px">
						<div style="margin-left:50px">
							<b>Tanggerang</b>, <?php echo ' '.$awl1[2].'-'.$blnAwl1.'-'.$awl1[0];  ?>
						</div> 
					
					</th>		
					<!-- Tanggal PO Approved!-->				
					<th style="text-align: center; height:20px">
						<div style="margin-left:50px">
							<b>Tanggerang</b>, <?php echo ' '.$awl2[2].'-'.$blnAwl2.'-'.$awl2[0];;  ?>
						</div> 				
					</th>	
				</tr>
				<!--Keterangan !-->
				 <tr>
					<th style="background-color:rgba(0, 95, 218, 0.3);text-align: center; height:20px">
						  Mengajukan,
					</th>								
					<th style="background-color:rgba(0, 95, 218, 0.3);text-align: center; height:20px">
						  Menyetujui,
					</th>	
				</tr>
				<!-- Signature !-->
				 <tr>
					<th style="text-align: center; vertical-align:middle;width:180; height:80px">
						<div id="ro-view-sig1"><div>
					</th>								
					<th style="text-align: center; vertical-align:middle;width:180; height:80px">
						<div id="ro-view-sig2">
					</th>
				</tr>
				<!--Nama !-->
				 <tr>
					<th style="text-align: center; vertical-align:middle;height:20">
						<div>		
							<b><?php  echo $reqro->EMP_NM; ?></b>
						</div>
					</th>								
					<th style="text-align: center; vertical-align:middle;height:20">
						<div>		
							<b><?php  echo $reqro->SIG2_NM; ?></b>
						</div>
					</th>
				</tr>
			</table>
		</div>
		<!-- Cetak Pdf!-->
		<div style="text-align:right">
			<a href="/purchasing/request-order" class="btn btn-info" role="button">Kembali</a>
			<?php 
				echo Html::a('<i class="fa fa-print fa-fw"></i> Cetak', ['cetakpdf','kd'=>$reqro->KD_RO], ['target' => '_blank', 'class' => 'btn btn-success']);
			?>				
		</div>
	</div>	
</div>
