<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;

//use terlebih dahulu
use yii\bootstrap\Modal;

use lukisongroup\models\esm\Barang;
use lukisongroup\models\esm\ro\Requestorder;
use lukisongroup\models\esm\ro\Rodetail;
use lukisongroup\models\esm\ro\RodetailSearch;

use lukisongroup\models\master\Barangumum;
use lukisongroup\models\master\Suplier;

use lukisongroup\models\master\Nmperusahaan;

use lukisongroup\models\esm\po\Podetail;

use lukisongroup\models\hrd\Employe;


$idEmp = Yii::$app->user->identity->EMP_ID;
$emp = Employe::find()->where(['EMP_ID'=>$idEmp])->one();
$kr = $emp->DEP_SUB_ID;
?>

<!-- Stack the columns on mobile by making one full-width and the other half-width -->
<div class="row">

<?php if($quer->STATUS != 102){  if( $kr == 'HR-02'){ ?>
	<div class="col-xs-12 col-md-3">
    <?php Pjax::begin(['id'=>'pjax-users']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'KD_RO',
			[
	            'format'=>'raw',
	            'value' => function ($data){
	                $count = Rodetail::find()
	                    ->where([
	                        'KD_RO'=>$data->KD_RO,
	                    ])
	                    ->count();
	 
	                if(!empty($count)){
	                    return  Html::a('<button type="button" class="btn btn-primary btn-xs">View</button>',['detail','kd_ro'=>$data->KD_RO,'kdpo'=>$_GET['kdpo']],[
	                                                    'data-toggle'=>"modal",
	                                                    'data-target'=>"#myModal",
	                                                    'data-title'=> $data->KD_RO,
	                                                    ]); // ubah ini
	                } else {
	                    return '<button type="button" class="btn btn-danger btn-xs">No Data</button>';
	                }
	            }
	        ],
        ],
   		]); 
    ?>
    <?php Pjax::end(); ?>
	
	<?php
		$this->registerJs("
		    $('#myModal').on('show.bs.modal', function (event) {
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
		        })
		");

		Modal::begin([
		    'id' => 'myModal',
		    'header' => '<h4 class="modal-title">...</h4>',
		]);
		 
		echo '...';
		 
		Modal::end();
	?>
	
	</div>

<?php } } ?>
	<!-- ?php
	$form = ActiveForm::begin([
	    'method' => 'post',
	    'action' => ['esm/purchaseorder/createpo'],
	    'id' => 'cpo',
	]);
	? -->
<form  id="cpo" method="post" action="../purchaseorder/createpo">

	<div class="col-xs-12 <?php if( $kr == 'HR-02'){ echo 'col-md-9'; }else{ echo 'col-md-12'; } ?>">
	  	<?= Yii::$app->session->getFlash('error'); ?>
		<?php 
			$brg = Suplier::find()->where(['KD_SUPPLIER'=>$quer->KD_SUPPLIER])->one(); 		
			$kdpo = $_GET['kdpo'];
		?>
	  	<br/>
		<div class="row">
		  	<div class="col-xs-6 col-sm-6 col-md-6">
		  	<b><?= $brg->NM_SUPPLIER; ?></b><br/>
		  	<?= $brg->ALAMAT; ?><br/>
		  	<?= $brg->KOTA; ?><br/>
		  		<table>
		  			<tr>
		  				<td>Telp / Fax</td>
		  				<td>&nbsp;:&nbsp;</td>
		  				<td>&nbsp;<?= $brg->TLP; ?> / <?= $brg->FAX; ?></td>
		  			</tr>
		  			<tr>
		  				<td>Email</td>
		  				<td>&nbsp;:&nbsp;</td>
		  				<td>&nbsp;<?= $brg->EMAIL; ?></td>
		  			</tr>
		  		</table>
		  	</div>

		  	<div class="col-xs-6 col-sm-6 col-md-6">
		  		<table>
		  			<tr>
		  				<td>Date</td>
		  				<td>&nbsp;:&nbsp;</td>
		  				<td>&nbsp;<?= date("d F Y") ?></td>
		  			</tr>
		  			<tr>
		  				<td>No. Order</td>
		  				<td>&nbsp;:&nbsp;</td>
		  				<td>&nbsp;<?= $kdpo; ?></td>
		  			</tr>
		  			<tr>
		  				<td>Order By</td>
		  				<td>&nbsp;:&nbsp;</td>
		  				<td>&nbsp;<?= Yii::$app->user->identity->username; ?></td>
		  			</tr>
		  			<tr>
		  				<td title="Estimasi Pengiriman Barang">ETD</td>
		  				<td>&nbsp;:&nbsp;</td>
		  				<td>&nbsp;<input type="date" name="etd" id="etd" min="<?= date("Y-m-d"); ?>" value="<?php echo $quer->ETD; ?>"></td>
		  			</tr>
		  			<tr>
		  				<td title="Estimasi Kedatangan Barang">ETA</td>
		  				<td>&nbsp;:&nbsp;</td>
		  				<td>&nbsp;<input type="date" name="eta" id="eta" min="<?= date("Y-m-d"); ?>" value="<?php echo $quer->ETA; ?>"></td>
		  			</tr>
		  		</table>
		  	</div>
		</div>

