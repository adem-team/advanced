<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->sideCorp = 'ESM Prodak';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_datamaster';                   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Customer');       /* title pada header page */

?>
<div class="customer-index">

 
    <p>
        <?= Html::a('Create Customer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'CUST_KD',
            'CUST_NM',
            'ALAMAT:ntext',
            'PIC',
            'TLP1',
            // 'TLP2',
            // 'FAX',
            // 'EMAIL:email',
            // 'WEBSITE',
            // 'NOTE:ntext',
            // 'STATUS',
            // 'NPWP',
            // 'STT_TOKO',
            // 'CREATED_BY',
            // 'CREATED_AT',
            // 'UPDATED_AT',
            // 'UPDATED_BY',
            // 'DATA_ALL',
            // 'EMP_ID',
            // 'PARRENT',
            // 'GEO_KOORDINAT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
