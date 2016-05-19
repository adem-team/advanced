
<?php
/* extensions */
use yii\helpers\Html;

 ?>
<div class="container-fluid" style="font-family: tahoma ;font-size: 8pt;">
<!-- logo  -->
  <div style="width:240px; float:left;">
    <?php echo Html::img('@web/img_setting/kop/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
  </div>
  <!-- judul  -->
  <div style="padding-top:40px;">
    <h4 class="text-left"><b><?php echo ucwords($model->JUDUL) ?> </b></h4>
  </div>

  <!-- No,tanggal,Kode ref,jam-->
  <div class="row">
  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"  style="margin-left:0;">
  <dl>
    <dt style="width:150px; float:left;">No</dt>
    <dd style="color:rgba(87, 163, 247, 1)">:<b> <?= $model->KD_BERITA ?></b></dd>

    <dt style="width:150px; float:left;">Tanggal</dt>
    <dd>: <?php echo  $tanggal = $model->CREATED_ATCREATED_BY != ""? substr($model->CREATED_ATCREATED_BY,0,10):"0000-00-00";?></dd>
  </dl>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="margin-right:0">
  <dl>
    <dt style="width:150px; float:left;">Kode Ref</dt>
    <dd style="color:rgba(87, 163, 247, 1)">:<b> <?php  echo $kd_ref = $model->KD_REF !=""? $model->KD_REF: "xxx-xxx-xx" ;?></b></dd>

    <dt style="width:150px; float:left;">Jam</dt>
    <dd>: <?php echo $jam = $model->CREATED_ATCREATED_BY!=""? date('h:i A', strtotime($model->CREATED_ATCREATED_BY)) : "00-00";?></dd>
  </dl>
  </div>
  </div>

<!-- peristiwa kejadian  -->
  <div class="row">
    <div class="col-sm-12">
      <dl>
        <dt style="width:150px; float:left;">Peristiwa/Kejadian</dt>
        <dd>:<b> <?php echo $peristiwa = $model->ISI != ""? $model->ISI : "--------------" ?></b></dd>
      </dl>

  </div>
</div>

<!-- keterangan -->
<div class="row">
  <div class="col-sm-12">
    <dl>
      <dt style="width:150px; float:left;">Keterangan</dt>
      <dd>:<b> <?php echo $keterangan =  $model->DATA_ALL!= ""?:"-------------"; ?></b></dd>
    </dl>
  </div>
</div>

<!-- create signature news -->
<div class="row">
  <div class="col-sm-12">
    <dl>
      <dt style="float:left;">Tangerang,<?php echo $date = date("d M Y",strtotime($model->CREATED_ATCREATED_BY)); ?></dt><br>
      <dt style="float:left;">Dibuat Oleh,</dt>
    </dl>
    <dl>
      <?php
        $ttd1 = $ttdbase64!='' ?  '<img style="width:80; height:40px" src='.$ttdbase64.'></img>' :"";
        echo $ttd1;
      ?>
    </dl>
    <dl>
      <?php
        echo $emp_nm
       ?>
    </dl>

</div>
</div>

</div>
