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

	$tabReviewMap=$this->render('_indexReviewMap');
	$tabReviewDetail=$this->render('_indexReviewDetail',[
		'dataProviderHeader1' => $dataProviderHeader1
	]);	
	$tabReviewIssue=$this->render('_indexIssue',[
		'tglpos'=>$tglpos,
		'searchModelIssue' => $searchModelIssue,
		'dataProviderIssue' => $dataProviderIssue
	]);	
	$tabReviewChart=$this->render('_indexSalesMdChart');	
	$tabMonthSummary=$this->render('_indexMonthSummary');
	$tabReviewWeekly=$this->render('_indexWeekly');	

		
	if($tab==0){
		$tab0=true;
		$tab1=false;
		$tab2=false;
		$tab3=false;
		$tab4=false;
		$tab5=false;
	}elseif($tab==1){
		$tab0=false;
		$tab1=true;
		$tab2=false;
		$tab3=false;
		$tab4=false;
		$tab5=false;
	}elseif($tab==2){
		$tab0=false;
		$tab1=false;
		$tab2=true;
		$tab3=false;
		$tab4=false;
		$tab5=false;
	}
	elseif($tab==3){
		$tab0=false;
		$tab1=false;
		$tab2=false;
		$tab3=true;
		$tab4=false;
		$tab5=false;
	}
	elseif($tab==4){
		$tab0=false;
		$tab1=false;
		$tab2=false;
		$tab3=false;
		$tab4=true;
		$tab5=false;
	}
	elseif($tab==5){
		$tab0=false;
		$tab1=false;
		$tab2=false;
		$tab3=false;		
		$tab4=false;
		$tab5=true;
	}
	$items=[
		[
			'label'=>'<i class="fa fa-map-marker fa-2x"></i> Map','content'=>$tabReviewMap,
			'active'=>$tab0,
		],
		[
			'label'=>'<i class="fa fa-list-ol fa-2x"></i> Daily Detail','content'=>$tabReviewDetail,
			'active'=>$tab1,
		],
		[
			'label'=>'<i class="fa fa-eye fa-2x"></i> Issue Memo','content'=>$tabReviewIssue,
			'active'=>$tab2,
		],
		[
			'label'=>'<i class="fa fa-area-chart fa-2x"></i> Chart','content'=>$tabReviewChart,
			'active'=>$tab3,
		],			
		[
			'label'=>'<i class="fa fa-calculator fa-2x"></i>Monthly Summary','content'=>$tabMonthSummary,
			'active'=>$tab4,
		],	 	
		[
			'label'=>'<i class="fa fa-newspaper-o fa-2x"></i> History Stock','content'=>$tabReviewWeekly,
			'active'=>$tab5,
			//'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/master/review-visit/tab-weekly-stock'])]
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


