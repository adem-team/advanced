<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\DetailView;
use lukisongroup\master\models\Unitbarang;
$this->title = $roHeader->KD_RO;
$this->params['breadcrumbs'][] = ['label' => 'Request Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container" style="font-family: verdana, arial, sans-serif ;font-size: 7pt;">
	<div>
		<div style="width:200px; float:left;">
			<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>	
		</div>
		<div style="padding-top:40px;">
			<h5 class="text-left"><b>FORM PERMINTAAN BARANG & JASA</b></h5>				
		</div>
		<hr>
	</div>
	
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
	<div>
		<table id="tblRo" class="table table-bordered" style="font-family: verdana, arial, sans-serif ;font-size: 7pt;">
			 <tr>
				<th rowspan="2" style="background-color:rgba(0, 95, 218, 0.3);text-align: center; vertical-align:middle;height:20">No.</th>								
				<th rowspan="2" style="background-color:rgba(0, 95, 218, 0.3);text-align: center; vertical-align:middle;height:20">Nama Barang</th>
				<th colspan="3" style="background-color:rgba(0, 95, 218, 0.3);text-align: center; vertical-align:middle;height:20">Quantity</th>
				<th rowspan="2" style="background-color:rgba(0, 95, 218, 0.3);text-align: center; vertical-align:middle;height:20">Catatan</th>
			</tr>
			<tr>
				<th style="background-color:rgba(0, 95, 218, 0.3);text-align: center;height:20">Request</th>
				<th style="background-color:rgba(0, 95, 218, 0.3);text-align: center;height:20">Submit</th>				
				<th style="background-color:rgba(0, 95, 218, 0.3);text-align: center;height:20">Unit</th>				
			</tr>    
			
			<?php $no=0; foreach($detro as $ro){ $sts = $ro->STATUS; if($sts == 0 OR $sts == 3 OR $sts == 4 ){ } else { $no=$no+1; ?>
				<tr>
					<td class="col-md-1" style="text-align: center;vertical-align:middle;height:20"><?php echo $no; ?></td>
				   <!-- <td class="col-md-1"><?php //echo $ro->KD_BARANG; ?></td> !-->
					<td class="col-md-2" style="vertical-align:middle;height:20"><?php echo $ro->NM_BARANG; ?></td>               
					<td class="col-md-1" style="text-align: center;vertical-align:middle;height:20"><?php echo $ro->RQTY; ?></td>
					<td class="col-md-1" style="text-align: center;vertical-align:middle;height:20"><?php echo $ro->SQTY; ?></td>
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
				</tr>
			<?php } } ?>
		</table>
	</div>

	
	<div>
		<?php 
			$tgl1 = explode(' ',$roHeader->CREATED_AT);
			$awl1 = explode('-',$tgl1[0]); 
			$blnAwl1 = date("F", mktime(0, 0, 0, $awl1[1], 1));
			
			$tgl2 = explode(' ',$roHeader->SIG2_TGL);
			$awl2 = explode('-',$tgl2[0]); 
			$blnAwl2 = date("F", mktime(0, 0, 0, $awl2[1], 1));		
			
		?>
		<table id="tblRo" class="table table-bordered" style="width:360px;font-family: verdana, arial, sans-serif ;font-size: 7pt;">
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
				<th style="text-align: center; vertical-align:middle;width:180; height:60px">
					<img src="<?php echo $roHeader->SIG1_SVGBASE64;?> height='120' width='150'"></img>
				</th>								
				<th style="text-align: center; vertical-align:middle;width:180">
					<img src="<?php echo $roHeader->SIG2_SVGBASE64;?> height='120' width='150'"></img>
				</th>
			</tr>
			<!--Nama !-->
			 <tr>
				<th style="text-align: center; vertical-align:middle;height:20">
					<div>		
						<b><?php  echo $roHeader->EMP_NM; ?></b>
					</div>
				</th>								
				<th style="text-align: center; vertical-align:middle;height:20">
					<div>		
						<b><?php  echo $roHeader->SIG2_NM; ?></b>
					</div>
				</th>
			</tr>
		</table>
	</div>
	</th>
	<hr>
	General Notes :
</div>

		

	



