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

/* TABLE CLASS DEVELOPE -> |DROPDOWN,PRIMARYKEY-> ATTRIBUTE */
use app\models\hrd\Dept;

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_sales';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

/**
	 * Import Data Salespo.
	 * Status 	: Fixed.
	 * Issue	: PO Online/ import PO manual / Po MTI/NKA
	 * Author piter novian [ptr.nov@gmail.com]
	*/
	$_indexImportSalespo=$this->render('_indexImportSalespo',[
		/*VIEW ARRAY FILE*/
			'dataProviderTemp'=>$dataProviderTemp,
			'fileName'=>$fileName,
			'gvColumnAryFile'=>$gvColumnAryFile,
			/*GRID VALIDATE*/
			'gvValidateColumn'=>$gvValidateColumn,
			//'gvValidateArrayDataProvider'=>$this->gvValidateArrayDataProvider(),
			'gvValidateArrayDataProvider'=>$gvValidateArrayDataProvider,
			'searchModelValidate'=>$searchModelValidate,
			'modelFile'=>$modelFile,
			/*VIEW IMPORT*/
			'gvRows'=>$gvRows,
			'searchModelViewImport'=>$searchModelViewImport,
			'dataProviderViewImport'=>$dataProviderViewImport	
	]);
	
	/**
	 * List Latest data Import.
	 * Status 	: Fixed.
	 * Issue	: PO Online/ import PO detail. NKA
	 * Author piter novian [ptr.nov@gmail.com]
	*/
	$_indexSalespoLatestImport=$this->render('_indexImportSalespoLatestImport',[
		'gvRows'=>$gvRows,
		'searchModelViewImport'=>$searchModelViewImport,
		'dataProviderViewImport'=>$dataProviderViewImport	
	]);

	/**
	 * List data Import.
	 * Status 	: Fixed.
	 * Issue	: PO Online/ import PO detail. NKA
	 * Author piter novian [ptr.nov@gmail.com]
	*/
	$_indexSalespoDataAll=$this->render('_indexImportSalespodataAll',[
		'gvRows'=>$gvRows,
		'searchModelViewImport'=>$searchModelViewImport,
		'dataProviderAllDataImport'=>$dataProviderAllDataImport	
	]);

		
	if($tab==0){
		$tab0=true;
		$tab1=false;
	}elseif($tab==1){
		$tab0=false;
		$tab1=true;
	}
	$items=[
		[
			'label'=>'<i class="fa fa-sign-in fa-2x"></i> Import Salespo','content'=>$_indexImportSalespo,
			'active'=>$tab0,
		],
		[
			'label'=>'<i class="fa fa-cubes fa-2x"></i> Latest Import Data','content'=>$_indexSalespoLatestImport,
			'active'=>$tab1,
		], 	
		[
			'label'=>'<i class="fa fa-database fa-2x"></i> History Data','content'=>$_indexSalespoDataAll,
			'active'=>$tab1,
		], 	
	];

	$tabSalesImport= TabsX::widget([
		'id'=>'tab-sales-import-id',
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'bordered'=>true,
		'encodeLabels'=>false,
	]);	
		
?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt">
<div class="row">
	<div  class="col-lg-12">		
		<?=$tabSalesImport?>
		</div>
	</div>
</div>