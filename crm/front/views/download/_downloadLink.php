<?php
use yii\helpers\Html;
use yii\helpers\Url;
						
	echo Html::a('<i class="fa fa-cloud-download fa-dm"></i> '.Yii::t('app', 'LG-Sales Ver 1.1'),
				'/front/download/app-sales',
				[
					//'id'=>'export-data',
					//'data-pjax' => true,
					'class' => 'btn btn-info btn-sm',
					'style'=>['text-align'=>'left','border'=>0, 'border-radius'=>'25px', 'background-color'=>'rgba(94, 226, 138, 1)', 'padding-left'=>'20px'],
					
				]
	);
?>
<br><br>
<div style="font-family: verdana, arial, sans-serif ;font-size: 9pt"> 
	Untuk mendownload Applikasi di sini, masuk pada URL: http://crm.lukisongroup.com/front/download
	Kemudian click langsung pada button download di atas.

</div>