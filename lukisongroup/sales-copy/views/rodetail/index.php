<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\models\esm\ro\RodetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rodetails';
$this->params['breadcrumbs'][] = $this->title;

$this->sideCorp = 'ESM Request Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_esm';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Data Master');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

?>

<div class="rodetail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Rodetail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'KD_RO',
            'KD_BARANG',
            'NM_BARANG',
            'QTY',
            // 'NO_URUT',
            // 'NOTE:ntext',
            // 'STATUS',
            // 'CREATED_AT',
            // 'UPDATED_AT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
