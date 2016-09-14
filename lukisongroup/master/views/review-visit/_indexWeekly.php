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

	/* $tabReviewDetailStock=$this->render('_indexWeeklyStock',[
		'dataProvider'=>$aryDataStock,	
		'searchModelStock'=>$searchModelStock,				
		'aryProviderDetailStock'=>$aryProviderDetailStock,		
		'aryProviderHeaderStock'=>$aryProviderHeaderStock	
	]);	 */
		
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
			'label'=>' Weekly Detail Stock','content'=>'',//$tabReviewDetailStock,			
			'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/master/review-visit/tab-weekly-stock'])],
			'active'=>true,			
		],
		[
			'label'=>' Weekly Detail Request','content'=>'',
			'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/master/review-visit/tab-weekly-ro'])],
		],		
		[
			'label'=>' Weekly Detail Reture','content'=>'',
			//'active'=>$tab2,
		],	 	
	];

	$tabReviewVisitWeekly= TabsX::widget([
		'id'=>'weekly-tab',
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'bordered'=>true,
		'encodeLabels'=>false,
	]);	
		
?>
<div class="row">
	<div  class="col-lg-12" >		
		<?=$tabReviewVisitWeekly?>
	</div>
</div>


