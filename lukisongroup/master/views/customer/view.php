<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->sideCorp = 'Master Data Umum';                  /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Customer Detail ');    /* title pada header page */
?>
<div class="customer-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'CUST_KD',
            'CUST_NM',
            'ALAMAT:ntext',
            'PIC',
            'TLP1',
            'TLP2',
            'FAX',
            'EMAIL:email',
            'WEBSITE',
            'NOTE:ntext',
            'STATUS',
            'NPWP',
            'STT_TOKO',
            'CREATED_BY',
            'CREATED_AT',
            'UPDATED_AT',
            'UPDATED_BY',
            'DATA_ALL',
        ],
    ]) ?>

</div>
