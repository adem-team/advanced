<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\hrd\models\\Kar_fingerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kar Fingers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kar-finger-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Kar Finger', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'NO_URUT',
            'TerminalID',
            'KAR_ID',
            'FingerPrintID',
            'FingerTmpl:ntext',
            // 'UPDT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
