<?php

use yii\helpers\Html;

$this->sideCorp = 'ESM Distributor';                  		/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_datamaster';                   		/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Distributor Entry');    /* title pada header page */
?>

<div class="distributor-create">
 
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
