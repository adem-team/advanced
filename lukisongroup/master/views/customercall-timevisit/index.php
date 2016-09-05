<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\CustomercallTimevisitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customercall Timevisits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customercall-timevisit-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customercall Timevisit', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'TGL',
            'STS',
            'CUST_ID',
            'CUST_NM',
            // 'USER_ID',
            // 'USER_NM',
            // 'SCDL_GROUP',
            // 'SCDL_GRP_NM',
            // 'ABSEN_MASUK',
            // 'ABSEN_KELUAR',
            // 'ABSEN_TOTAL',
            // 'GPS_GRP_LAT',
            // 'GPS_GRP_LONG',
            // 'ABSEN_MASUK_LAT',
            // 'ABSEN_MASUK_LONG',
            // 'ABSEN_MASUK_DISTANCE',
            // 'ABSEN_KELUAR_LAT',
            // 'ABSEN_KELUAR_LONG',
            // 'ABSEN_KELUAR_DISTANCE',
            // 'CUST_CHKIN',
            // 'CUST_CHKOUT',
            // 'LIVE_TIME',
            // 'JRK_TEMPUH',
            // 'JRK_TEMPUH_PULANG',
            // 'GPS_CUST_LAT',
            // 'GPS_CUST_LAG',
            // 'LAT_CHEKIN',
            // 'LONG_CHEKIN',
            // 'DISTANCE_CHEKIN',
            // 'LAT_CHEKOUT',
            // 'LONG_CHEKOUT',
            // 'DISTANCE_CHEKOUT',
            // 'UPDATE_BY',
            // 'UPDATE_AT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
