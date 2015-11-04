<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->sideCorp = 'ESM Distributor';                  /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_datamaster';                   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Distributor Detail ');    /* title pada header page */

?>
<div class="distributor-view">

     <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'KD_DISTRIBUTOR',
            'NM_DISTRIBUTOR',
            'ALAMAT:ntext',
            'PIC',
            'TLP1',
            'TLP2',
            'FAX',
            'EMAIL:email',
            'WEBSITE',
            'NOTE:ntext',
        ],
    ]) ?>

    <p>
        <?= Html::a('<i class="fa fa-pencil"></i>&nbsp;&nbsp;Ubah', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash-o"></i>&nbsp;&nbsp;Hapus', ['delete', 'id' => $model->ID], [
			'class' => 'btn btn-danger',
			'data' => [
			    'confirm' => 'Are you sure you want to delete this item?',
			    'method' => 'post',
			],
        ]) ?>
    </p>
</div>
