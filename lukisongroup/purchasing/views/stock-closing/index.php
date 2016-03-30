<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Json;
use yii\web\Request;
use kartik\daterange\DateRangePicker;



$this->params['breadcrumbs'][] = $this->title;

$this->sideCorp = 'Purchasing Stock';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'purchasing_stock';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Purchase Stock');      /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;               /* belum di gunakan karena sudah ada list sidemenu, on plan next*/
?>

<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
    <div  class="row" style="margin-top:15px">
        <div class="col-sm-12 col-md-12 col-lg-12">
			<?php
				echo GridView::widget([
					'dataProvider' => $dataProvider,
					'filterModel' => $searchModel,
					'columns' => [
						['class' => 'yii\grid\SerialColumn'],

						'ID',
						'TGL',
						'TYPE',
						'KD_JUST',
						'KD_DEPT',
						// 'PIC',
						// 'ID_BARANG',
						// 'NM_BARANG',
						// 'UNIT',
						// 'UNIT_NM',
						// 'UNIT_QTY',
						// 'UNIT_WIGHT',
						// 'QTY',
						// 'NOTE:ntext',
						// 'STATUS',
						// 'CREATE_BY',
						// 'CREATE_AT',
						// 'UPDATE_BY',
						// 'UPDATE_AT',

						['class' => 'yii\grid\ActionColumn'],
					],
				]);
			?>
		</div>
	</div>
</div>
