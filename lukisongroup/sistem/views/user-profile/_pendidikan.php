<div class="col-xs-12 col-md-9 col-lg-9" style="font-family: tahoma ;font-size: 10pt;">
	<!-- EMPLOYEE PROGRESSBAR !-->
	<div class="col-sm-12 col-md-12 col-lg-12 alert alert-info">
			Your profile is only 45% complete, to enjoy full feaures you have to complete it 100%.
			<div style="height:4px">
				<div class="col-sm-12 col-md-12 col-lg-12 progress-bar progress-bar-striped active progress-bar-danger"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;">
					<span class="sr-only">45% Complete</span>
				</div>
			</div>
				<!--To complete your profile please <a href="#">click here</a> .!-->
				
	</div>
	<!-- EMPLOYEE QR QODE 
	<div class="col-sm-2 col-md-2 col-lg-2">
		<div data-ng-app="monospaced.qrcode" id="ng-app" data-ng-init="foo='<?php //echo $model->EMP_ID ?>';bar='http://localhost/angular-qrcode-master/dist/angular-qrcode';v=4;e='M';s=100;"> 
			<qrcode version="{{v}}" error-correction-level="{{e}}" size="{{s}}" data="{{foo}}"></qrcode>
		</div>
	</div>
	!-->
		
		
		<hr />
	<div class="col-sm-12 col-md-12 col-lg-12" >
		<div class="col-md-6"style="float:left">
			<dl>
				<?php
					if($profile){
						$namaLengkap=$profile->emp!=''? $profile->emp->EMP_NM . ' ' . $profile->emp->EMP_NM_BLK:'';
						$tPhone=$profile->emp!=''?$profile->emp->EMP_TLP:'';
						$joinDate=$profile->emp!=''? $profile->emp->EMP_JOIN_DATE:'';
						$depRole=$profile->emp!=''? $profile->emp->DEP_ID.'.'.$profile->emp->DEP_SUB_ID:'';
						$nPWP='xxx.xxx.xxx.xxx';
						$jamSostek='xxx.xxx.xx.xx';
						$noReg='xxx-xxx-xxx-xx';
					}
				?>
				<dt style="width:100px; float:left">Name</dt>
				<dd>:	<?=$namaLengkap; ?></dd>
				<dt style="width:100px;float:left">Phone</dt>
				<dd>:	<?=$tPhone; ?></dd>
				<dt style="width:100px; float:left">Registered On</dt>
				<dd>:	<?=$profile->emp->EMP_JOIN_DATE; ?></dd>
				<dt style="width:100px; float:left">Role</dt>
				<dd>:	<?=$profile->emp->DEP_ID.'.'.$profile->emp->DEP_SUB_ID; ?></dd>
				<dt style="width:100px; float:left">NPWP</dt>
				<dd>:	<?=$nPWP; ?></dd>
				<dt style="width:100px; float:left">Jamsostek</dt>
				<dd>:	<?=$jamSostek; ?></dd>
				<dt style="width:100px; float:left">NoReg</dt>
				<dd>:	<?=$noReg; ?></dd>
			</dl>
		</div>
	</div>
</div>	
<div class="col-xs-12 col-md-12 col-lg-12" style="float:none" >
	<h3>  <strong> Access Links :</strong></h3>
	   <br />
	   <?=tombolPersonalia();?>
	   <?=tombolPerformance();?>
</div>