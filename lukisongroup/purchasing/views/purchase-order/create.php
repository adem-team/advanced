<?php
use yii\helpers\Html;
$checkPOCode = explode('.',$poHeader->KD_PO);

?>
<div class="container col-md-12" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<div  class="row">
	<!-- HEADER !-->
		<div class="col-md-12">
			<div class="col-md-1" style="float:left;">
				<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
			</div>
			<div class="col-md-10" style="padding-top:15px;">
				<h3 class="text-center"><b>
					<?php echo $checkPOCode[0]=='POA'? 'PLUS PURCHASE ORDER': 'PURCHASE ORDER'; ?>
				</b></h3>
			</div>
			<div class="col-md-12">
				<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
			</div>

		</div>
	</div>
</div>
<div class="purchaseorder-create" style="padding:10px;">

    <h1><?= Html::encode($this->title) ?></h1> <hr/>

    <?php
		/*CREATE AND EDIT*/
		if ($checkPOCode[0]=='POA'){
			 echo $this->render('_buat_poa', [
				'searchModel' => $searchModel,
				'dataProviderRo' => $dataProviderRo,
				'dataProviderSo'=>$dataProviderSo,
				'poDetailProvider'=>$poDetailProvider,
				'poHeader'=> $poHeader,
				'supplier'=>$supplier,
				'bill' => $bill,
				'ship' => $ship,
				'employee'=>$employee,
			]);
		}elseif($checkPOCode[0]=='POB'){
			 echo $this->render('_buat_pob', [
				'searchModel' => $searchModel,
				'searchModel1' => $searchModel1,
				'dataProviderRo' => $dataProviderRo,
				'dataProviderSo'=>$dataProviderSo,
				'poDetailProvider'=>$poDetailProvider,
				'poHeader'=> $poHeader,
				'supplier'=>$supplier,
				'bill' => $bill,
				'ship' => $ship,
				'employee'=>$employee,
			]);
		}elseif($checkPOCode[0]=='POC'){
			 echo $this->render('_buat_poc', [
				'searchModel' => $searchModel,
				'dataProviderRo' => $dataProviderRo,
				'dataProviderSo'=>$dataProviderSo,
				'poDetailProvider'=>$poDetailProvider,
				'poHeader'=> $poHeader,
				'supplier'=>$supplier,
				'bill' => $bill,
				'ship' => $ship,
				'employee'=>$employee,
			]);
		};
	?>

</div>
