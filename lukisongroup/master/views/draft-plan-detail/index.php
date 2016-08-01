<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\DraftPlanDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Draft Plan Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-plan-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Draft Plan Detail', ['create'], ['class' => 'btn btn-success']) ?>
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
            // 'NOTE:ntext',
            // 'LAT',
            // 'LAG',
            // 'RADIUS',
            // 'STATUS',
            // 'CREATE_BY',
            // 'CREATE_AT',
            // 'UPDATE_BY',
            // 'UPDATE_AT',
            // 'CHECKIN_TIME',
            // 'CHECKOUT_LAT',
            // 'CHECKOUT_LAG',
            // 'CHECKOUT_TIME',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
