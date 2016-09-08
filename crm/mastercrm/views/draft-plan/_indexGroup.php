<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
Use ptrnov\salesforce\Jadwal;
use kartik\tabs\TabsX;
use yii\widget\Pjax;
use yii\helpers\Url;


	$groupSetting=$this->render('_indexGroupSetting',[
		'searchModelGrp'=>$searchModelGrp,
		'dataProviderGrp'=>$dataProviderGrp,
		'drop'=>$drop,
		'pekan'=>$pekan,
		'user'=>$user
	]);
	$groupUser=$this->render('_indexGroupUser',[
		'searchModelUser'=>$searchModelUser,
		'dataProviderUser'=>$dataProviderUser,
		 'Stt'=>$Stt
		// 'SCL_NM'=>$SCL_NM
	]);
?>
<div  class="row" style="margin-top:0px,font-family: verdana, arial, sans-serif ;font-size: 8pt"> 
	<div  class="col-xs-6 col-sm-6 col-dm-6 col-lg-6">
		<?=$groupSetting?>
	</div>
	<div  class="col-xs-6 col-sm-6 col-dm-6 col-lg-6">
		<?=$groupUser?>
	</div>
</div>
