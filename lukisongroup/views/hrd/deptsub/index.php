<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->sideCorp = 'Modul HRM';                            /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_modul';                            /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Sub Department');           /* title pada header page */

?>
<div class="deptsub-index">

    
    <p>
        <?= Html::a('Create Sub Department', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'DEP_SUB_ID',
            'DEP_ID',
            'DEP_SUB_NM',
            'DEP_SUB_STS',
            'DEP_SUB_AVATAR',
            // 'DEP_SUB_DCRP:ntext',
            // 'SORT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
