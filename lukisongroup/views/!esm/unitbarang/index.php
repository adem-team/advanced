<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->sideCorp = 'ESM Prodak Unit';                  /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_datamaster';                   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Unit Prodak');      /* title pada header page */
?>


<div class="unitbarang-index">

    <?php 
	$gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            'KD_UNIT',
            'NM_UNIT',
            'QTY',
            'SIZE',
            ['class' => 'yii\grid\ActionColumn','template' => '{view} {update}'],
        ]; 
	echo Yii::$app->gv->grview($gridColumns,$dataProvider,$searchModel, 'Unit', 'unit','');
	
	?>
</div>