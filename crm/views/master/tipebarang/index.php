<?php
use yii\helpers\Html;
use kartik\grid\GridView;

$this->sideCorp = 'Master Data Umum';                  	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                   	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Type Barang');	    /* title pada header page */
?>

<div class="tipebarang-index">

	<?php 
		$gridColumns = [
			['class' => 'yii\grid\SerialColumn'],

			'NM_TYPE',
			'NOTE:ntext',
				[
					'attribute' => 'STATUS',
					'value' => function ($model) {
						return $model->STATUS == 1 ? 'Aktif' : 'Tidak Aktif';
					},
				],

			['class' => 'yii\grid\ActionColumn'],
		];

	echo Yii::$app->gv->grview($gridColumns,$dataProvider,$searchModel, 'Tipe Barang', 'tipe-barang','');//$this->title);
	
	?>

</div>
