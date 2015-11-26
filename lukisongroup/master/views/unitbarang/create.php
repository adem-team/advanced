<?php

use yii\helpers\Html;
$this->sideCorp = 'ESM Prodak Unit';                        /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_datamaster';                   		/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Unit Prodak Entry');      /* title pada header page */                   /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

?>
<div class="unitbarang-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
