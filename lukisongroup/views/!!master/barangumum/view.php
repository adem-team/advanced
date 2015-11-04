<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use lukisongroup\models\master\Barangumum;
use lukisongroup\models\hrd\Corp;

$this->sideCorp = 'Master Data Umum';                  	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                   	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Barang Detail ');  /* title pada header page */

?>
<div class="barangumum-view">
 
    <div class="row"> 
        <div class="col-md-8" style="margin:10px;"> 

<?php
	$sts = $model->STATUS;
	if($sts == 1){
		$stat = 'Aktif';
	} else {
		$stat = 'Tidak Aktif';
	}
?>

	<?php if($model->IMAGE == null){ $gmbr = "df.jpg"; } else { $gmbr = $model->IMAGE; }  ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

			'KD_BARANG',
			[
				'label' => 'Group Perusahaan',
				'value' => $model->corp->CORP_NM,
			],
			'NM_BARANG',
			[
				'label' => 'Type Barang',
				'value' => $model->type->NM_TYPE,
			],
			[
				'label' => 'Kategori',
				'value' => $model->kategori->NM_KATEGORI,
			],
			
			[
				'attribute'=>'photo',
				'value'=>Yii::$app->urlManager->baseUrl.'/upload/barangumum/'.$gmbr,
				'format' => ['image',['width'=>'150','height'=>'150']],
			],
			[
				'label' => 'Unit',
				'value' => $model->unit->NM_UNIT,
			],
			
			[
				'label' => 'Suplier',
				'value' => $model->suplier->NM_SUPPLIER,
			],
			
//			'KD_DISTRIBUTOR',
			'PARENT',
			'HPP',
			'HARGA',
			'BARCODE',
			'NOTE:ntext',
			
			[
				'label' => 'Status',
				'value' => $stat,
			],
        ],
    ]) ?>


    <p>
        <?= Html::a('<i class="fa fa-pencil"></i>&nbsp;&nbsp;Ubah', ['update', 'ID' => $model->ID, 'KD_BARANG' => $model->KD_BARANG], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash-o"></i>&nbsp;&nbsp;Hapus', ['delete', 'ID' => $model->ID, 'KD_BARANG' => $model->KD_BARANG], [
			'class' => 'btn btn-danger',
			'data' => [
			    'confirm' => 'Are you sure you want to delete this item?',
			    'method' => 'post',
			],
        ]) ?>
    </p>

        </div>
    </div>
</div>

