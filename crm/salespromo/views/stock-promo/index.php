<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel crm\salespromo\models\Stock_promoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock Promos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-promo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Stock Promo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'WAKTU',
            'CUST_KD',
            'CUST_NM',
            'KD_BARANG',
            // 'NM_BARANG',
            // 'STOCK_PROMO',
            // 'PRODAK_LINE',
            // 'CORP_ID',
            // 'KD_DISTRIBUTOR',
            // 'KD_SUBDIST',
            // 'CREATED_BY',
            // 'UPDATED_BY',
            // 'UPDATED_TIME',
            // 'STATUS',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
