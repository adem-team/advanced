<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->sideCorp = 'Modul HRM';                                   	 /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_modul';                                       /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'DetailView Sub Department');           /* title pada header page */

?>
<div class="deptsub-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->DEP_SUB_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->DEP_SUB_ID], [
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
            'DEP_SUB_ID',
            'DEP_ID',
            'DEP_SUB_NM',
            'DEP_SUB_STS',
            'DEP_SUB_AVATAR',
            'DEP_SUB_DCRP:ntext',
            'SORT',
        ],
    ]) ?>

</div>
