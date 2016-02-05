<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\Sot2 */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Sot2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sot2-view">

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
            'CUST_KD_ALIAS',
            'KD_DIS',
            'USER_ID',
            'KD_BARANG_ALIAS',
            'NM_BARANG',
            'UNIT_BARANG',
            'UNIT_QTY',
            'UNIT_BERAT',
            'SO_TYPE',
            'SO_QTY',
            'HARGA_PABRIK',
            'HARGA_DIS',
            'HARGA_SALES',
            'NOTED:ntext',
            'HARGA_LG',
        ],
    ]) ?>

</div>
