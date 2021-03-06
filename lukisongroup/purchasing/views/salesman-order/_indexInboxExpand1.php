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
				<h3 class="box-title" style="font-family:tahoma, arial, sans-serif;font-size:10pt;text-align:center;color:blue" ><?php echo "<b>SALES ORDER DETAIL</b>";?></h3>
				<div class="box-tools pull-left">
					<!--<span data-toggle="tooltip" title="3 New Messages" class="badge bg-green">3</span>-->
					<button class="btn btn-box-tool" data-toggle="tooltip" title="show/hide" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-toggle="tooltip" title="Historical" data-widget="chat-pane-toggle"><i class="fa fa-fast-backward"></i></button>
					<!-- <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
				</div>
			</div><!-- /.box-header -->
			<div class="box-body">
				<!-- Conversations are loaded here -->
				<div class="direct-chat-messages" style="height:600px">
					<!-- Message. Default to the left -->
						 <div class="raw">
							<div class="col-sm-12 col-md-12 col-lg-12" style="font-family:tahoma, arial, sans-serif;font-size:9pt">
								<?php
									$dvInfoCustomer=$this->render('_indexExpand1CustDetail',[
										'model'=>$model,
									]);	
									$dvSoCustomerInbox=$this->render('_indexInboxExpand1SoDetail',[
										'aryProviderSoDetailInbox1'=>$aryProviderSoDetailInbox2,
										'model'=>$model,
									]);													
									//print_r($aryProviderSODetail);									
								?>
								<?=$dvInfoCustomer?>
								<?=$dvSoCustomerInbox?>
							</div>
						</div>
					<!-- Message to the right -->
				</div><!--/.direct-chat-messages-->
				<!-- Contacts are loaded here -->
				<div class="direct-chat-contacts" style="height:600px; color:black;background-color:white">
					<ul class="contacts-list">
						<li>
							<div class="raw">
							<?php
								//HISTORY CUSTOMER
								//echo $modelCust->CUST_KD;
							?>
							</div>
						</li><!-- End Contact Item -->
					</ul><!-- /.contatcts-list -->
				</div><!-- /.direct-chat-pane -->
			</div><!-- /.box-body -->
		</div><!--/.direct-chat -->
	</div>

</div>

    

