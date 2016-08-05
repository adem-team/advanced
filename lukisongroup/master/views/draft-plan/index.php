<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use lukisongroup\master\models\DraftPlan;
Use ptrnov\salesforce\Jadwal;
use kartik\tabs\TabsX;
use yii\widget\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\DraftPlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->sideCorp = 'PT.Effembi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_customers';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Produk');          				/* title pada header page */
$this->params['breadcrumbs'][] = $this->title;   

	$newDraftPlan=$this->render('_indexDraftPlan',[
		'searchModel' => $searchModel,
		'dataProvider' => $dataProvider,
	]);
	$MaintainPlan=$this->render('_indexMaintainPlan',[
		'searchModelMaintain' =>$searchModelMaintain,
		'dataProviderMaintain' =>$dataProviderMaintain,
	]);
	$salesPlan='';
	
	if($tab==0){
		$tab0=true;
		$tab1=false;
	}elseif($tab==1){
		$tab0=false;
		$tab1=true;
	}
	
	$items=[
		[
			'label'=>'<i class="fa fa-wrench fa-2x"></i> Plan Draft','content'=>$newDraftPlan,
			'active'=>$tab0,
		],
		[
			'label'=>'<i class="fa fa-braille fa-2x"></i> Plan Detail Maintain','content'=>$MaintainPlan,
			'active'=>$tab1,
		],
		[
			'label'=>'<i class="fa fa-user-plus	 fa-2x"></i> Salesman Planned','content'=>$salesPlan,
			'active'=>$tab1,
		]
	];

	$tabSchedulingSales= TabsX::widget([
		'id'=>'sales-plan-scdl',
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'bordered'=>true,
		'encodeLabels'=>false,
	]);	
		
?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div  class="row" style="margin-top:0px"> 
		<div  class="col-lg-12">
			<?=$tabSchedulingSales?>
		</div>
	</div>
</div>
