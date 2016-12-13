<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\roadsales\models\SalesRoadHeaderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->sideCorp = 'PT.Effembi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'sales_road';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - SALES ROAD');          				/* title pada header page */
$this->params['breadcrumbs'][] = $this->title; 
?>
<div class="sales-road-header-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Sales Road Header'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ROAD_D',
            'USER_ID',
            'CASE_ID:ntext',
            'CASE_NOTE:ntext',
            'LAT',
            // 'LAG',
            // 'CREATED_BY',
            // 'CREATED_AT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
