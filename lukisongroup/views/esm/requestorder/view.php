<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\ro\Requestorder */

$this->sideCorp = 'ESM Request Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_esm';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Data Master');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

?>




<div class="requestorder-view" style="margin:0px 20px;">

    <center>
		<h2 style="margin-bottom:0px;"><b>Form Permintaan Barang</b></h2>
		<h3 style="margin-top:0px;">Nomor : <?php echo $reqro->KD_RO; ?></h3>
	</center>

    <!-- p>
        < ?= Html::a('Update', ['update', 'id' => $reqro->ID], ['class' => 'btn btn-primary']) ?>
        < ?= Html::a('Delete', ['delete', 'id' => $reqro->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p -->

    <!-- ?= DetailView::widget([
        'model' => $reqro,
        'attributes' => [
            'ID',
            'KD_RO',
            'NOTE:ntext',
            'ID_USER',
            'KD_CORP',
            'KD_CAB',
            'KD_DEP',
            'STATUS',
            'CREATED_AT',
            'UPDATED_ALL',
            'DATA_ALL:ntext',
        ],
    ]) ? -->
<br/>

    <table class="table table-striped" style="background-color:#fff; border:1px solid #7D7DB2; ">
        <thead style="background-color:#A1A1E6; ">
            <th>No.</th>
            <th>Nama Barang</th>
            <th>Kode Barang</th>
            <th>Quantity</th>
            <th>Satuan Barang</th>
            <th>Catatan</th>
            <th></th>
        </thead>


        <tbody>
        <?php $no=0; foreach($detro as $ro){ 
			if($ro->STATUS == 3) {} else { $no=$no+1; ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $ro->NM_BARANG; ?></td>
                <td><?php echo $ro->KD_BARANG; ?></td>
                <td><?php echo $ro->QTY; ?></td>
                <td><?php echo $ro->UNIT; ?></td>
                <td><?php echo $ro->NOTE; ?></td>
                <td><?php if($ro->STATUS == 1){ echo '<i class="fa fa-check fa-fw" style="color:blue;"></i>';  } else { echo '<i class="fa fa-question fa-fw" style="color:red;"></i>'; }; ?></td>
            </tr>
        <?php } } ?>
        </tbody>
    </table>

<br/>
<?php 


    $tgl = explode(' ',$reqro->CREATED_AT);
    $awl = explode('-',$tgl[0]); 
    $blnAwl = date("F", mktime(0, 0, 0, $awl[1], 1));
?>
<div class="row">
  <div class="col-md-8">
	<?php 
		echo Html::a('<i class="fa fa-print fa-fw"></i> Cetak', ['cetakpdf','kd'=>$reqro->KD_RO], ['target' => '_blank', 'class' => 'btn btn-success']);
	?>
</div>
  <div class="col-md-4">
  <b>Tanggerang, <?php echo $awl[2].' - '.$blnAwl.' - '.$awl[0];  ?></b><br/>
  yang mengajukan,
  <br/><br/><br/><br/>
  <?php echo $employ->EMP_NM.' '.$employ->EMP_NM_BLK; ?>
  </div>
</div>


</div>

