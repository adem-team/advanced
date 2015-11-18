<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\models\hrd\RegulasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Regulasis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regulasi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Regulasi', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'RGTR_TITEL',
            'TGL',
            'RGTR_ISI:ntext',
            'RGTR_DCRPT:ntext',
            // 'SET_ACTIVE',
            // 'CORP_ID',
            // 'DEP_ID',
            // 'DEP_SUB_ID',
            // 'GF_ID',
            // 'SEQ_ID',
            // 'JOBGRADE_ID',
            // 'CREATED_BY',
            // 'UPDATED_BY',
            // 'UPDATED_TIME',
            // 'STATUS',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
