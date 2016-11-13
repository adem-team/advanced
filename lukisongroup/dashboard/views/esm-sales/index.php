<?php
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use app\models\hrd\Dept;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;
use lukisongroup\assets\AppAssetDahboardEsmSales;
AppAssetDahboardEsmSales::register($this);

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_sales';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/
?>
<?php
	
	/**
	 * Chart Distributor PO.
	 * Status 	: Fixed.
	 * Issue	: PO Online/ import PO manual / Po MTI/NKA
	 * Author piter novian [ptr.nov@gmail.com]
	*/
	$_indexDistibutorPo=$this->render('_indexDistibutorPo');
	
	/**
	 * Chart NKA PO.
	 * Status 	: Fixed.
	 * Issue	: PO Online/ import PO detail. NKA
	 * Author piter novian [ptr.nov@gmail.com]
	*/
	$_indexNKAPo=$this->render('_indexNKA');

	/**
	 * Import Frekuensi.
	 * Status 	: Fixed.
	 * Issue	: PO Online/ import PO detail. NKA
	 * Author piter novian [ptr.nov@gmail.com]
	*/
	$_indexFrequency=$this->render('_indexFrequency');
		
	if($tab==0){
		$tab0=true;
		$tab1=false;
		$tab2=false;
	}elseif($tab==1){
		$tab0=false;
		$tab1=true;
		$tab2=false;
	}elseif($tab==2){
		$tab0=false;
		$tab1=false;
		$tab2=true;
	}
	$items=[
		[
			'label'=>'<i class="fa fa-map-marker fa-2x"></i> PO Sales Distributor','content'=>$_indexDistibutorPo,
			'active'=>$tab0,
		],
		[
			'label'=>'<i class="fa fa-list-ol fa-2x"></i> PO Sales NKA','content'=>$_indexNKAPo,
			'active'=>$tab1,
		], 
		[
			'label'=>'<i class="fa fa-list-ol fa-2x"></i> Import Frequency','content'=>$_indexFrequency,
			'active'=>$tab2,
		], 	
	];

	$tabSalesDashboard= TabsX::widget([
		'id'=>'tab-sales-dashboard-id',
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'bordered'=>true,
		'encodeLabels'=>false,
	]);	
		
?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt">
<div class="row">
	<div  class="col-lg-12" >
		
		<?=$tabSalesDashboard?>
		</div>
	</div>
</div>