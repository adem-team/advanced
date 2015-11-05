<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\master\Unitbarang */

$this->title = $model->NM_UNIT;
$this->params['breadcrumbs'][] = ['label' => 'Unit Barang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->sideCorp = 'Lukison Group';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'datamaster';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Data Master');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

?>
<div class="unitbarang-view">

    <h1><?= Html::encode($this->title) ?></h1>
	<div style="border-top:1px solid #c6c6c6; ">&nbsp;</div>
	
<?php
	if($model->STATUS == '1'){
		$stat = "Aktif";
	} else {
		$stat = "Tidak Aktif";
	}
 ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		
			'NM_UNIT',
			'SIZE',
			'WIGHT',
			'COLOR',
			'NOTE:ntext',
//			'CREATED_BY',
//			'CREATED_AT',
//			'UPDATED_BY',
//			'UPDATED_AT',
			[
				'label' => 'Status',
				'value' => $stat,
			],
        ],
    ]) ?>


    <p>
        <?= Html::a('<i class="fa fa-pencil"></i>&nbsp;&nbsp;Ubah', ['update', 'ID' => $model->ID, 'KD_UNIT' => $model->KD_UNIT], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash-o"></i>&nbsp;&nbsp;Hapus', ['delete', 'ID' => $model->ID, 'KD_UNIT' => $model->KD_UNIT], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
		
    </p>
</div>
