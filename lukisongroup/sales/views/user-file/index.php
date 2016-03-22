<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\sales\models\UserFileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-file-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User File', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'USER_ID',
            'FILE_PATH',
            'FILE_NM',
            'STATUS',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
