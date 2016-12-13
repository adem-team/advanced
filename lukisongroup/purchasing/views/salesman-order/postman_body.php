<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Lukisongroup Postman</title>	
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
		<style>
		/* Timeline */
			.timeline,
			.timeline-horizontal {
			  list-style: none;
			  padding: 0px;
			  position: relative;
			}
			.timeline:before {
			  top: 40px;
			  bottom: 0;
			  position: absolute;
			  content: " ";
			  width: 3px;
			  background-color: #eeeeee;
			  left: 50%;
			  margin-left: -1.5px;
			}
			.timeline .timeline-item {
			  margin-bottom: 0px;
			  position: relative;
			}
			.timeline .timeline-item:before,
			.timeline .timeline-item:after {
			  content: "";
			  display: table;
			}
			.timeline .timeline-item:after {
			  clear: both;
			}
			.timeline .timeline-item .timeline-badge {
			  color: #fff;
			  width: 54px;
			  height: 54px;
			  line-height: 52px;
			  font-size: 22px;
			  text-align: center;
			  position: absolute;
			  top: 18px;
			  left: 50%;
			  margin-left: -25px;
			  background-color: #7c7c7c;
			  border: 3px solid #ffffff;
			  z-index: 100;
			  border-top-right-radius: 50%;
			  border-top-left-radius: 50%;
			  border-bottom-right-radius: 50%;
			  border-bottom-left-radius: 50%;
			}
			.timeline .timeline-item .timeline-badge i,
			.timeline .timeline-item .timeline-badge .fa,
			.timeline .timeline-item .timeline-badge .glyphicon {
			  top: 12px;													/*icon Top*/
			  left: 0px;
			}
			.timeline .timeline-item .timeline-badge.primary {
			  background-color: #1f9eba;
			}
			.timeline .timeline-item .timeline-badge.info {
			  background-color: #5bc0de;
			}
			.timeline .timeline-item .timeline-badge.success {
			  background-color: #59ba1f;
			}
			.timeline .timeline-item .timeline-badge.warning {
			  background-color: #d1bd10;
			}
			.timeline .timeline-item .timeline-badge.danger {
			  background-color: #ba1f1f;
			}
			.timeline .timeline-item .timeline-panel {
			  position: relative;
			  width: 10px;
			  float: left;
			  right: 16px;
			  border: 1px solid #c0c0c0;
			  background: #ffffff;
			  border-radius: 2px;
			  padding: 20px;
			  -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
			  box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175); 
			}
			.timeline .timeline-item .timeline-panel:before {
			  position: absolute;
			  top: 10px;
			  right: -16px;
			  display: inline-block;
			  border-top: 16px solid transparent;
			  border-left: 16px solid #c0c0c0;
			  border-right: 0 solid #c0c0c0;
			  border-bottom: 16px solid transparent;
			  content: " ";
			}
			.timeline .timeline-item .timeline-panel .timeline-title {
			  margin-top: 5px;															/*Top text header Panel*/
			  color: inherit;
			}
			.timeline .timeline-item .timeline-panel .timeline-body > p,
			.timeline .timeline-item .timeline-panel .timeline-body > ul {
			  margin-bottom: 0;
			}
			.timeline .timeline-item .timeline-panel .timeline-body > p + p {
			  margin-top: 5px;
			}
			.timeline .timeline-item:last-child:nth-child(even) {
			  float: right;
			}
			.timeline .timeline-item:nth-child(even) .timeline-panel {
			  float: right;
			  left: 16px;
			}
			.timeline .timeline-item:nth-child(even) .timeline-panel:before {
			  border-left-width: 0;
			  border-right-width: 14px;
			  left: -14px;
			  right: auto;
			}
			.timeline-horizontal {
			  list-style: none;
			  position: relative;
			  padding: 20px 10px 20px 10px;
			  display: inline-block;
			}
			.timeline-horizontal:before {
			  height: 3px;
			  top: auto;
			  bottom: 26px;
			  left: 56px;
			  right: 0;
			  width: 100%;
			  margin-bottom: 20px;
			}
			.timeline-horizontal .timeline-item {
			  display: table-cell;
			  height: 10px;
			  width: 20px;													/*Width Box Panel*/
			  min-width: 200px; 												/*Timeline jarak titik*/
			  float: none !important;
			  padding-left: 0px;
			  padding-right: 5px;											/*jarak Panel Box*/
			  margin: 0 auto;
			  vertical-align: bottom;
			}
			.timeline-horizontal .timeline-item .timeline-panel {
			  top: auto;
			  bottom: 50px;
			  display: inline-block;
			  float: none !important;
			  left: 0 !important;
			  right: 0 !important;
			  width: 100%;
			  margin-bottom: 20px;
			}
			.timeline-horizontal .timeline-item .timeline-panel:before {
			  top: auto;
			  bottom: -16px;
			  left: 0px !important;									/*tandah panah bawah panel*/
			  right: auto;
			  border-right: 16px solid transparent !important;
			  border-top: 16px solid #c0c0c0 !important;
			  border-bottom: 0 solid #c0c0c0 !important;
			  border-left: 16px solid transparent !important;
			}
			.timeline-horizontal .timeline-item:before,
			.timeline-horizontal .timeline-item:after {
			  display: none;
			}
			.timeline-horizontal .timeline-item .timeline-badge {
			  top: auto;
			  bottom: 0px;
			  left: 20px;
			}
		</style>
	</head>
	<body style="margin:0px;
				padding:0px;
				border: 0 none;
				font-size: 11px;
				font-family: Verdana, sans-serif;
				background-color: #efefef;">
		<table style="margin-button: 50px; width: 350px; margin: 50px auto 50px auto; border: 1px #fff solid; background: #fff; font-size: 12px; font-family: Verdana, sans-serif;" align="center">
			<tbody>
				<tr>
					<td style="color: #fff; background:blue;text-align:center">
						<h2>LUKISONGROUP POSTMAN</h2>
					</td>
				</tr>
				<tr>
					<td style="background: #dff442; margin-top:5px; margin-button: 18px; text-align: center; vertical-align: text-center;font-weight: bold">
						NOTIFICATION : Sales Order-T2
					</td>
				</tr>
				<tr>
					<td>
						<table style="font-size: 12px; font-family: Verdana, sans-serif;">
							<?php
								$KD_SO=$soHeaderData->KD_SO;
								$TGL=$soHeaderData->TGL;
								$STORE=$soHeaderData->cust->CUST_NM;
							?>
							<tr>
								<td style="width: 80px; color:black; background:white;text-align:left">
									SO.No
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:red; background:white;text-align:left;font-size:12px">
									<?=$KD_SO; ?>
								</td>	
							</tr>
							<tr>
								<td style="color:black; background:white;text-align:left">
									STORE
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:black; background:white;text-align:left">
									<?=$STORE?>
								</td>
							</tr>
							<tr>
								<td style="color:black; background:white;text-align:left">
									CREATE AT
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:black; background:white;text-align:left">
									<?=$TGL?>
								</td>
							</tr>
							
							<tr>
								<td style="color:black; background:white;text-align:left">
									CREATE BY
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:black; background:white;text-align:left">
									<?=$soHeaderData->sign1Nm!=''?$soHeaderData->sign1Nm:'none'; ?>
								</td>
							</tr>							
						</table>
					</td>
				</tr>
				<tr>
					<td style="background: #6de4ed; margin-top:5px; margin-button: 18px; text-align: center; vertical-align: text-center">
						<b>AUTHORIZE VALIDATION</b>
					</td>
				</tr>
				<tr>
					<td>
						<table style="font-size: 12px; font-family: Verdana, sans-serif;">
							<tr>
								<td style="color:black; background:white;text-align:left">
									ESM ADMIN
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:black; background:white;text-align:left">
									<?=$soHeaderData->sign2Nm!=''?$soHeaderData->sign2Nm:'none'; ?>
								</td>
							</tr>
							<tr>
								<td style="color:black; background:white;text-align:left">
									ESM KAM
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:black; background:white;text-align:left">
									<?=$soHeaderData->sign3Nm!=''?$soHeaderData->sign3Nm:'none'; ?>
								</td>
							</tr>
							<tr>
								<td style="color:black; background:white;text-align:left">
									ACCOUNTING
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:black; background:white;text-align:left">
									<?=$soHeaderData->sign4Nm!=''?$soHeaderData->sign4Nm:'none'; ?>
								</td>
							</tr>
							<tr>
								<td style="color:black; background:white;text-align:left">
									WAREHOUSE
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:black; background:white;text-align:left">
									<?=$soHeaderData->sign5Nm!=''?$soHeaderData->sign5Nm:'none'; ?>
								</td>
							</tr>						
						</table>
					</td>
				</tr>
				<!--
				<tr>
					<td style="background: #6de4ed; margin-top:5px; margin-button: 18px; text-align: center; vertical-align: text-center">
						<b>INVOICES KODE REFERENCES </b>
					</td>
				</tr>
				<tr>
					<td>
						<table style="font-size: 12px; font-family: Verdana, sans-serif;">
							<tr>
								<td style="width: 80px; color:black; background:white;text-align:left">
									INVOICE.No
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:blue; background:white;text-align:left;font-size:12px">
									<?php //=$KD_SO; ?>
								</td>	
							</tr>
							<tr>
								<td style="width: 80px; color:black; background:white;text-align:left">
									SHIPPING.No
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:brown; background:white;text-align:left;font-size:12px">
									<?php //=$KD_SO; ?>
								</td>	
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="background: #6de4ed; margin-top:5px; margin-button: 18px; text-align: center; vertical-align: text-center">
						<b>DELIVERY CODE REFERENCES</b>
					</td>
				</tr>
				
				<tr>
					<td>
						<table style="font-size: 12px; font-family: Verdana, sans-serif;">
							<tr>
								<td style="width: 80px; color:black; background:white;text-align:left">
									INVOICE.No
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:blue; background:white;text-align:left;font-size:12px">
									<?php //=$KD_SO; ?>
								</td>	
							</tr>
							<tr>
								<td style="width: 80px; color:black; background:white;text-align:left">
									SHIPPING.No
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:brown; background:white;text-align:left;font-size:12px">
									<?php//=$KD_SO; ?>
								</td>	
							</tr>
						</table>
					</td>
				</tr>
				!-->
				<tr>
					<td style="padding: 9px; color:black; background:white;text-align:left">
						please find the attachment for details or login <a href="http://lukisongroup.com">Lukisongroup.com</a>
					</td>
				</tr>
				<tr>
					<td style="padding: 9px; color:red; background:white;text-align:center">
						This email message has been automatically generated, Please do not reply to this message.
					</td>
				</tr>
				<tr>
					<td colspan="2" style="background: #ddd; padding: 9px; margin-top:5px; margin-button: 18px; text-align: center;">
						&copy;Lukisongroup 2016
					</td>
				</tr>
			</tbody>
		</table>
	
	<?php
		//$this->registerCss('');

			$iconClass="glyphicon glyphicon-remove";
			$iconClass1="fa fa-times-circle";
		?>	
		<br>
		<ul class="timeline timeline-horizontal">
		<li class="timeline-item">
			<div class="timeline-badge danger"><i class="<?=$soHeaderData->sign1Nm!='None'?'glyphicon glyphicon-check':'glyphicon glyphicon-remove'?>"></i></div>
			<div class="timeline-panel">
				<div class="timeline-heading">
					<h4 class="timeline-title">SALES MD</h4>
					<p>
						<small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?=$soHeaderData->sign1SelisihWaktu.' hours ago' ?></small><br>
						<small class="text-muted"><i class="fa fa-user fa-lg"></i> <?=$soHeaderData->sign1Nm!=''?$soHeaderData->sign1Nm:''?> </small>
					</p>
				</div>								
			</div>
		</li>
		<li class="timeline-item">
			<div class="timeline-badge info"><i class="<?=$soHeaderData->sign2Nm!='None'?'glyphicon glyphicon-check':'glyphicon glyphicon-remove'?>"></i></div>
			<div class="timeline-panel">
				<div class="timeline-heading">
					<h4 class="timeline-title">ESM ADMIN</h4>
					<p>
						<small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?=$soHeaderData->sign2SelisihWaktu.' hours ago' ?> </small><br>
						<small class="text-muted"><i class="fa fa-user fa-lg"></i> <?=$soHeaderData->sign2Nm!=''?$soHeaderData->sign2Nm:''?> </small>
					</p>
				</div>
				
			</div>
		</li>
		<li class="timeline-item">
			<div class="timeline-badge success"><i class="<?=$soHeaderData->sign3Nm!='None'?'glyphicon glyphicon-check':'glyphicon glyphicon-remove'?>"></i></div>
			<div class="timeline-panel">
				<div class="timeline-heading">
					<h4 class="timeline-title">ESM KAM</h4>
					<p>
						<small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?=$soHeaderData->sign3SelisihWaktu.' hours ago' ?></small><br>
						<small class="text-muted"><i class="fa fa-user fa-lg"></i> <?=$soHeaderData->sign3Nm!=''?$soHeaderData->sign3Nm:''?> </small>
					</p>
				</div>								
			</div>
		</li>
		<li class="timeline-item">
			<div class="timeline-badge success"><i class="<?=$soHeaderData->sign4Nm!='None'?'glyphicon glyphicon-check':'glyphicon glyphicon-remove'?>"></i></div>
			<div class="timeline-panel">
				<div class="timeline-heading">
					<h4 class="timeline-title">ACCOUNTING</h4>
					<p>
						<small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?=$soHeaderData->sign4SelisihWaktu.' hours ago' ?> </small><br>
						<small class="text-muted"><i class="fa fa-user fa-lg"></i> <?=$soHeaderData->sign4Nm!=''?$soHeaderData->sign4Nm:''?> </small>
					</p>
				</div>
				
			</div>
		</li>
		<li class="timeline-item">
			<div class="timeline-badge danger"><i class="<?=$soHeaderData->sign5Nm!='None'?'glyphicon glyphicon':'glyphicon glyphicon-remove'?>"></i></div>
			<div class="timeline-panel">
				<div class="timeline-heading">
					<h4 class="timeline-title">WAREHOUSE</h4>
					<p>
						<small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?=$soHeaderData->sign5SelisihWaktu.' hours ago' ?> </small><br>
						<small class="text-muted"><i class="fa fa-user fa-lg"></i> <?=$soHeaderData->sign5Nm!=''?$soHeaderData->sign5Nm:''?> </small>
					</p>
				</div>								
			</div>
		</li>						
	</ul>
	</body>
</html>
