<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_sales';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


?>
<div class="sechedule-header-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Sechedule Header'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'TGL1',
            'TGL2',
            'SCDL_GROUP',
            'USER_ID',
            // 'NOTE:ntext',
            // 'STATUS',
            // 'CREATE_BY',
            // 'CREATE_AT',
            // 'UPDATE_BY',
            // 'UPDATE_AT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
