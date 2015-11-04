<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use lukisongroup\models\esm\Barang;

$this->sideCorp = 'ESM Prodak';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_datamaster';                   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Prodak');           /* title pada header page */

?>


<div class="barang-index">
    <?php
		$gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
			[
				/*Author -ptr.nov- image*/
               'attribute' => 'Gambar',
               'format' => 'html', //'format' => 'image',
               'value'=>function($data){
                            return Html::img(Yii::$app->urlManager->baseUrl.'/upload/barangesm/' . $data->IMAGE, ['width'=>'40']);
                        },
            ],  
			
            'KD_BARANG',
			'NM_BARANG',
			'nmdbtr',
			'unitbrg',
			'HPP', 
			'HARGA',
			'tipebrg', 
			'nmkategori', 
		
		
			[
				'format' => 'raw',
				'value' => function ($model) {
					if ($model->STATUS == 1) {
						return '<i class="fa fa-check fa-lg ya" style="color:blue;" title="Aktif"></i>';
					} else if ($model->STATUS == 0) {
						return '<i class="fa fa-times fa-lg no" style="color:red;" title="Tidak Aktif" ></i>';
					} 
				},
			], 
            ['class' => 'yii\grid\ActionColumn'],
        ]; 
	
	
	echo Yii::$app->gv->grview($gridColumns,$dataProvider,$searchModel, 'Barang ESM', 'barang-esm','');
	
	?>
</div>

<p>
<i class="fa fa-check fa-sm" style="color:blue;" title="Aktif"></i> Aktif  &nbsp;&nbsp;&nbsp;&nbsp;
<i class="fa fa-times fa-sm" style="color:red;" title="Tidak Aktif" ></i> Tidak Aktif
</p>