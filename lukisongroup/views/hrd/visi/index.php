<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\models\hrd\VisiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Visis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Visi', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'VISIMISI_TITEL',
            'TGL',
            'VISIMISI_ISI:ntext',
            'VISIMISI_DCRPT:ntext',
            // 'VISIMISI_IMG',
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
