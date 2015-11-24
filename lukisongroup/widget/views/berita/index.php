<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\widget\models\BeritaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Beritas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="berita-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Berita', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'KD_BERITA',
            'JUDUL',
            'ISI:ntext',
            'KD_CORP',
            // 'KD_CAB',
            // 'KD_DEP',
            // 'DATA_PICT:ntext',
            // 'DATA_FILE:ntext',
            // 'STATUS',
            // 'CREATED_ATCREATED_BY',
            // 'CREATED_BY',
            // 'UPDATE_AT',
            // 'DATA_ALL:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
