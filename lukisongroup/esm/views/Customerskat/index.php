<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\esm\models\CustomerskatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customerskats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customerskat-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customerskat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'CUST_KD',
            'CUST_KD_ALIAS',
            'CUST_NM',
            'CUST_GRP',
            'CUST_KTG',
            // 'JOIN_DATE',
            // 'MAP_LAT',
            // 'MAP_LNG',
            // 'PIC',
            // 'ALAMAT:ntext',
            // 'TLP1',
            // 'TLP2',
            // 'FAX',
            // 'EMAIL:email',
            // 'WEBSITE',
            // 'NOTE:ntext',
            // 'NPWP',
            // 'STT_TOKO',
            // 'DATA_ALL',
            // 'CAB_ID',
            // 'CORP_ID',
            // 'CREATED_BY',
            // 'CREATED_AT',
            // 'UPDATED_BY',
            // 'UPDATED_AT',
            // 'STATUS',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
