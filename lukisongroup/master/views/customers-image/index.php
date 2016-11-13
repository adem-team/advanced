<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\CustomersImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customers-image-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customers Image', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'CUST_KD',
            'IMG_NM_BASE64:ntext',
            'STATUS',
            'CREATE_BY',
            // 'CREATE_AT',
            // 'UPDATE_BY',
            // 'UPDATE_AT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
