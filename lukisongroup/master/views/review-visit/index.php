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
use ptrnov\fusionchart\ChartAsset;
ChartAsset::register($this);

$this->sideCorp = 'PT.Effembi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_customers';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Produk');          				/* title pada header page */
$this->params['breadcrumbs'][] = $this->title;   

	$tabReviewDetail=$this->render('_indexReviewDetail',[
		'dataProviderHeader1' => $dataProviderHeader1
	]);	
	$tabReviewWeekly=$this->render('_indexWeekly');	
		
	if($tab==0){
		$tab0=true;
		$tab1=false;
		$tab2=false;
		$tab3=false;
		$tab4=false;
	}elseif($tab==1){
		$tab0=false;
		$tab1=true;
		$tab2=false;
		$tab3=false;
		$tab4=false;
	}elseif($tab==2){
		$tab0=false;
		$tab1=false;
		$tab2=true;
		$tab3=false;
		$tab4=false;
	}
	
	$items=[
		[
			'label'=>'<i class="fa fa-list-ol fa-2x"></i> Daily Detail','content'=>$tabReviewDetail,
			'active'=>$tab0,
		],
		[
			'label'=>'<i class="fa fa-newspaper-o fa-2x"></i> Weekly Detail','content'=>$tabReviewWeekly,
			'active'=>$tab1,
			//'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/master/review-visit/tab-weekly-stock'])]
		],		
		[
			'label'=>'<i class="fa fa-calculator fa-2x"></i>Monthly Summary','content'=>'',//$tabMonthSummary,
			'active'=>$tab2,
		],	 	
	];

	$tabReviewVisit= TabsX::widget([
		'id'=>'tab-project-id',
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'bordered'=>true,
		'encodeLabels'=>false,
	]);	
		
?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt">
<div class="row">
	<div  class="col-lg-12" >
		
		<?=$tabReviewVisit?>
		</div>
	</div>
</div>


