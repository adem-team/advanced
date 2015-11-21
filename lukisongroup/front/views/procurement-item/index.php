<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\front\models\Procurement_itemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procurement Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procurement-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Procurement Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'PARENT',
            'SORT_PATENT',
            'PRC_BRG_ID',
            'PRC_BRG_NM',
            // 'PRC_BRG_SPEK:ntext',
            // 'PRC_BRG_DCRP:ntext',
            // 'GROUP',
            // 'TGL_START',
            // 'TGL_END',
            // 'CREATED_BY',
            // 'UPDATED_BY',
            // 'UPDATED_TIME',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
