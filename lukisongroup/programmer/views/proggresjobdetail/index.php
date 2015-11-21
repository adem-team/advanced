<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProggresjobdetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proggresjobdetails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proggresjobdetail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Proggresjobdetail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'proggresjobdetail_id',
            'progress_id',
            'created_date',
            'keterangan',
            'pic',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
