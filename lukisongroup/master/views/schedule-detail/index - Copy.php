<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\ScheduledetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Scheduledetails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scheduledetail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Scheduledetail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'TGL',
            'CUST_ID',
            'USER_ID',
            'SCDL_GROUP',
            // 'LAT',
            // 'LAG',
            // 'RADIUS',
            // 'NOTE:ntext',
            // 'STATUS',
            // 'CREATE_BY',
            // 'CREATE_AT',
            // 'UPDATE_BY',
            // 'UPDATE_AT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
