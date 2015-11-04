<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->sideCorp = 'ESM Prodak Unit';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_datamaster';                   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Unit Prodak Detail');           /* title pada header page */

?>
<div class="unitbarang-view">

     <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'ID',
            'KD_UNIT',
            'NM_UNIT',
            'QTY',
            'SIZE',
            'WEIGHT',
            'COLOR',
            'NOTE:ntext',
   //         'STATUS',
  //          'CREATED_BY',
 //           'CREATED_AT',
//            'UPDATED_AT',
        ],
    ]) ?>

</div>

    <p>
        <?= Html::a('<i class="fa fa-pencil"></i>&nbsp;&nbsp;Ubah', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
    </p>