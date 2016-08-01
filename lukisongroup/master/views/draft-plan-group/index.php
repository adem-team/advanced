<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\DraftPlanGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Draft Plan Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-plan-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Draft Plan Group', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'SCDL_GROUP',
            'TGL_START',
            'SCL_NM',
            'GEO_ID',
            'LAYER_ID',
            // 'DAY_ID',
            // 'DAY_VALUE',
            // 'USER_ID',
            // 'STATUS',
            // 'CREATED_BY',
            // 'CREATED_AT',
            // 'UPDATED_BY',
            // 'UPDATED_AT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
