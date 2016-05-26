<?php
use kartik\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use yii\db\ActiveRecord;
use yii\data\ArrayDataProvider;

use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Termcustomers;
use lukisongroup\master\models\Distributor;
use lukisongroup\hrd\models\Corp;

//print_r($model);

echo $model['CUST_KD_PARENT']!=''?'no':'ok';
?>
<div class="content" >
	<!-- HEADER !-->
	<div  class="row">
		<!-- HEADER !-->
		<div class="col-md-12">
			<div class="col-md-1" style="float:left;">
				<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
			</div>
			<div class="col-md-9" style="padding-top:15px;">
				<h3 class="text-center"><b> <?php echo 	ucwords($model->NM_TERM)  ?> </b></h3>
			</div>
			<div class="col-md-12">
				<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
			</div>

		</div>
	</div>

	<!-- PARTIES/PIHAK !-->
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<div>
				<?php //echo pihak($model); ?>
			</div>
			<dl>
				<?php
					$data = Customers::find()->where(['CUST_KD'=> $model->CUST_KD_PARENT])
											->asArray()
											->one();
					$datadis = Distributor::find()->where(['KD_DISTRIBUTOR'=> $model->DIST_KD])
												  ->asArray()
												  ->one();
					$datacorp = Corp::find()->where(['CORP_ID'=> $model->PRINCIPAL_KD])
																				->asArray()
																				->one();
				 ?>
				<dt><h6><u><b>PARTIES/PIHAK BERSANGKUTAN :</b></u></h6></dt>

				<dd>1 :	<?= $data['CUST_NM'] ?></dd>


				<dd>2 :	<?= $datadis['NM_DISTRIBUTOR']?></dd>


				<dd>3 :	<?=$datacorp['CORP_NM']?></dd>
			</dl>
		</div>
	</div>
</div><!-- Body !-->