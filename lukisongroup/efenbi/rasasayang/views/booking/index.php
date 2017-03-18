<?php
use kartik\helpers\Html;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use kartik\widgets\Spinner;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use yii\web\View;

use lukisongroup\efenbi\rasasayang\models\TransaksiType;
use lukisongroup\efenbi\rasasayang\models\Store;

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'efenbi_rasasayang';                                     		/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Marketing Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;  
// $this->registerJs($this->render('modal_item.js'),View::POS_READY);
// echo $this->render('modal_item'); //echo difinition

	$aryStt= [
	  ['STATUS' => 0, 'STT_NM' => 'Disable'],		  
	  ['STATUS' => 1, 'STT_NM' => 'Enable']
	];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');
	$valType = ArrayHelper::map(TransaksiType::find()->all(), 'ID', 'TYPE_NM');
	$valStore = ArrayHelper::map(Store::find()->all(), 'OUTLET_NM', 'OUTLET_NM');
	
	$gvBookingLates=$this->render('_indexLates',[
		'dataProvider' => $dataProvider,
		'searchModel' => $searchModel,
	]);
	$gvBookingNew=$this->render('_indexNew',[
		'dataProvider' => $dataProvider,
		'searchModel' => $searchModel,
	]);
?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="col-xs-12 col-sm-6 col-dm-6 col-lg-6" style="font-family: tahoma ;font-size: 8pt;">
		<div class="row" style="padding-right:5px" style="font-family: tahoma ;font-size: 8pt;">
			<?=$gvBookingLates?>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 col-dm-6 col-lg-6" style="font-family: tahoma ;font-size: 8pt;">
		<div class="row" style="padding-right:5px" style="font-family: tahoma ;font-size: 8pt;">
			<?=$gvBookingNew?>
		</div>
	</div>
</div>

