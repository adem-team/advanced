<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->sideCorp = 'PT.Lukisongroup';                        /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'admin';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ERP Modul - Administrator');  /* title pada header page */
?>
<div class="modulerp-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->MODUL_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->MODUL_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'MODUL_ID',
            'MODUL_NM',
            'MODUL_DCRP:ntext',
            'MODUL_STS',
            'SORT',
        ],
    ]) ?>

</div>
