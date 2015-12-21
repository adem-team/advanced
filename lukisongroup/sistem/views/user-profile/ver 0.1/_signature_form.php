<?php
use \Yii;
use yii\helpers\Html;
use lukisongroup\assets\AppAssetJqueryJSignature;
AppAssetJqueryJSignature::register($this); 
$this->registerJs('
				jQuery.fn.isOnScreen
				var j$ = jQuery.noConflict($);
				 j$(document).ready(function() {
					try {
						  $("#sig-input-form").jSignature();				 			
						  $("#sig-disply-result").jSignature();			
						  $("#sig-input-form").bind("change", function(){
							 
							  var sigDataBase30frm = $("#sig-input-form").jSignature("getData","base30");
							  var sigDataiSvgbase64frm = $("#sig-input-form").jSignature("getData","svgbase64");
							  
							  $("#sig-disply-result").jSignature("setData","data:" + sigDataBase30frm[0] + "," + sigDataBase30frm[1]);					
							  $("#sig-Data-Svgbase64-frm").val(sigDataiSvgbase64frm);
							  $("#sig-Data-Base30-frm").val(sigDataBase30frm);
							  alert(sigDataiSvgbase64frm);
						  })
					} catch (e) {
						Bugsnag.notifyException(e);
					}					 
					
				});
				 
				 $("#btnCreate").click(function(){
						$("#sig-input-form").jSignature("reset");			
					
				}) 
	 ',$this::POS_END);
?>
<div class="row">
		<div class="pre-scrollable col-md-12" style="padding-top:15px" > 
			Fill your Signature
			<div id="sig-input-form"></div> 
			
		</div>
	</div>
<button id="btnCreate" type="button">Create Signature</button>
<div  id="sig-input-form"></div> 
<div  id="sig-disply-result">0000000</div> 
<textarea id="sig-Data-Svgbase64-frm"  style="height:150px"></textarea> 
<textarea id="sig-Data-Base30-frm" style="height:150px"></textarea> 
 
   