<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\DetailView;


$this->title = $reqro->KD_RO;
$this->params['breadcrumbs'][] = ['label' => 'Request Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
@media print {
	body { font-family: verdana, arial, sans-serif ; }
	.pnjg{ width:120px; }
	.ttl{ text-align:center; }
	
	table{
		width:100%;
	}
	 th,td {
            padding: 4px 4px 4px 4px ;
			margin: 0px;
            }
	th {
		border-bottom: 2px solid #333333 ;
		}
	td {
		border-bottom: 1px dotted #999999 ;
		}
	tfoot td {
		border-bottom-width: 0px ;
		border-top: 2px solid #333333 ;
		padding-top: 20px ;
		}
}
</style>

<div class="ttl">
	<center>
		<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg']);?>
	</center>


    <center>
		<h2 style="margin-bottom:0px;"><b>Form Permintaan Barang</b></h2>
		<h3 style="margin-top:0px;">Nomor : <?= Html::encode($this->title) ?></h3>
	</center>

<br/><br/>
    <table>

        <thead>
            <tr>
				<th>No.</th>
				<th>Nama Barang</th>
				<th>Kode Barang</th>
				<th>Quantity</th>
				<th>Satuan Barang</th>
				<th>Catatan</th>
            </tr>
        </thead>
		
        <?php $no=0; foreach($detro as $ro){ $sts = $ro->STATUS; if($sts == 0 OR $sts == 3 ){ } else { $no=$no+1; ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $ro->NM_BARANG; ?></td>
                <td><?php echo $ro->KD_BARANG; ?></td>
                <td><?php echo $ro->QTY; ?></td>
                <td><?php echo $ro->UNIT; ?></td>
                <td><?php echo $ro->NOTE; ?></td>
            </tr>
        <?php } } ?>
    </table>

</div>
<br/><br/>
<br/>
<?php 


    $tgl = explode(' ',$reqro->CREATED_AT);
    $awl = explode('-',$tgl[0]); 
    $blnAwl = date("F", mktime(0, 0, 0, $awl[1], 1));
?>
  <div style="width:300px; float:right; ">
  <b>Tanggerang, <?php echo $awl[2].' - '.$blnAwl.' - '.$awl[0];  ?></b><br/>
  yang mengajukan,
  <br/><br/><br/><br/>
  <?php echo $employ->EMP_NM.' '.$employ->EMP_NM_BLK; ?>
  </div>


