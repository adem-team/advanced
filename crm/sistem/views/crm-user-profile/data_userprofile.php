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
						$namaLengkap=$profile!=''? $profile->NM_MIDDLE . ' ' . $profile->NM_END:'';
						$tPhone=$profile!=''?$profile->TLP_HOME:'';
						$joinDate=$profile!=''? $profile->JOIN_DATE:'';
						$kdis =$profile!=''? $profile->KD_DISTRIBUTOR.'.'.$profile->KD_DISTRIBUTOR:'';
						$ktp ='xxx.xxx.xxx.xxx';
						$kode_subdis ='xxx.xxx.xx.xx';
						$kode_OUTSRC ='xxx-xxx-xxx-xx';
					}
				?>
				<dt style="width:100px; float:left">Name</dt>
				<dd>:	<?= $namaLengkap; ?></dd>
				<dt style="width:100px;float:left">Phone</dt>
				<dd>:	<?= $tPhone; ?></dd>
				<dt style="width:100px; float:left">Registered On</dt>
				<dd>:	<?= $joinDate; ?></dd>
				<dt style="width:100px; float:left">Kode Dis</dt>
				<dd>:	<?= $kdis; ?></dd>
				<dt style="width:100px; float:left">KTP</dt>
				<dd>:	<?= $ktp; ?></dd>
				<dt style="width:100px; float:left">Kode SUBDIST</dt>
				<dd>:	<?= $kode_subdis ; ?></dd>
				<dt style="width:100px; float:left">Kode Outsrcing</dt>
				<dd>:	<?= $kode_OUTSRC ; ?></dd>
			</dl>
		</div>
	</div>
	<div class="col-xs-12 col-md-12 col-lg-12">
	<h3>  <strong> Access Links :</strong></h3>
	   <br />
	   <?=tombolPersonalia();?>
	   <?=tombolPerformance();?>
</div>
</div>
