<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\models\widget\IssueprojectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Issueprojects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issueproject-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Issueproject', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'PARENT',
            'ISSUE_NM',
            'ISSUE_DESC:ntext',
            'PRIORITY',
            // 'CLOSE_DATETIME',
            // 'USER_CREATED',
            // 'STATUS',
            // 'CORP_ID',
            // 'DEP_ID',
            // 'OPEN_DATETIME',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
