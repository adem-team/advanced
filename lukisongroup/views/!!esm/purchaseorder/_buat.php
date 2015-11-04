<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;

//use terlebih dahulu
use yii\bootstrap\Modal;

use lukisongroup\models\esm\ro\Rodetail;
use lukisongroup\models\esm\ro\RodetailSearch;

use lukisongroup\models\master\Barangumum;
use lukisongroup\models\master\Suplier;
use lukisongroup\models\master\Unitbarang;

use lukisongroup\models\esm\po\Podetail;

?>

<!-- Stack the columns on mobile by making one full-width and the other half-width -->
<div class="row">
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
	                    return  Html::a('<button type="button" class="btn btn-success btn-xs">View</button>',['detail','kd_ro'=>$data->KD_RO,'kdpo'=>$_GET['kdpo']],[
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


	<div class="col-xs-12 col-md-9">
		<h2 style="margin-top:0px;">&nbsp;&nbsp;&nbsp; 
		<?php 
			$brg = Suplier::find('NM_SUPPLIER')->where(['KD_SUPPLIER'=>$quer->KD_SUPPLIER])->one(); 
			echo $brg->NM_SUPPLIER;
		?>
		</h2>


		<table class="table table-bordered table-striped"  style="border-collapse:collapse;">
			<thead style="background-color:orange;">
				<tr>
					<th>#</th>
					<th>Nama Barang</th>
					<th>Qty</th>
					<th>Unit</th>
				</tr>
			</thead>
			
			<tbody>
				<?php $a=0; foreach ($podet as $po => $rows) { $a=$a+1; ?>
				
				<tr class=" accordion-toggle" data-toggle="collapse" data-target="#demo<?php echo $a; ?>" style="cursor:pointer;">
					<?php $nmBrg = Barangumum::find('NM_BARANG')->where(['KD_BARANG'=>$rows->KD_BARANG])->one(); ?>
					<td><?php echo $a; ?></td>
					<td><?php echo $nmBrg->NM_BARANG; ?></td>
					<td><?php echo $rows->QTY; ?></td>
					<td><?php echo $rows->UNIT; ?></td>
				</tr>

		        <tr >
		            <td colspan="6"  class="hiddenRow"  style="padding:0px;">
		            	<div class="accordian-body collapse" id="demo<?php echo $a; ?>" style="padding:10px;">
		            		<table class="table table-hover">
								<thead style="background-color:#FF8533;">
									<tr>
										<th>Kode RO</th>
										<th>Quantity</th>
										<th>Unit</th>
									</tr>
								</thead>

<?php
$kdpo = $_GET['kdpo'];
$form = ActiveForm::begin([
    'method' => 'post',
    'action' => ['esm/purchaseorder/spo?kdpo='.$kdpo],
]);
?>
								<tbody>
									<?php $pod = Podetail::find()->where(['ID_DET_PO'=>$rows->ID])->all(); ?>
									<?php $b=0; foreach ($pod as $pods => $pode) { $b=$b+1;  ?>
									<tr>
										<td><?php echo $pode->KD_RO; ?></td>
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
											  	<input type="text" class="form-control" value="" placeholder="Keterangan" name="ket[]" />
											  </div>
											</div>

										</td>
										<td>
									<?php $brg = Unitbarang::find('NM_UNIT')->where(['KD_UNIT'=>$pode->UNIT])->one(); ?><?php echo $brg->NM_UNIT; ?></td>
									</tr>
									<?php } ?>
								</tbody>
		            		</table>
		            		<div style="text-align:right;">
		            			<button type="submit" class="btn btn-success">Ubah Qty</button>
		            		</div>
<?php
 ActiveForm::end(); 
 ?>

		            	</div>  
		            </td>
		        </tr>

				<?php } ?>
			</tbody>
		</table>	

<script>
function edit(kd){
	document.getElementById('a'+kd).style.display="none";
	document.getElementById('b'+kd).style.display="block";
}	
</script>
	</div>
</div>
