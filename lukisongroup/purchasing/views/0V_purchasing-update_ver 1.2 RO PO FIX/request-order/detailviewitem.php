<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->sideCorp = 'Prodak';                       	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'master_datamaster';                   	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Prodak View');       /* title pada header page */

?>
<div class="barang-view">

<?php
	$sts = $brgDetail->STATUS;
	if($sts == 1){
		$stat = 'Aktif';
	} else {
		$stat = 'Tidak Aktif';
	}

	if($brgDetail->IMAGE == null){ $gmbr = "df.jpg"; } else { $gmbr = $brgDetail->IMAGE; } 
    echo DetailView::widget([
		'model' => $brgDetail,
		'attributes' => [
			[
				'attribute'=>'Gambar',
				'value'=>Yii::$app->urlManager->baseUrl.'/upload/barang/'.$gmbr,
				'format' => ['image',['width'=>'150','height'=>'150']],
			], 	
			'KD_BARANG',
			[
				'attribute' =>'NM_BARANG',
				'label' =>'Item Name',
			],
			
			[
				'label' => 'Unit Item',
				'value' => $brgDetail->unitb->NM_UNIT,
			],
			[
				'attribute' => 'HARGA_SPL',
				'label' =>'Price',
			],
			[
				'attribute' => 'nmcorp',
				'label' =>'Corporate',
			],
			[
				'attribute' => 'CREATED_BY',
				'label' =>'Register By',
			],
			
			[
				'label' => 'Status',
				'value' => $stat,
			], 
			'NOTE',			
        ],
    ])
?>
    
</div>
