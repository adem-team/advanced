<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\hrd\models\MachineSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Machines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Machine', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'TerminalID',
            'MESIN_NM',
            'MESIN_SN',
            'CAB_ID',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
