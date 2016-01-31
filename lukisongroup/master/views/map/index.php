<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\MapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Maps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Map', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'LAT',
            'LAG',
            'RADIUS',
            'CREATED_BY',
            // 'CREATED_AT',
            // 'CUST_ID',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
