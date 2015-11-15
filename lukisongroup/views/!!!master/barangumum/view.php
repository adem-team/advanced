<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use lukisongroup\models\master\Barangumum;
use lukisongroup\models\hrd\Corp;
use yii\bootstrap\Modal;

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

	<?php if($model->IMAGE == null)
			{ 			
				$gmbr = "df.jpg";

			} 
			else { 
				
				$gmbr = $model->IMAGE;

				 }  
				?>
            
            
            
         
    <p>
<!--        <Html::a('<i class="fa fa-pencil"></i>&nbsp;&nbsp;Ubah', ['update', 'ID' => $model->ID, 'KD_BARANG' => $model->KD_BARANG], 
                                                                           ['class' => 'btn btn-primary'],
                                                                                                        '') ?>-->
<!--//                                                                                [
//                                                                                    'data-toggle'=>"modal",
//                                                                                    'data-target'=>"#barangumum",													
//                                                                                    'data-title'=> $model->ID,-->
                                                                                                              
<!--         Html::a('<i class="fa fa-trash-o"></i>&nbsp;&nbsp;Hapus', ['delete', 'ID' => $model->ID, 'KD_BARANG' => $model->KD_BARANG], [
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
				// 'value'=>Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$model->IMAGE,
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


    

        </div>
    </div>
    
</
<?php

$this->registerJs("
        $('#barangumum').on('show.bs.modal', function (event) {
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
    
//    Modal::begin([
//        'id' => 'barangumum',
//        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
//    ]);
//    Modal::end();
            
?>

