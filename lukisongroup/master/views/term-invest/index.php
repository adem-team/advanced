<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\TerminvestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Terminvests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="terminvest-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Terminvest', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'INVES_TYPE',
            'STATUS',
            'KETERANGAN:ntext',
            'CREATE_BY',
          

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
