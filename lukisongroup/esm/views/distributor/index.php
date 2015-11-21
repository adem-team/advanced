<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->sideCorp = 'ESM Distributor';                  /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_datamaster';                   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Distributor');    /* title pada header page */
?>

<div class="distributor-index">
    <?php $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],

            'KD_DISTRIBUTOR',
            'NM_DISTRIBUTOR',
            'ALAMAT:ntext',
            'PIC',
            ['class' => 'yii\grid\ActionColumn'],
        ]; 
	
		echo Yii::$app->gv->grview($gridColumns,$dataProvider,$searchModel, 'Distributor', 'distributor','');//$this->title);
	?>

</div>
