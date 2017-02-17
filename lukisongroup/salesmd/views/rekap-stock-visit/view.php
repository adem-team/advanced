<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\salesmd\models\RekapStockVisit */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rekap Stock Visits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rekap-stock-visit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'CUST_KD',
            'CUST_NM',
            'KD_BARANG',
            'NM_BARANG',
            'TGL',
            'POS',
            'SO_TYPE',
            'USER_ID',
            'w0',
            'w1',
            'w2',
            'w3',
            'w4',
            'w5',
            'w6',
            'w7',
            'w8',
            'w9',
            'w10',
            'w11',
            'w12',
            'w13',
            'w14',
            'w15',
            'w16',
            'w17',
            'w18',
            'w19',
            'w20',
            'w21',
            'w22',
            'w23',
            'w24',
            'w25',
            'w26',
            'w27',
            'w28',
            'w29',
            'w30',
            'w31',
            'w32',
            'w33',
            'w34',
            'w35',
            'w36',
            'w37',
            'w38',
            'w39',
            'w40',
            'w41',
            'w42',
            'w43',
            'w44',
            'w45',
            'w46',
            'w47',
            'w48',
            'w49',
            'w50',
            'w51',
            'w52',
            'w53',
        ],
    ]) ?>

</div>
