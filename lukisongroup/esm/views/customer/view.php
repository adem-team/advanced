<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->sideCorp = 'ESM Prodak';                      		  /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_datamaster';                 		  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Customer Detail');        /* title pada header page */

?>
<div class="customer-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->CUST_KD], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->CUST_KD], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

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
            'EMP_ID',
            'PARRENT',
            'GEO_KOORDINAT',
        ],
    ]) ?>

</div>
