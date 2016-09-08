<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
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

?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
    <div  class="row" style="margin-top:15px">
        <div class="col-sm-8 col-md-8 col-lg-8">
			<?php
				$gvHeaderInfo=$this->render('_expand1HeaderInfo',['dataModelsHeader1'=>$dataModelsHeader1]);	
				$gvInventory=$this->render('_expand1Inventory',['inventoryProvider'=>$inventoryProvider]);				
				$gvExpired=$this->render('_expand1Expired',['inventoryProvider'=>$inventoryProvider]);
				$gvCustVisit=$this->render('_expand1CustVisit',['dataProviderHeader2'=>$dataProviderHeader2]);				
			?>
			<?=$gvHeaderInfo?>
			<?=$gvCustVisit?>
			<?=$gvInventory?>
			<?=$gvExpired?>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4">
			<?php
				$gvImage=$this->render('_expand1Image',['dataProviderHeader2'=>$dataProviderHeader2]);
			?>
			<?php echo $gvImage?>
		</div>
	</div>
</div>
