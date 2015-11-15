<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\front\models\Procurement_item */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Procurement Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procurement-item-view">

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
            'PARENT',
            'SORT_PATENT',
            'PRC_BRG_ID',
            'PRC_BRG_NM',
            'PRC_BRG_SPEK:ntext',
            'PRC_BRG_DCRP:ntext',
            'GROUP',
            'TGL_START',
            'TGL_END',
            'CREATED_BY',
            'UPDATED_BY',
            'UPDATED_TIME',
        ],
    ]) ?>

</div>
