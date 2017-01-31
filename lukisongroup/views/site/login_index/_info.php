<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use lukisongroup\assets\AppAssetQr;  	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
AppAssetQr::register($this);


?>
	
	<div class="col-xs-12 col-sm-3 col-dm-2 col-lg-2"  style="valign:bottom; margin-left:0 ; text-align: center"  >
      	<img src="<?= Yii::getAlias('@HRD_EMP_UploadUrl') .'/'. $model->EMP_IMG; ?>" class="img-thumbnail" alt="Cinque Terre" width="100px" height="100px"/>
	</div>
	
    <div class="col-xs-12 col-sm-5 col-dm-3 col-lg-3"  style="margin-left:0 ;padding-left: 0; padding-top:10px; margin-bottom: 10px">	
		<dl>
			<dt style="width:100px; float:left;">NIK</dt>
			<dd style="color:rgba(87, 163, 247, 1)">:<b> <?php echo $model->EMP_ID; ?></b></dd>
			
			<dt style="width:100px; float:left;">Name</dt>
			<dd>: <?php echo $model->EMP_NM . ' ' . $model->EMP_NM_BLK; ?></dd>
			
			<dt style="width:100px; float:left;">Job Title</dt>
			<dd>: <?php echo $dataProvider[0]['groupfunction']->GF_NM; ?></dd>
			
			<dt style="width:100px; float:left;"><b>Job Level</b></dt>
			<dd>: <?php echo $dataProvider[0]['jobgrade']->JOBGRADE_ID;// . ' - ' . $dataProvider[0]['jobgrade']->JOBGRADE_NM; ?></dd>     	  
			
			<dt style="width:100px; float:left;"><b>Organization</b></dt>
			<dd>: <?php echo str_replace('Department','',$dataProvider[0]['deptOne']->DEP_NM); ?></dd>     	  
			
			<dt style="width:100px; float:left;"><b>Org Lavel</b></dt>
			<dd>: <?php echo $dataProvider[0]['deptsub']->DEP_SUB_ID . ' - ' . $dataProvider[0]['deptsub']->DEP_SUB_NM; ?></dd>   		
		</dl>
    </div>
    <div class=" col-xs-12 col-sm-4 col-dm-3 col-lg-3"  style="padding-left:0;padding-top:10px;"  >
		<dl>
			<dt style="width:100px; float:left;">Company</dt>
			<dd>: <?php echo $dataProvider[0]['corpOne']->CORP_NM; ?></dd>
			
			<dt style="width:100px; float:left;">Location</dt>
			<dd>: <?php echo 'Demension c12'; ?></dd>
			
			<dt style="width:100px; float:left;">Join Date</dt>
			<dd>: <?php echo  $model->EMP_JOIN_DATE; ?></dd>
			
			<dt style="width:100px; float:left;">Status</dt>
			<dd>: <?php echo $dataProvider[0]['sttOne']!=''?$dataProvider[0]['sttOne']->STS_NM:''; ?></dd>
			
			<dt style="width:100px; float:left;">Email</dt>
			<dd>: <?php echo  $model->EMP_EMAIL; ?></dd>
			
			<!--<dt style="width:100px; float:left;">Join Date</dt>
			<dd>: <?php //echo  $model->EMP_JOIN_DATE; ?></dd>!-->
		</dl>
    </div>
	<div class=" col-xs-12 col-sm-4 col-dm-3 col-lg-3"  style="padding-left:0;padding-top:10px;"  >
		<dl>		
			<dt style="width:100px; float:left;">QR-Code</dt>		
			<dd>:
				<div data-ng-app="monospaced.qrcode" id="ng-app" data-ng-init="foo='<?php echo $model->EMP_ID ?>';bar='http://localhost/angular-qrcode-master/dist/angular-qrcode';v=4;e='M';s=100;"> 
					<qrcode version="{{v}}" error-correction-level="{{e}}" size="{{s}}" data="{{foo}}"></qrcode>
				</div>
			</dd>
		</dl>
    </div>