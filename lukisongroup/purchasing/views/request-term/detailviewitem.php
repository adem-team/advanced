<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->sideCorp = 'Prodak';                       	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'master_datamaster';                   	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Prodak View');       /* title pada header page */

?>
<div class="barang-view">

<?php
	$sts = $roDetail->STATUS;
	if($sts == 1){
		$stat = 'Aktif';
	} else {
		$stat = 'Tidak Aktif';
	}


    echo DetailView::widget([
		'model' => $roDetail,
		'attributes' => [

			[
				'attribute' =>'INVESTASI_PROGRAM',
				'label' =>'Investasi program',
			],

			[
				'attribute' => 'HARGA',
				'label' =>'Price',
			],
			[
				'attribute' => 'nminvest',
				'label' =>'INVESTASI_TYPE',
			],
			[
				'attribute' => 'CREATED_BY',
				'label' =>'Register By',
			],

			[
				'label' => 'Status',
				'value' => $stat,
			],
        ],
    ])
?>

</div>
