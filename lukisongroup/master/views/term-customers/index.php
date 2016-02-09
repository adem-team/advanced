<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\TermcustomersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Termcustomers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="termcustomers-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Termcustomers', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID_TERM',
            'NM_TERM',
            'CUST_KD',
            'CUST_NM',
            'CUST_SIGN',
            // 'PRINCIPAL_KD',
            // 'PRINCIPAL_NM',
            // 'PRINCIPAL_SIGN',
            // 'DIST_KD',
            // 'DIST_NM',
            // 'DIST_SIGN',
            // 'DCRP_SIGNARURE:ntext',
            // 'PERIOD_START',
            // 'PERIOD_END',
            // 'TARGET_TEXT:ntext',
            // 'TARGET_VALUE',
            // 'RABATE_CNDT:ntext',
            // 'GROWTH',
            // 'TOP:ntext',
            // 'STATUS',
            // 'CREATED_BY',
            // 'CREATED_AT',
            // 'UPDATE_BY',
            // 'UPDATE_AT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
