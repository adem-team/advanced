<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\salesmd\models\RekapStockVisitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Rekap Stock Visits');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rekap-stock-visit-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Rekap Stock Visit'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'CUST_KD',
            'CUST_NM',
            'KD_BARANG',
            'NM_BARANG',
            // 'TGL',
            // 'POS',
            // 'SO_TYPE',
            // 'USER_ID',
            // 'w0',
            // 'w1',
            // 'w2',
            // 'w3',
            // 'w4',
            // 'w5',
            // 'w6',
            // 'w7',
            // 'w8',
            // 'w9',
            // 'w10',
            // 'w11',
            // 'w12',
            // 'w13',
            // 'w14',
            // 'w15',
            // 'w16',
            // 'w17',
            // 'w18',
            // 'w19',
            // 'w20',
            // 'w21',
            // 'w22',
            // 'w23',
            // 'w24',
            // 'w25',
            // 'w26',
            // 'w27',
            // 'w28',
            // 'w29',
            // 'w30',
            // 'w31',
            // 'w32',
            // 'w33',
            // 'w34',
            // 'w35',
            // 'w36',
            // 'w37',
            // 'w38',
            // 'w39',
            // 'w40',
            // 'w41',
            // 'w42',
            // 'w43',
            // 'w44',
            // 'w45',
            // 'w46',
            // 'w47',
            // 'w48',
            // 'w49',
            // 'w50',
            // 'w51',
            // 'w52',
            // 'w53',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
