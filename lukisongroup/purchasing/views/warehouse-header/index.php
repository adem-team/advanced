<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\purchasing\models\HeaderDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                           /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_warehouse';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Warehouse Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title; 
?>
<div class="header-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Header Detail'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'TGL',
            'KD_SJ',
            'KD_SO',
            'KD_INVOICE',
            // 'KD_FP',
            // 'ETD',
            // 'ETA',
            // 'KD_BARANG',
            // 'NM_BARANG',
            // 'QTY_UNIT',
            // 'QTY_PCS',
            // 'HARGA',
            // 'DISCOUNT',
            // 'PAJAK',
            // 'DELIVERY_COST',
            // 'NOTE:ntext',
            // 'CREATE_BY',
            // 'CREATE_AT',
            // 'UPDATE_BY',
            // 'UPDATE_AT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
