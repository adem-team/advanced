<?php
use yii\helpers\Html;
use yii\helpers\Json;
use yii\bootstrap\Modal;


$this->registerJs("
			var  jsonData= $.ajax({
			  url: 'http://api.lukisongroup.com/login/signatures?id=2',
			  type: 'GET',
			  dataType:'json',			
			  async: false
			  }).responseText;		  
			  var myData = jsonData;
			  sig = myData;
			  //alert(sig);
	",$this::POS_BEGIN) ;
	
$this->registerJs('
		$(document).ready(function($) {	 
				$("#redrawSignature").signature();
				$("#redrawSignature").signature({disabled: true});				
				$("#redrawSignature").signature({
					change: function(event, ui) { 
						$("#redrawSignature").signature("draw", sig);											
					}
				});
				
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
	',$this::POS_BEGIN); 

?>
<div>
	 
	<div id="redrawSignature"></div> 
	 <!--
	  <div  id="SVGSignature"></div>
	  <div  id="ptrSvg"></div> !-->
	<?=Html::a('<i class="fa fa-plus fa-lg"></i> '.Yii::t('app', 'Create New Signature',
						['modelClass' => 'customer',]),'/sistem/user-profile/create',[
							'data-toggle'=>"modal",
								'data-target'=>"#Sig-New",							
									'class' => 'btn btn-warning'						
												]);
	?>
	<button id="siq" onclick="myFunction()">Reload page</button>
</div>

<?php
$this->registerJs("
			function myFunction() {
				location.reload();
			};
",$this::POS_BEGIN);

$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function(){};
			$('#Sig-New').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title') 
				var href = button.attr('href') 
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)					
					});
				}),	
		",$this::POS_READY);
		
		Modal::begin([
			'id' => 'Sig-New',
			'header' => '<h4 class="modal-title">Sign Signature</h4>',
			'size' => 'modal-md',
		]);
		Modal::end();
?>