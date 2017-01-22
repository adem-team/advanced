<?php

use kartik\helpers\Html;
use kartik\tabs\TabsX;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use ptrnov\fusionchart\Chart;
use ptrnov\fusionchart\ChartAsset;
use lukisongroup\assets\Profile;
Profile::register($this);
ChartAsset::register($this);

$this->sideCorp = 'PT.Sarana Sinar Surya';                              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = '';                                                   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Reporting - PT. Sarana Sinar Surya');     /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                          /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

	$_indexSalesDay=$this->render('_indexSalesDay',[
		'totalGrandHari'=>$totalGrandHari,
		'totalTransHari'=>$totalTransHari,
		'totalMember'=>$totalMember
	]);
	$_indexSalesWeekHour=$this->render('_indexSalesWeekHour');
	$_indexSalesWeek=$this->render('_indexSalesWeek');	
	$_indexTop5MemberTenanMonth=$this->render('_indexTop5MemberTenanMonth',[
		'top5MemberMonth'=>$top5MemberMonth,
		'top5TenantMonth'=>$top5TenantMonth,
		'top5MemberNew'=>$top5MemberNew
	]);
	$_indexSalesYear=$this->render('_indexSalesYear');	
	$_indexTop5TenanMonthYear=$this->render('_indexTop5TenanMonthYear',[
		'top5TenantMonth'=>$top5TenantMonth,
		'top5TenantNew'=>$top5TenantNew,
		'top5TenantYear'=>$top5TenantYear,
	]);
	$_indexTop5MemberMonthYear=$this->render('_indexTop5MemberMonthYear',[
		'top5MemberMonth'=>$top5MemberMonth,
		'top5MemberYear'=>$top5MemberYear,
		'top5MemberNew'=>$top5MemberNew,
	]);
	
	$items=[
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Sales-Foodtown','content'=>
			$_indexSalesDay.
			$_indexSalesWeekHour.
			$_indexSalesWeek.						
			$_indexSalesYear.
			$_indexTop5MemberTenanMonth,
			'active'=>true,			
		],		
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Tenent','content'=>$_indexTop5TenanMonthYear,
			//active'=>true
		],
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Member','content'=>$_indexTop5MemberMonthYear,
			//active'=>true
		],
	];	


	$tabSss= TabsX::widget([
			'items'=>$items,
			'position'=>TabsX::POS_ABOVE,
			'height'=>TabsX::SIZE_TINY,
			'bordered'=>true,
			'encodeLabels'=>false,
			'height'=>'450px',
			'align'=>TabsX::ALIGN_LEFT,						
		]);											
?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt; padding-top:-150px">
		<div class="row" >
			<?=$tabSss?>			
		</div>

</div>