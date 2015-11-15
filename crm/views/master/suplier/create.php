<?php

use yii\helpers\Html;

$this->sideCorp = 'Master Data Umum';              	    	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                	   	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Supplier Entry');	    /* title pada header page */                     /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

?>
<div class="suplier-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
