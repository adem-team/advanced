<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model crm\salespromo\models\Penjualan */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Penjualans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penjualan-view">

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
            'WAKTU',
            'CUST_KD',
            'CUST_NM',
            'KD_BARANG',
            'NM_BARANG',
            'STOCK_SOLD_OUT',
            'PRODAK_LINE',
            'CORP_ID',
            'KD_DISTRIBUTOR',
            'KD_SUBDIST',
            'CREATED_BY',
            'UPDATED_BY',
            'UPDATED_TIME',
            'STATUS',
        ],
    ]) ?>

</div>
