<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use lukisongroup\models\esm\ro\Requestorder;
use lukisongroup\models\esm\ro\RequestorderSearch;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\ro\Requestorder */


$this->sideCorp = 'ESM Request Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_esm';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Data Master');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

?>

<div class="requestorder-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'KD_RO',
            'NOTE:ntext',
            'ID_USER',
            'KD_CORP',
            'KD_CAB',
            'KD_DEP',
            'STATUS',
            'CREATED_AT',
            'UPDATED_ALL',
            'DATA_ALL:ntext',
        ],
    ]) ?>

</div>