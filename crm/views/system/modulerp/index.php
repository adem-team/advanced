<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->sideCorp = 'PT.Lukisongroup';                        /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'admin';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ERP Modul - Administrator');  /* title pada header page */
?>
<div class="modulerp-index">

    <p>
        <?= Html::a('Create Modulerp', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'MODUL_ID',
            'MODUL_NM',
            'MODUL_DCRP:ntext',
            'MODUL_STS',
            'SORT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
