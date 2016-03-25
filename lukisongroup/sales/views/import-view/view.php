<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\ImportView */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Import Views', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-view-view">

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
            'CUST_KD',
            'CUST_KD_ALIAS',
            'CUST_NM',
            'KD_BARANG',
            'KD_BARANG_ALIAS',
            'NM_BARANG',
            'SO_QTY',
            'SO_TYPE',
            'POS',
            'KD_DIS',
            'NM_DIS',
            'USER_ID',
            'UNIT_BARANG',
            'UNIT_QTY',
            'UNIT_BERAT',
            'HARGA_PABRIK',
            'HARGA_DIS',
            'HARGA_SALES',
            'HARGA_LG',
            'NOTED:ntext',
            'STATUS',
        ],
    ]) ?>

</div>
