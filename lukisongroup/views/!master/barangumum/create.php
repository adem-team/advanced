<?php

use yii\helpers\Html;

$this->sideCorp = 'Master Data Umum';                  /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Barang Entry ');    /* title pada header page */
?>
<div class="barangumum-create">

	<div class="row"> 
		<div class="col-md-8" style="margin:10px;"> 
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>

		</div>
	</div>
</div>
