<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->sideCorp = 'Master Data Umum';               		   	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';               		    	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Type Detail Barang ');	    /* title pada header page */

?>
<div class="tipebarang-view">

<?php
	if($model->STATUS == '1'){
		$stat = "Aktif";
	} else {
		$stat = "Tidak Aktif";
	}
 ?>
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'NM_TYPE',
            'NOTE:ntext',
			[
				'label' => 'Status',
				'value' => $stat,
			],
        ],
    ]) ?>
	
    <p>
        <?= Html::a('<i class="fa fa-pencil"></i>&nbsp;&nbsp; Ubah', ['update', 'ID' => $model->ID, 'KD_TYPE' => $model->KD_TYPE], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash"></i>&nbsp;&nbsp; Hapus', ['delete', 'ID' => $model->ID, 'KD_TYPE' => $model->KD_TYPE], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
