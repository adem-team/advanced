<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\sales\models\ImportViewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Import Views';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-view-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Import View', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'TGL',
            'CUST_KD',
            'CUST_KD_ALIAS',
            'CUST_NM',
            // 'KD_BARANG',
            // 'KD_BARANG_ALIAS',
            // 'NM_BARANG',
            // 'SO_QTY',
            // 'SO_TYPE',
            // 'POS',
            // 'KD_DIS',
            // 'NM_DIS',
            // 'USER_ID',
            // 'UNIT_BARANG',
            // 'UNIT_QTY',
            // 'UNIT_BERAT',
            // 'HARGA_PABRIK',
            // 'HARGA_DIS',
            // 'HARGA_SALES',
            // 'HARGA_LG',
            // 'NOTED:ntext',
            // 'STATUS',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
