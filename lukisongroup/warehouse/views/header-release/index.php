<?php

use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use kartik\widgets\Spinner;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                           /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_warehouse';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Warehouse Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title; 

	/**
	 * Warehouse. Recived.
	 * Status 	: Fixed.
	 * Issue	: Rcvd Kode Reff po/suratjalan, attach image.
	 * Author 	: piter novian [ptr.nov@gmail.com]
	 * Update	: 26/01/2017
	*/
	$_indexRcvd=$this->render('_indexRcvd',[
		'searchModelRcvd' => $searchModelRcvd,
        'dataProviderRcvd' => $dataProviderRcvd,
	]);
	/**
	 * Warehouse pengeluaran Barang.
	 * Status 	: Fixed.
	 * Issue	: Generate Facture dan surat jalan, dalam tanggal yang sama.
	 * Author 	: piter novian [ptr.nov@gmail.com]
	 * Update	: 26/01/2017
	*/
	$_indexRelease=$this->render('_indexRelease',[
		'searchModelRelease' => $searchModelRelease,
		'dataProviderRelease' => $dataProviderRelease,
	]);
	
	//Tabs Items
	$itemsEsmWh=[
		[
			'label'=>'
				<span class="fa-stack fa-lg">
				  <i class="fa fa-circle-thin fa-stack-2x"></i>
				  <i class="fa fa-download fa-stack-1x"></i>
				</span> Recive',
				'content'=>$_indexRcvd,
				'active'=>$tab0,
		],
		[
			'label'=>'
				<span class="fa-stack fa-lg">
				  <i class="fa fa-circle-thin fa-stack-2x"></i>
				  <i class="fa fa-upload fa-stack-1x"></i>
				</span> Release',
				'content'=>$_indexRelease,
				'active'=>$tab1,
		],
		/* [
			'label'=>'
				<span class="fa-stack fa-lg">
				  <i class="fa fa-circle-thin fa-stack-2x"></i>
				  <i class="fa fa-upload fa-stack-1x"></i>
				</span> StockCard',
				'content'=>$_indexRelease,
				'active'=>$tab1,
		],
		[
			'label'=>'
				<span class="fa-stack fa-lg">
				  <i class="fa fa-circle-thin fa-stack-2x"></i>
				  <i class="fa fa-upload fa-stack-1x"></i>
				</span> StockOpname',
				'content'=>$_indexRelease,
				'active'=>$tab1,
		] */
	];
	//Tabs Widget
	$tabEsmWarehouse= TabsX::widget([
		'id'=>'tab-esm-warehouse',
		'items'=>$itemsEsmWh,
		'position'=>TabsX::POS_ABOVE,
		'bordered'=>true,
		'encodeLabels'=>false,
	]);
?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="row">
		<div  class="col-lg-12" >		
			<?=$tabEsmWarehouse?>
		</div>
	</div>
</div>