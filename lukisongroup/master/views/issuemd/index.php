<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\IssuemdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Issuemds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issuemd-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Issuemd', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'ID_DETAIL',
            'KD_CUSTOMER',
            'NM_CUSTOMER',
            'ID_USER',
            // 'NM_USER',
            // 'ISI_MESSAGES:ntext',
            // 'TGL',
            // 'STATUS',
            // 'CREATE_BY',
            // 'CREATE_AT',
            // 'UPDATE_BY',
            // 'UPDATE_AT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
