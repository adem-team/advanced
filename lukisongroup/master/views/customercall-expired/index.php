<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\CustomercallExpiredSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customercall Expireds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customercall-expired-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customercall Expired', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'ID_PRIORITASED',
            'ID_DETAIL',
            'CUST_ID',
            'BRG_ID',
            // 'USER_ID',
            // 'TGL_KJG',
            // 'QTY',
            // 'DATE_EXPIRED',
            // 'STATUS',
            // 'CREATE_AT',
            // 'UPDATE_AT',
            // 'CREATE_BY',
            // 'UPDATE_BY',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
