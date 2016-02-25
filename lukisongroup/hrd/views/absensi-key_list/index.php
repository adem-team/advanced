<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\hrd\models\Key_listSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Key Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="key-list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Key List', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'FunctionKey',
            'FunctionKeyNM',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
