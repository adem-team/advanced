<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use lukisongroup\dashboard\models\Barang;

$this->sideCorp = 'Prodak';                       	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'master_datamaster';                   	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Prodak View');       /* title pada header page */

?>
<div class="barang-view">

<?php
	$sts = $model->STATUS;
	if($sts == 1){
		$stat = 'Aktif';
	} else {
		$stat = 'Tidak Aktif';
	}

	if($model->IMAGE == null){ $gmbr = "df.jpg"; } else { $gmbr = $model->IMAGE; } 
	?>
	
    <?= DetailView::widget([
		'model' => $model,
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
				'value' => $model->unitb->NM_UNIT,
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
    ]) ?>


    <p>
     
        <?= Html::a('<i class="fa fa-trash-o"></i>&nbsp;&nbsp;Hapus', ['delete', 'id' => $model->ID], [
			'class' => 'btn btn-danger',
			'data' => [
			    'confirm' => 'Are you sure you want to delete this item?',
			    'method' => 'post',
			],
        ]) ?>
    </p>
</div>
