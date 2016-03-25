<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\TempData */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Temp Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="temp-data-view">

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
            'CUST_NM_ALIAS',
            'ITEM_ID',
            'ITEM_ID_ALIAS',
            'ITEM_NM',
            'ITEM_NM_ALIAS',
            'QTY_PCS',
            'QTY_UNIT',
            'DIS_KD',
            'DIS_NM',
            'SO_TYPE',
            'POS',
            'USER_ID',
            'NOTED:ntext',
            'STATUS',
        ],
    ]) ?>

</div>
