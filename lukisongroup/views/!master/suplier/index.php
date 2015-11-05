<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use lukisongroup\models\esm\perusahaan;
//use lukisongroup\models\hrd\Corp;

$this->sideCorp = 'Master Data Umum';                  	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                   	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Supplier');	    /* title pada header page */
?>

<div class="suplier-index">

<?php 
	$gridColumns = [
		['class' => 'yii\grid\SerialColumn'],
            'KD_SUPPLIER',
            'NM_SUPPLIER',
            'ALAMAT:ntext',
            'KOTA',
			'nmgroup',
		['class' => 'yii\grid\ActionColumn'],
	];

	echo Yii::$app->gv->grview($gridColumns,$dataProvider,$searchModel, 'Suplier', 'suplier',$this->title);
	
?>

</div>
