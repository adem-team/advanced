<?php
$this->registerJs("		
		$(document).ready(function() {
			$(window).load(function(){
				window.open('http://chat.lukisongroup.com:8890');
			});
		});		
     ",$this::POS_READY);			

?>