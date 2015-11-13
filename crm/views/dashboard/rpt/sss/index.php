<?php

use kartik\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;

$this->sideCorp = 'PT.Sarana Sinar Surya';                              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = '';                                                   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Reporting - PT. Sarana Sinar Surya');     /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                          /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


?>
<div class="panel panel-default">
    
			<?php
			
				$content1='test ahhhhhhhhhhhhhhhhhhh';
				$items=[
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> Prodak','content'=>$content1,
						'active'=>true,
						
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> Tenant','content'=>'asdasd',//$content1,
						//active'=>true
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> SDM','content'=>'asdasd',//$content1,
						//active'=>true
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> Seles Order','content'=>'asdasd',//$content1,
						//active'=>true
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> Customer','content'=>'asdasd',//$content1,
						//active'=>true
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> Asset','content'=>'asdasd',//$content1,
						//active'=>true
					],
				];	
			
			
				echo TabsX::widget([
						'items'=>$items,
						'position'=>TabsX::POS_ABOVE,
						'height'=>TabsX::SIZE_TINY,
						'bordered'=>true,
						'encodeLabels'=>false,
						'align'=>TabsX::ALIGN_LEFT,						
					]);											
				?>
</div>