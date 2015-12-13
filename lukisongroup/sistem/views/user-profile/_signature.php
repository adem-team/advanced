<?php
use yii\helpers\Html;
use yii\helpers\Json;
use yii\bootstrap\Modal;
use lukisongroup\assets\AppAssetJqueryJSignature;
AppAssetJqueryJSignature::register($this); 

$this->registerCss("	
	/*This is the div within which the signature canvas is fitted*/
	#sig-disply-input {
		border: 2px dotted black;
		background-color:lightgrey;
	}	
	#sig-disply-old {
		border: 2px dotted black;
		background-color:lightgrey;
	}	
	
");

	/* $this->registerJs("
			var  jsonData= $.ajax({
			  url: 'http://api.lukisongroup.com/login/signatures?id=2',
			  type: 'GET',
			  dataType:'json',			
			  async: false
			  }).responseText;		  
			  var myData = jsonData;
			  sig = myData;
			  //alert(sig);
	",$this::POS_BEGIN) ; */
	$this->registerJs('
			$.noConflict;
			jQuery(document).ready(function($) {
				$("#sig-disply-input").jSignature();				
				$("#sig-disply-old").jSignature(["disable"]);			
				$("#sig-disply-db").jSignature(["disable"]);			
				$("#sig-disply-input").bind("change", function(e){
					  var sigDataBase30 = $("#sig-disply-input").jSignature("getData","base30");
					  var sigDataiSvgbase64 = $("#sig-disply-input").jSignature("getData","svgbase64");
					  $("#sig-disply-old").jSignature("setData","data:" + sigDataBase30[0] + "," + sigDataBase30[1]);					
					  $("#txtSvgbase64").val(sigDataiSvgbase64);
					  $("#txtBase30").val(sigDataBase30);
					  //alert(sigDataiSvgbase64)
				})		
				 
				/* $("#btnambil").click(function(){
					var sigDatax = $("#sig-disply-input").jSignature("getData","base30");
						//$("#sig-disply-old").jSignature("clear");	
						//var imgInput = new Image();
						//imgInput.src = "data:" + sigDatax[0] + "," + sigDatax[1]
						$("#sig-disply-old").jSignature("setData","data:" + sigDatax[0] + "," + sigDatax[1]);
						//alert(imgInput)
						//$(imgInput).appendTo($("#sig-disply-old"));
					
				}) */
				/* $("#btnclear").click(function(){
						$("#sig-disply-old").jSignature("reset");	
						
					
				}) */
				
				/* $("#sig-disply-input").bind("change", function(e){											
						var sigDatax = $("#sig-disply-input").jSignature("getData","svgbase64");
						var imgInput = new Image();
						imgInput.src = "data:" + sigDatax[0] + "," + sigDatax[1]						
						//alert(imgInput)
							//$("#sig-disply-old").jSignature("importData",data);
						$(imgInput).appendTo($("#sig-disply-old"));
						//$("#sig-disply-old").jSignature("reset");
				})	 */
				
				/* $("#sig-disply-input").bind("change", function(e){ 					
						var sigData = $("#sig-disply-input").jSignature("getData","svgbase64");
						$("#hiddenSigData").val(sigData);
						//alert(sigData);
				 })	 
					 */ 
					 
				//var i = new Image();							
				//i.src = "data:" + "image/svg+xml;base64" + "," + "PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMjYiIGhlaWdodD0iNDUiPjxwYXRoIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2U9InJnYigwLCAwLCAxMzkpIiBmaWxsPSJub25lIiBkPSJNIDEgNDQgYyAwLjA5IC0wLjE2IDMuNiAtNS44OCA1IC05IGMgMS42IC0zLjU1IDIuNDMgLTcuMzggNCAtMTEgYyAxLjggLTQuMTUgMy43NiAtOC4wOCA2IC0xMiBjIDEuOCAtMy4xNiAzLjkgLTYuNDQgNiAtOSBsIDMgLTIiLz48L3N2Zz4="; 
					$(i).appendTo($("#signature2"));
						
						
						
				//$("#signature1").bind("change", function(e){ 
					//alert("teset"); 
					//var data="image/jsignature;base30,1B4_1EZ7_2P00376553_1I55300Z102_5xZ4735_1yZ1020"
					//var datapair =("image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMjYiIGhlaWdodD0iNDUiPjxwYXRoIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2U9InJnYigwLCAwLCAxMzkpIiBmaWxsPSJub25lIiBkPSJNIDEgNDQgYyAwLjA5IC0wLjE2IDMuNiAtNS44OCA1IC05IGMgMS42IC0zLjU1IDIuNDMgLTcuMzggNCAtMTEgYyAxLjggLTQuMTUgMy43NiAtOC4wOCA2IC0xMiBjIDEuOCAtMy4xNiAzLjkgLTYuNDQgNiAtOSBsIDMgLTIiLz48L3N2Zz4=")
					//var datapair = $("#signature1").jSignature("getData","svgbase64");
					//try{
						//var i = new Image();							
						//i.src = "data:" + "image/svg+xml;base64" + "," + "PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMjYiIGhlaWdodD0iNDUiPjxwYXRoIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2U9InJnYigwLCAwLCAxMzkpIiBmaWxsPSJub25lIiBkPSJNIDEgNDQgYyAwLjA5IC0wLjE2IDMuNiAtNS44OCA1IC05IGMgMS42IC0zLjU1IDIuNDMgLTcuMzggNCAtMTEgYyAxLjggLTQuMTUgMy43NiAtOC4wOCA2IC0xMiBjIDEuOCAtMy4xNiAzLjkgLTYuNDQgNiAtOSBsIDMgLTIiLz48L3N2Zz4="; 
						//$(i).appendTo($("#signature2"));
						
						//var j = new Image();
						//j.src = "data:" + "image/svg+xml;base64" + "," + "PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iNjgiIGhlaWdodD0iMzUiPjxwYXRoIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2U9InJnYigwLCAwLCAxMzkpIiBmaWxsPSJub25lIiBkPSJNIDEgMTggYyAwLjAzIDAuMDcgMS4xMyAzLjI3IDIgNCBjIDAuOCAwLjY3IDIuODIgMC40MSA0IDEgYyA1LjkxIDIuOTUgMTIuMTcgNy41MyAxOCAxMCBjIDIuMjggMC45NyA1LjMzIDEgOCAxIGMgNi42MiAwIDEzLjkgMC4wNSAyMCAtMSBjIDMgLTAuNTIgNi42IC0yLjI5IDkgLTQgYyAxLjkgLTEuMzYgNC41NSAtMy45MiA1IC02IGMgMC45OCAtNC41MyAwLjQ4IC0xMi4xOSAwIC0xNyBjIC0wLjEgLTEuMDIgLTEuMjIgLTIuMjIgLTIgLTMgbCAtMyAtMiIvPjwvc3ZnPg==",
						//$(j).appendTo($("#signature3"));
						
						//$("#signature2").jSignature("setData", "data:" + datapair.join(","));
					//} catch (ex) {

					//}
				//})
				
				
				
			});
		
	 ',$this::POS_BEGIN);

?>
<div class="container-fluid text-center" style="padding-left: 20px; padding-right: 20px" >
<div style="font-style: italic;"><u><h1>Sign Your Sinature</h1></u></div>
	<div class="row">
		<div class="col-md-4" name="hide" style="height:150px; display:none;"> 
			<?php echo Html::a('<i class="fa fa-plus fa-lg"></i> '.Yii::t('app', 'Create New Signature',
									['modelClass' => 'customer',]),'/sistem/user-profile/create',[
										'data-toggle'=>"modal",
											'data-target'=>"#Sig-New",							
											'class' => 'btn btn-warning',
											"modal-size"=>"large",											
														]);
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4" style="padding-top:15px"> </div>
		<div class="col-md-4" style="padding-top:15px" > 
			<div>Fill your Signature</div>
			<div id="sig-disply-input"></div> 
			
		</div>
	</div>
	<div class="row">
		<div class="col-md-4" style="padding-top:15px"> </div>
		<div class="col-md-4" style="padding-top:15px" >
		<!--
			<button id="btnambil" type="button">test get </button>
			<button id="btnclear" type="button">clear</button>
		!-->
			<div>Capture Your Signature</div>
			<div id="sig-disply-old" readonly></div> 
		</div>
	</div>
	<!--BUTTON SAVED!-->
	<div class="row">
	<div class="col-md-4" style="padding-top:15px"> </div>
		<div class="col-md-4" style="padding-top:15px" > 
			<?php echo Html::a('<i class="fa fa-plus fa-lg"></i> '.Yii::t('app', 'SAVED',
									['modelClass' => 'customer',]),'/sistem/user-profile/create',[
										'data-toggle'=>"modal",
											'data-target'=>"#Sig-New",							
											'class' => 'btn btn-warning',
											"modal-size"=>"large",											
														]);
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4" style="padding-top:15px"> </div>
		<div class="col-md-4" style="padding-top:15px" >
		<!--
			<button id="btnambil" type="button">test get </button>
			<button id="btnclear" type="button">clear</button>
		!-->
			<div>Exist Signature</div>
			<div id="sig-disply-db" readonly></div> 
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4" style="padding-top:15px">
			<div name="hide" style="height:150px; display:none;">Decode encription Svgbase64</div>
			<div>
				<textarea id="txtSvgbase64" class="col-lg-12" name="hide" style="height:150px; display:none;"></textarea> 
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4" style="padding-top:15px">
			<div name="hide" style="height:150px; display:none;">Decode encription Base30</div>		
			<div>
				<textarea id="txtBase30" class="col-lg-12" name="hide" style="height:150px; display:none;"></textarea> 
			</div>
		</div>
	</div>
</div>	
	
<?php
	$this->registerJs("		
			/* var bsModal = $.fn.modal.noConflict(); */
			/* jQuery('a.first').pageslide(); */
			//$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
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
				/*By Case reload page-> conflict js Auth:-ptr.nov-*/
				 $('#Sig-New').on('hidden.bs.modal', function () {
					location.reload();
				}); 
		",$this::POS_END);
		
		Modal::begin([
			'id' => 'Sig-New',
			'header' => '<h4 class="modal-title">Entry Request Order</h4>',
			//'size' => 'modal-md',
		]);
		Modal::end();
?>