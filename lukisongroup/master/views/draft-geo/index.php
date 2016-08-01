<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\DraftGeoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Draft Geos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-geo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Draft Geo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'GEO_ID',
            'GEO_NM',
            'GEO_DCRIP:ntext',
            'CUST_MAX_NORMAL',
            'CUST_MAX_LAYER',
            // 'START_LAT',
            // 'START_LONG',
            // 'STATUS',
            // 'CREATE_BY',
            // 'CREATE_AT',
            // 'UPDATE_BY',
            // 'UPDATE_AT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
