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
 <div class="raw">
	<div class="panel panel-info">
		<div class="box direct-chat direct-chat">
		 <!-- box-header -->
			<div class="box-header with-border" >
				<h3 class="box-title" style="font-family:tahoma, arial, sans-serif;font-size:10pt;text-align:center;color:blue" ><?php echo "<b>CUSTOMER CALL</b>";?></h3>
				<div class="box-tools pull-left">
					<!--<span data-toggle="tooltip" title="3 New Messages" class="badge bg-green">3</span>-->
					<button class="btn btn-box-tool" data-toggle="tooltip" title="show/hide" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-toggle="tooltip" title="Detail" data-widget="chat-pane-toggle"><i class="fa fa-navicon"></i></button>
					<!-- <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
				</div>
			</div><!-- /.box-header -->
			<div class="box-body">
				<!-- Conversations are loaded here -->
				<div class="direct-chat-messages" style="height:1200px">
					<!-- Message. Default to the left -->
						 <div class="raw">
							<div class="col-sm-8 col-md-8 col-lg-8" style="font-family:tahoma, arial, sans-serif;font-size:9pt">
								<?php
									$gvHeaderInfo=$this->render('_expand1HeaderInfo',['dataModelsHeader1'=>$dataModelsHeader1]);
									$gvCustVisit=$this->render('_expand1CustVisit',['dataProviderHeader2'=>$dataProviderHeader2]);																	
									$gvRo=$this->render('_expand1Ro',['inventoryProvider'=>$inventoryProvider]);				
									$gvInventory=$this->render('_expand1Inventory',['inventoryProvider'=>$inventoryProvider]);				
									$gvExpired=$this->render('_expand1Expired',['inventoryProvider'=>$inventoryProvider]);
													
								?>
								<?=$gvHeaderInfo?>
								<?=$gvCustVisit?>
								<?=$gvRo?>
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
					<!-- Message to the right -->
				</div><!--/.direct-chat-messages-->
				<!-- Contacts are loaded here -->
				<div class="direct-chat-contacts" style="height:1200px; color:black;background-color:white">
					<ul class="contacts-list">
						<li>
							<div class="raw">
							<?php
								/*All Detail*/
								$gvDetailAll=$this->render('_expand1DetailAll',[
									'dataProviderHeader2'=>$dataProviderHeader2,
									'aryproviderDetailSummary'=>$aryproviderDetailSummary,
								]);
								/*STOCK*/
								$gvStock=$this->render('_expand1SlideStock',[
									'aryProviderDataStock'=>$aryProviderDataStock,
									'aryProviderHeaderStock'=>$aryProviderHeaderStock,
								]);
								/*SELL IN*/								
								$gvSellIn=$this->render('_expand1SlideSin',[
									'aryProviderDataSellIN'=>$aryProviderDataSellIN,
									'aryProviderHeaderSellIN'=>$aryProviderHeaderSellIN,
								]);
								/*SELL OUT*/								
								$gvSellOut=$this->render('_expand1SlideSout',[
									'aryProviderDataSellOut'=>$aryProviderDataSellOut,
									'aryProviderHeaderSellOut'=>$aryProviderHeaderSellOut,
								]);
								/*SELL RETURE*/								
								$gvReture=$this->render('_expand1SlideReture',[
									'aryProviderDataReture'=>$aryProviderDataReture,
									'aryProviderHeaderReture'=>$aryProviderHeaderReture,
								]);
								/*SELL REQUEST*/								
								$gvRequest=$this->render('_expand1SlideRequest',[
									'aryProviderDataRequest'=>$aryProviderDataRequest,
									'aryProviderHeaderRequest'=>$aryProviderHeaderRequest,
								]);
							?>
							<?=$gvRequest?>
							<?=$gvStock?>
							<?=$gvReture?>
							<?=$gvSellOut?>
							<?=$gvSellIn?>
							<?=$gvDetailAll?>
							</div>
						</li><!-- End Contact Item -->
					</ul><!-- /.contatcts-list -->
				</div><!-- /.direct-chat-pane -->
			</div><!-- /.box-body -->
		</div><!--/.direct-chat -->
	</div>

</div>

    

