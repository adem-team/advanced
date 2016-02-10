<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;;
use lukisongroup\master\models\Terminvest;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termcustomers */

function pihakSearch($model){
  $title = Yii::t('app','');
  $options = [ 'id'=>'select-spl-id',
          'data-toggle'=>"modal",
          'data-target'=>"#search-spl",
          'class'=>'btn btn-warning btn-xs',
          //'style'=>['width'=>'150px'],
          'title'=>'Set Supplier'
  ];
  $icon = '<span class="glyphicon glyphicon-open"></span>';
  $label = $icon . ' ' . $title;
  $url = Url::toRoute(['/purchasing/purchase-order/supplier-view','id'=>$model->ID_TERM]);
  $content = Html::a($label,$url, $options);
  return $content;
}

?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">

  <div  class="row">
	<!-- HEADER !-->
		<div class="col-md-12">
			<div class="col-md-1" style="float:left;">
				<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
			</div>
			<div class="col-md-9" style="padding-top:15px;">
				<h3 class="text-center"><b> Trading Term <?php echo date('Y')  ?> </b></h3>
			</div>
			<div class="col-md-12">
				<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
			</div>

		</div>
	</div>

  <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;">
      <div>
        <?php echo pihakSearch($model); ?>
      </div>
      <dl>
        <?php
          // $splName = $supplier!='' ? $supplier->NM_SUPPLIER : 'Supplier No Set';
          // $splAlamat = $supplier!='' ? $supplier->ALAMAT : 'Address No Set';
          // $splKota = $supplier!='' ? $supplier->KOTA : 'City No Set';
          // $splTlp = $supplier!='' ? $supplier->TLP : 'Phone No Set';
          // $splFax = $supplier!='' ? $supplier->FAX : 'FAX No Set';
          // $splEmail= $supplier!='' ? $supplier->EMAIL : 'Email No Set';
        ?>
        <!-- <dt><$splName; ?></dt>
        <dt>$splAlamat; ?></dt>
        <dt><$splKota; ?></dt>
        <dt style="width:80px; float:left;">Telp / Fax</dt>
        <dd>:	<$splTlp; ?> / <$splFax; ?></dd>
        <dt style="width:80px; float:left;">Email</dt>
        <dd>:	<$splEmail; ?></dd> -->
      </dl>
    </div>
  </div>
