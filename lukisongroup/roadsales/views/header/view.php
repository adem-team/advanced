<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\roadsales\models\SalesRoadHeader */

$this->title = $model->ROAD_D;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales Road Headers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-road-header-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->ROAD_D], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->ROAD_D], [
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
            'ROAD_D',
            'USER_ID',
            'CASE_ID:ntext',
            'CASE_NOTE:ntext',
            'LAT',
            'LAG',
            'CREATED_BY',
            'CREATED_AT',
        ],
    ]) ?>

</div>
