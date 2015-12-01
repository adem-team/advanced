<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\esm\models\KotaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kotas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kota-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Kota', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'CITY_ID',
            'PROVINCE_ID',
            'PROVINCE',
            'TYPE',
            'CITY_NAME',
            // 'POSTAL_CODE',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
