<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\sales\models\TempDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Temp Datas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="temp-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Temp Data', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'TGL',
            'CUST_KD',
            'CUST_KD_ALIAS',
            'CUST_NM',
            // 'CUST_NM_ALIAS',
            // 'ITEM_ID',
            // 'ITEM_ID_ALIAS',
            // 'ITEM_NM',
            // 'ITEM_NM_ALIAS',
            // 'QTY_PCS',
            // 'QTY_UNIT',
            // 'DIS_KD',
            // 'DIS_NM',
            // 'SO_TYPE',
            // 'POS',
            // 'USER_ID',
            // 'NOTED:ntext',
            // 'STATUS',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
