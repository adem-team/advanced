<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->sideCorp = 'Prodak Unit';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Unit Prodak Detail');           /* title pada header page */

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
      <?= Html::a('<i class="fa fa-trash-o"></i>&nbsp;&nbsp;Hapus', ['delete', 'id' => $model->ID], [
			'class' => 'btn btn-danger',
			'data' => [
			    'confirm' => 'Are you sure you want to delete this item?',
			    'method' => 'post',
			],
        ]) ?>
    </p>