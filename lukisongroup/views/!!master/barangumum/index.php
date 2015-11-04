<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use lukisongroup\models\master\Barangumum;

$this->sideCorp = 'Master Data Umum';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';               /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Barang ');    /* title pada header page */

?>

<div class="barangumum-index" style="padding:10px;">

<?php 
$gridColumns = [
	['class' => 'yii\grid\SerialColumn'],
		'KD_BARANG',
		'NM_BARANG',
		'nmtype',
		'nmktegori',
	['class' => 'yii\grid\ActionColumn'],
];

	echo Yii::$app->gv->grview($gridColumns,$dataProvider,$searchModel, 'Barang Umum', 'BarangUmum','');//$this->title);
	

?>


</div>