<hr/>	




<input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
	<table class="table table-bordered table-striped"  style="border-collapse:collapse;">
		<thead style="background-color:orange;">
			<tr>
				<th>#</th>
				<th>Kode Barang</th>
				<th>Nama Barang</th>
				<th>Qty</th>
				<th>Unit</th>
				<th>Harga / Unit</th>
				<th>Total</th>
			</tr>
		</thead>
		
		<tbody>
			<?php $a=0; foreach ($podet as $po => $rows) { $a=$a+1;  ?>

			<?php if($a == 1){ echo "</form>"; } ?>
			<tr style="cursor:pointer;">

			<?php 
				$ckBrg = explode('.', $rows->KD_BARANG);
				if($ckBrg[0] == 'BRG'){
					$nmBrg = Barang::find('NM_BARANG','HARGA')->where(['KD_BARANG'=>$rows->KD_BARANG])->one();
				} else if($ckBrg[0] == 'BRGU') {
					$nmBrg = Barangumum::find('NM_BARANG','HARGA')->where(['KD_BARANG'=>$rows->KD_BARANG])->one();
				}

	      		$ckUnit = preg_replace("/[^A-Z\']/", '', $rows->UNIT);
	      		if($ckUnit == 'U'){
					$brg = lukisongroup\models\master\Unitbarang::find('NM_UNIT')->where(['KD_UNIT'=>$rows->UNIT])->one();
	      		} else {
					$brg = lukisongroup\models\esm\Unitbarang::find('NM_UNIT')->where(['KD_UNIT'=>$rows->UNIT])->one();
	      		}

			?>

				<td class=" accordion-toggle" data-toggle="collapse" data-target="#demo<?php echo $a; ?>"><?php echo $a; ?></td>
				<td class=" accordion-toggle" data-toggle="collapse" data-target="#demo<?php echo $a; ?>"><?php echo $rows->KD_BARANG; ?> </td>
				<td class=" accordion-toggle" data-toggle="collapse" data-target="#demo<?php echo $a; ?>"><?php echo $nmBrg->NM_BARANG; ?></td>
				<td class=" accordion-toggle" data-toggle="collapse" data-target="#demo<?php echo $a; ?>">
					<?php echo $rows->QTY; ?>
					<input type="hidden" name="dqty" id="dqty<?php echo $a; ?>" value="<?php echo $rows->QTY; ?>" />
				</td>
				<td class=" accordion-toggle" data-toggle="collapse" data-target="#demo<?php echo $a; ?>"><?php echo $brg->NM_UNIT; ?></td>
				<td>
					<input type="text" name="hargaBarang[]" id="hargaBarang<?php echo $a; ?>" value="<?php echo $nmBrg->HARGA; ?>"  onchange="hrga()" onkeypress="hrga()" onkeyup="hrga()" required />
					<input type="hidden" name="kdBarang[]" id="kdBarang[]" value="<?php echo $rows->KD_BARANG; ?>"  required />
				</td>
				<td>
					<input type="text" name="total[]" id="total<?php echo $a; ?>" value="" disabled />
				</td>

			</tr>

	        <tr >
	            <td colspan="7"  class="hiddenRow"  style="padding:0px;">
            	<div class="accordian-body collapse" id="demo<?php echo $a; ?>" style="padding:10px;">
        		
					<?php
						$form = ActiveForm::begin([
						    'method' => 'post',
						    'action' => ['esm/purchaseorder/spo?kdpo='.$kdpo],
						    'id' => 'detpo'.$a,
						]);
					?>
        		<table class="table table-hover">
					<thead style="background-color:#FF8533;">
						<tr>
							<th>Kode RO</th>
							<th>Devisi</th>
							<th>Quantity</th>
							<th></th>
						</tr>
					</thead>

					<tbody>
						<?php 
							$pod = Podetail::find()->where(['ID_DET_PO'=>$rows->ID])->andWhere('STATUS <> 3')->all(); 
							$b=0; foreach ($pod as $pods => $pode) { $b=$b+1; 

							$ro_dep = Requestorder::find('KD_DEP')->where(['KD_RO'=> $pode->KD_RO])->one(); 
						?>
						<tr>
							<td><?php echo $pode->KD_RO; ?></td>
							<td><?php echo $ro_dep->KD_DEP; ?></td>
							<td id="<?php echo 'a'.$a.''.$b; ?>" onclick="edit(<?php echo $a.''.$b; ?>)">
								<?php echo $pode->QTY; ?>
							</td>

							<td style="display:none;" id="<?php echo 'b'.$a.''.$b; ?>">
							<div class="row">
							  <div class="col-xs-2">
							  	<input type="text" class="form-control" value="<?php echo $pode->QTY; ?>" name="qty[]" />
							  	<input type="hidden" class="form-control" value="<?php echo $pode->ID; ?>" name="id[]" />
							  	<input type="hidden" class="form-control" value="<?php echo $rows->ID; ?>" name="idpo" />
							  </div>
							  <div class="col-xs-8">
							  	<input type="text" class="form-control" value="<?php echo $pode->NOTE; ?>" placeholder="Keterangan" name="ket[]" />
							  </div>
							</div>
							</td>

							<td>
								<?php if($quer->STATUS != 102){  ?>
								<a href="delpo?idpo=<?php echo $pode->ID; ?>&kdpo=<?php echo $kdpo; ?>" onclick="return confirm('Anda yakin ingin menghapus file ini?');" ><i class="fa fa-trash"></i></a>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
        		</table>

        		<?php if($quer->STATUS != 102){  if( $kr == 'HR-02'){ ?>
        		<div style="text-align:right;">
        			<button type="button" class="btn btn-success btn-sm" onclick="document.getElementById('detpo<?php echo $a; ?>').submit();">Ubah Qty</button>
        		</div>
        		<?php } } ?>

				<?php ActiveForm::end(); ?>

            	</div>  
	            </td>
	        </tr>

			<?php } ?>

			<tr>
				<td colspan="5"></td>
				<td style="text-align:right; font-size:13pt; font-weight:bold;">Sub Total</td>
				<td>
					<input type="text" name="ttlHrg" id="ttlHrg" value="" disabled />
				</td>
			</tr>

			<tr>
				<td colspan="5" rowspan="4"><b>Notes :</b>
					<textarea class="form-control" rows="6" style="resize:vertical;" name="note" id="note"><?php echo $quer->NOTE; ?></textarea>
				</td>
				<td style="text-align:right; font-size:13pt; font-weight:bold;">Disc.</td>
				<td>
					<input type="text" name="disc" id="disc" value="<?php echo $quer->DISC; ?>" onchange="hrga()" onkeypress="hrga()" onkeyup="hrga()" />
				</td>
			</tr>

			<?php if($quer->PAJAK == 0){ $pjk = '10'; }else{ $pjk = $quer->PAJAK; } ?>
			<tr>
				<td style="text-align:right; font-size:13pt; font-weight:bold;">Pajak 
					<input type="number" id="pajak" name="pajak" style="width:60px;" value="<?php echo $pjk; ?>" min="0" onchange="hrga()" onkeypress="hrga()" onkeyup="hrga()" /> %
				</td>
				<td>
					<input type="text" name="hrgPjk" id="hrgPjk" value="" disabled />
				</td>
			</tr>

			<tr>
				<td style="text-align:right; font-size:13pt; font-weight:bold;">Delv. Cost</td>
				<td>
					<input type="text" name="delvCost" id="delvCost" value="<?php echo $quer->DELIVERY_COST ?>" onchange="hrga()" onkeypress="hrga()" onkeyup="hrga()"/>
				</td>
			</tr>

			<tr>
				<td style="text-align:right; font-size:13pt; font-weight:bold;">Total</td>
				<td>
					<input type="text" name="ttlHrgPjk" id="ttlHrgPjk" value="" disabled />
				</td>
			</tr>

		</tbody>
	</table>	

	<?php 	$nmpr = Nmperusahaan::find()->all(); ?>
<div class="row form-horizontal">
  <div class="col-xs-12 col-sm-12 col-md-12">
	  <div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label">Shipping Address</label>
	    <div class="col-sm-5">
			<select class="form-control" name="shipping" required>
					<option value=""> -- PILIH --</option>
				<?php foreach($nmpr as $nm){ ?>
					<option value="<?php echo $nm->ID; ?>" <?php if($quer->SHIPPING == $nm->ID){ echo "selected"; } ?> ><?php echo $nm->NM_ALAMAT; ?></option>
				<?php } ?>
			</select>
		</div>
	  </div>
  </div>
  
  <div class="col-xs-12 col-sm-12 col-md-12">
	  <div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label">Billing Address</label>
	    <div class="col-sm-5">
			<select class="form-control" name="billing" required>
					<option value=""> -- PILIH --</option>
				<?php foreach($nmpr as $nm){ ?>
					<option value="<?php echo $nm->ID; ?>"  <?php if($quer->BILLING == $nm->ID){ echo "selected"; } ?> ><?php echo $nm->NM_ALAMAT; ?></option>
				<?php } ?>
			</select>
	    </div>
	  </div>
  </div>

</div>


	<br/><br/>
	<?php if($quer->STATUS != 102){ if( $kr == 'HR-02'){ ?>
	<input type="hidden" name="kdpo" id="kdpo" value="<?php echo $kdpo; ?>" required/>
	<button type="button" class="btn btn-warning btn-sm" onclick="document.getElementById('cpo').submit();">Buat PO</button>
	<input type="hidden" name="ttlLop" id="ttlLop" value="<?php echo $a; ?>" required/>
	<?php } } ?>

<!-- ?php ActiveForm::end(); ? -->
</form>
		<script>
		window.onload = function(){ hrga(); }

		function hrga(){
			lop = document.getElementById('ttlLop').value;
			pjk = document.getElementById('pajak').value / 100;
			disc = document.getElementById('disc').value;
			delvCost = document.getElementById('delvCost').value;

			var b = 0;
			for(a=1; a<=lop; a++){
				var qty = document.getElementById('dqty'+a).value;
				var hrg = document.getElementById('hargaBarang'+a).value;
				var hsl = parseInt(qty) * parseInt(hrg);
				document.getElementById('total'+a).value = hsl;
				var b = parseInt(b) + parseInt(hsl);
			}
			document.getElementById('ttlHrg').value = b;
			var hrgDsc = b - disc;

			var hrgPjk = pjk * hrgDsc;
			document.getElementById('hrgPjk').value = hrgPjk;
			document.getElementById('ttlHrgPjk').value = parseInt(hrgDsc) + parseInt(hrgPjk) + parseInt(delvCost);
		}


		function edit(kd){
			document.getElementById('a'+kd).style.display="none";
			document.getElementById('b'+kd).style.display="block";
		}	

		</script>

	</div>
</div>
