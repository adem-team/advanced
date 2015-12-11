<?php
use \Yii;
use yii\helpers\Html;
$this->registerJs('
		jQuery.noConflict();
		jQuery(document).ready(function() {	 
				$("#redrawSignature1").signature();
				//$("#redrawSignature").signature({disabled: true});				
				//$("#redrawSignature").signature({
				//	change: function(event, ui) { 
				//		$("#redrawSignature").signature("draw", sig);											
				//	}
				//});
				
				// $("#SVGSignature").signature();
				//$("#redrawSignature").signature();
				//$("#redrawSignature").signature({disabled: true});				
				//$("#SVGSignature").signature({
				//	change: function(event, ui) { 
				//		$("#redrawSignature").signature("draw", sig);
				//		var coba=$("#redrawSignature").signature("toSVG");	
				//		 document.getElementById("ptrSvg").innerHTML = coba;							
				//	}
				//}); 
		});					   
	',$this::POS_READY); 

?>
<div  id="redrawSignature1"></div> 
   
<?php echo "test"; ?>