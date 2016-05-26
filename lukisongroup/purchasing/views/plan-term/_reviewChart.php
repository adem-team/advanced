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

//print_r($model[0]);

//echo $model[0]->NmDis;
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
				<h3 class="text-center"><b> <?php echo 'TERM - '.ucwords($model[0]->NmCustomer)  ?> </b></h3>
			</div>
			<div class="col-md-12">
				<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
			</div>

		</div>
	</div>

	<!-- PARTIES/PIHAK !-->
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-3" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<div>
				<?php //echo pihak($model); ?>
			</div>
			<dl>				
				<dt><h6><u><b>PARTIES/PIHAK BERSANGKUTAN :</b></u></h6></dt>

				<dd>1 :	<?= $model[0]->NmCustomer ?></dd>


				<dd>2 :	<?= $model[0]->Nmprincipel ?></dd>


				<dd>3 :	<?= $model[0]->NmDis ?></dd>
			</dl>
		</div>	
	
		<!-- PERIODE/JANGKA WAKTU !-->
		<div class="col-xs-12 col-sm-6 col-md-3" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<div>
				<?php //echo periode($model); ?>
			</div>
			<dl>
				<dt><h6><u><b>PERIODE/JANGKA WAKTU :</b></u></h6></dt>
				<dt style="width:80px; float:left;"> Dari: </dt>
				<dd>:	<?=$model[0]->PERIOD_START ?></dd>

				<dt style="width:80px; float:left;">Sampai:</dt>
				<dd>:	<?=$model[0]->PERIOD_END ?></dd>
			</dl>
		</div>
		
		<!-- TARGET !-->
		<div class="col-xs-3 col-sm-6col-md-12" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<div>
				<?php //echo target($model); ?>
			</div>
			<dl>
				<dt style="width:80px;"><h6><u><b>TARGET :</b></u></h6></dt>
				<dd style="width:80px"> Rp.<?=$model->TARGET_VALUE?></dd>
				<dd><?=$model->TARGET_TEXT ?> Rupiah</dd>

			</dl>
		</div>
	</div>
</div><!-- Body !-->