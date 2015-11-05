<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;

$this->sideCorp = 'Master Data Umum';                  				/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                   				/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Detail Kategori Barang ');	    /* title pada header page */
?>
<div class="kategori-view">

<?php
	if($model->STATUS == '1'){
		$stat = "Aktif";
	} else {
		$stat = "Tidak Aktif";
	}
 ?>
    <p>
<!--         Html::a('<i class="fa fa-pencil"></i>&nbsp;&nbsp;Ubah', ['update', 'ID' => $model->ID,
                                                                    'KD_KATEGORI' => $model->KD_KATEGORI], 
                                                                    ['class' => 'btn btn-primary',
                                                                    'data-toggle'=>"modal",
                                                                    'data-target'=>"#modal-dept",
                                                                    'data-title'=> $model->KD_KATEGORI])?>;                     -->
<!--        Html::a('<i class="fa fa-trash-o"></i>&nbsp;&nbsp;Hapus', ['delete', 'ID' => $model->ID, 'KD_KATEGORI' => $model->KD_KATEGORI], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>-->
    </p>
 
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			'NM_KATEGORI',
			'NOTE:ntext',
			[
				'label' => 'Status',
				'value' => $stat,
			],
        ],
    ]) ?>

   
</div>
<?php


$this->registerJs("
        $('#modal-dept').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            var title = button.data('title') 
            var href = button.attr('href') 
            //modal.find('.modal-title').html(title)
            modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
            $.post(href)
                .done(function( data ) {
                    modal.find('.modal-body').html(data)
                });
            })
    ",$this::POS_READY);
    
    Modal::begin([
        'id' => 'modal-dept',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();



?>
