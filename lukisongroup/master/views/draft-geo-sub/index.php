<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\DraftGeoSubSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Draft Geo Subs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-geo-sub-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Draft Geo Sub', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'GEO_SUB',
            'GEO_ID',
            'GEO_DCRIP:ntext',
            'CUST_MAX_NORMAL',
            // 'CUST_MAX_LAYER',
            // 'START_LAT',
            // 'START_LONG',
            // 'CITY_ID',
            // 'STATUS',
            // 'CREATE_BY',
            // 'CREATE_AT',
            // 'UPDATE_BY',
            // 'UPDATE_AT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
