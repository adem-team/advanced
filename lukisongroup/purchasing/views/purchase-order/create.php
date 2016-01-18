<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\po\Purchaseorder */

?>
<div class="container col-md-12" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<div  class="row">
	<!-- HEADER !-->
		<div class="col-md-12">
			<div class="col-md-1" style="float:left;">
				<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>	
			</div>
			<div class="col-md-10" style="padding-top:15px;">
				<h3 class="text-center"><b>PURCHASE ORDER</b></h3>
			</div>			
			<div class="col-md-12">
				<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
			</div>
			
		</div>
	</div>
</div>
<div class="purchaseorder-create" style="padding:10px;">

    <h1><?= Html::encode($this->title) ?></h1> <hr/>

    <?php // $this->render('_form', [
	 echo $this->render('_buat', [
        //'model' => $model,
        //'que' => $que,
    	//'podet' => $podet,
		'searchModel' => $searchModel,
		'dataProviderRo' => $dataProviderRo,
		'dataProviderSo'=>$dataProviderSo,
		'poDetailProvider'=>$poDetailProvider,
		'poHeader'=> $poHeader,
		'supplier'=>$supplier,
		'bill' => $bill,
		'ship' => $ship,
		'employee'=>$employee,
    ]) ?>

</div>
