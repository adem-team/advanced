<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\CustomercallTimevisit */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Customercall Timevisits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customercall-timevisit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
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
            'ID',
            'TGL',
            'STS',
            'CUST_ID',
            'CUST_NM',
            'USER_ID',
            'USER_NM',
            'SCDL_GROUP',
            'SCDL_GRP_NM',
            'ABSEN_MASUK',
            'ABSEN_KELUAR',
            'ABSEN_TOTAL',
            'GPS_GRP_LAT',
            'GPS_GRP_LONG',
            'ABSEN_MASUK_LAT',
            'ABSEN_MASUK_LONG',
            'ABSEN_MASUK_DISTANCE',
            'ABSEN_KELUAR_LAT',
            'ABSEN_KELUAR_LONG',
            'ABSEN_KELUAR_DISTANCE',
            'CUST_CHKIN',
            'CUST_CHKOUT',
            'LIVE_TIME',
            'JRK_TEMPUH',
            'JRK_TEMPUH_PULANG',
            'GPS_CUST_LAT',
            'GPS_CUST_LAG',
            'LAT_CHEKIN',
            'LONG_CHEKIN',
            'DISTANCE_CHEKIN',
            'LAT_CHEKOUT',
            'LONG_CHEKOUT',
            'DISTANCE_CHEKOUT',
            'UPDATE_BY',
            'UPDATE_AT',
        ],
    ]) ?>

</div>
