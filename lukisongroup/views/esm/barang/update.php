<?php

use yii\helpers\Html;

//$this->title = 'Ubah Barang : ' . ' ' . $model->KD_BARANG;
//$this->params['breadcrumbs'][] = ['label' => 'Barang', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID]];
//$this->params['breadcrumbs'][] = 'Update';

$this->sideCorp = 'ESM Prodak';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_datamaster';                   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Prodak Update');           /* title pada header page */
?>
<div class="barang-update">

    <?= $this->render('_update', [
        'model' => $model,
    ]) ?>

</div>
