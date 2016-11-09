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
	 * Import Data Gudang.
	 * Status 	: Fixed.
	 * Issue	: PO Online/ import PO manual / Po MTI/NKA
	 * Author piter novian [ptr.nov@gmail.com]
	*/
	$_indexImportGudang=$this->render('_indexImportGudang',[
		/*VIEW ARRAY FILE*/
			'getArryFile'=>$getArryFile,
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
	$_indexGudangLatestImport=$this->render('_indexImportGudangLatestImport',[
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
	$_indexGudangDataAll=$this->render('_indexImportGudangdataAll',[
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
			'label'=>'<i class="fa fa-sign-in fa-2x"></i> Import Gudang','content'=>$_indexImportGudang,
			'active'=>$tab0,
		],
		[
			'label'=>'<i class="fa fa-cubes fa-2x"></i> Latest Import Data','content'=>$_indexGudangLatestImport,
			'active'=>$tab1,
		], 	
		[
			'label'=>'<i class="fa fa-database fa-2x"></i> History Data','content'=>$_indexGudangDataAll,
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
	<div  class="col-lg-12" >
		
		<?=$tabSalesImport?>
		</div>
	</div>
	<?php
		// Modal::begin([
		// 'id' => 'error-msg-stockgudang',
		// 'header' => 'WARNING',
		// 'size' => Modal::SIZE_SMALL,
		// 'headerOptions'=>[
			// 'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
		// ]
	// ]);
		// echo "<div>Check Excel Data<br>";
		// echo "1.Pastikan Format Excel sudah sesuai.</br>";
		// echo "2.Pastikan Column STATUS='stock-gudang' </br>";
		// echo "</div>";
	// Modal::end();
	?>
</div>