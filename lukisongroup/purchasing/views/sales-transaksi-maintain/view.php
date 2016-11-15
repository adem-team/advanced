<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\purchasing\models\salesmanorder\SoT2 */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'So T2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-t2-view">

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
            'NOTED:ntext',
            'HARGA_LG',
            'STATUS',
            'WAKTU_INPUT_INVENTORY',
            'ID_GROUP',
            'KODE_REF',
            'SUBMIT_QTY',
            'SUBMIT_PRICE',
        ],
    ]) ?>

</div>
