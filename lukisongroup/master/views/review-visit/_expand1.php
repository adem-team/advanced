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
					<button class="btn btn-box-tool" data-toggle="tooltip" title="Detail" data-widget="chat-pane-toggle"><i class="fa fa-fast-backward"></i></button>
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
									$dvInfo=$this->render('_expand1HeaderInfo',['dataProviderInfo'=>$dataProviderInfo]);
									$gvVisitTime=$this->render('_expand1CustVisit',['dataProviderTime'=>$dataProviderTime]);
									$gvInventory=$this->render('_expand1Inventory',['inventoryProvider'=>$inventoryProvider]);										
									$gvExpired=$this->render('_expand1Expired',['dataProviderExpired'=>$dataProviderExpired,'searchModelExpired'=>$searchModelExpired]);
									$gvMemo=$this->render('_expand1Memo',['dataProviderMemo'=>$dataProviderMemo]);
													
								?>
								<?=$dvInfo?>
								<?=$gvVisitTime?>
								<?=$gvInventory?>
								<?=$gvExpired?>
								<?=$gvMemo?>
							</div>
							<div class="col-sm-4 col-md-4 col-lg-4">
								<?php
									//$gvImage='';
									$gvImage=$this->render('_expand1Image',['dataProviderHeader2'=>$dataProviderImage]);
								?>
								<?=$gvImage?>
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
								// $gvDetailAll=$this->render('_expand1DetailAll',[
									// 'dataProviderHeader2'=>$dataProviderHeader2,
									// 'aryproviderDetailSummary'=>$aryproviderDetailSummary,
								// ]);
								
								
								/*STOCK*/
								$gvStock='';
								$gvStock=$this->render('_expand1SlideStock',[
									 'aryProviderDetailStock'=>$aryProviderDetailStock,
									 'aryProviderHeaderStock'=>$aryProviderHeaderStock
								]);								 
								 
								/*SELL REQUEST*/
								$gvRequest='';							
								$gvRequest=$this->render('_expand1SlideRequest',[
									 'aryProviderDetailRequest'=>$aryProviderDetailRequest,
									 'aryProviderHeaderRequest'=>$aryProviderHeaderRequest,
								]);
								
								/*SELL RETURE*/	
								$gvReture='';
								$gvReture=$this->render('_expand1SlideReture',[
									'aryProviderDetailReture'=>$aryProviderDetailReture,
									'aryProviderHeaderReture'=>$aryProviderHeaderReture,
								]);
								 
								/*SELL OUT*/								
								$gvSellOut=$this->render('_expand1SlideSout',[
									'aryProviderDetailSellOut'=>$aryProviderDetailSellOut,
									'aryProviderHeaderSellOut'=>$aryProviderHeaderSellOut,
								]);
								
								/*SELL IN*/								
								$gvSellIn=$this->render('_expand1SlideSin',[
									'aryProviderDetailSellIN'=>$aryProviderDetailSellIN,
									'aryProviderHeaderSellIN'=>$aryProviderHeaderSellIN,
								]);								
							?>
							
							<?=$gvStock?>
							<?=$gvRequest?>
							<?=$gvReture?>							
							<?=$gvSellIn?>
							<?=$gvSellOut?>
							<?=$gvDetailAll?>
							</div>
						</li><!-- End Contact Item -->
					</ul><!-- /.contatcts-list -->
				</div><!-- /.direct-chat-pane -->
			</div><!-- /.box-body -->
		</div><!--/.direct-chat -->
	</div>

</div>

    

