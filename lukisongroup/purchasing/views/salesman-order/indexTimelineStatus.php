<?php
$this->registerCss('
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
  top: 2px;
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
');

$iconClass="glyphicon glyphicon-remove";
$iconClass1="fa fa-times-circle";
?>
<!--<div style="display:inline-block;width:100%;overflow-y:auto;">!-->
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
<!--</div>!-->

       