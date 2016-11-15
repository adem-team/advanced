<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\purchasing\models\salesmanorder\SoT2Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'So T2s';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-t2-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create So T2', ['create'], ['class' => 'btn btn-success']) ?>
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
            // 'NOTED:ntext',
            // 'HARGA_LG',
            // 'STATUS',
            // 'WAKTU_INPUT_INVENTORY',
            // 'ID_GROUP',
            // 'KODE_REF',
            // 'SUBMIT_QTY',
            // 'SUBMIT_PRICE',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
