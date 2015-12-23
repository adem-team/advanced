<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\bootstrap\Modal;
use yii\helpers\Url;
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
	/*
	 * Tombol Modal to Signature Form
	 * permission 
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	 */
	function tombolSigLoginForm($emp_id){		
		$title1 = Yii::t('app', 'Set Signature Secure Password');
		$options1 = [ 'id'=>'signature-signup',	
					  'data-toggle'=>"modal",
					  'data-target'=>"#sig-signup-password",											
					  'class' => 'btn btn-warning',
		]; 
		$icon1 = '<span class="fa fa-plus fa-lg"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/password-signature-form']);
		//$options1['tabindex'] = '-1';
		$content = Html::a($label1,$url1, $options1);
		return $content;	
	};


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
					  $("#txtSvgbase64").val("data:" + sigDataiSvgbase64);
					  $("#txtBase30").val("data:" + sigDataBase30);
					  //alert(sigDataiSvgbase64)
					 
				})		
				 
				$("#btnBersihkan").click(function(){
					$("#sig-disply-input").jSignature("clear");				
					$("#sig-disply-old").jSignature("clear");
				});
				
				/* Data Signature from DB */
				var datadb =\''. $model->SIGSVGBASE30 . '\'
				$("#sig-disply-db").jSignature("setData",datadb);
			});
		
	 ',$this::POS_BEGIN);

?>
<div class="container-fluid text-center" style="padding-left: 20px; padding-right: 20px" >
<div style="font-style: italic;"><u><h1>Sign Your Sinature</h1></u></div>
	<div class="row">
		<div class="col-md-4" style="padding-top:15px"> </div>
		<div class="col-md-4" style="padding-top:15px" > 			
			<div >Fill your Signature</div>
			<div style="float:right">
				<button id="btnBersihkan" type="button">Clear</button>
			</div>
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
	<!--FORM SAVED!-->
	<div class="row">
		<div class="col-md-4" style="padding-top:15px"> </div>
		<div class="col-md-4" style="padding-top:15px" > 
			
			<?php $form = ActiveForm::begin([
						'id'=>'roInput',
						'enableClientValidation' => true,
						'method' => 'post',
						'action' => ['/sistem/user-profile/signature-saved'],
					]);
					 echo $form->field($model, 'EMP_ID')->hiddenInput(['value'=>$model->EMP_ID])->label(false);
					 echo $form->field($model, 'SIGSVGBASE30')->hiddenInput(['id'=>'txtBase30'])->label(false);
					 echo $form->field($model, 'SIGSVGBASE64')->hiddenInput(['id'=>'txtSvgbase64'])->label(false);
			?>
				<div class="form-group">
				<?= Html::submitButton($model->isNewRecord ? 'SimpanSignature' : 'SAVED', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','title'=>'Detail','data-confirm'=>'Anda Yakin Akan di Simpan ?']) ?>
				
				</div>
			<?php ActiveForm::end(); ?>		
			<?php /* echo Html::a('<i class="fa fa-plus fa-lg"></i> '.Yii::t('app', 'SAVED',
									['modelClass' => 'customer',]),'/sistem/user-profile/create',[
										'data-toggle'=>"modal",
											'data-target'=>"#Sig-New",							
											'class' => 'btn btn-warning',
											"modal-size"=>"large",											
														]); */
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
			<?php echo tombolSigLoginForm($model->EMP_ID); ?>
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
				<!--
					<textarea id="txtBase30" class="col-lg-12" name="hide" style="height:150px; display:none;"></textarea> 
				
				<textarea id="txtBase30" class="col-lg-12"style="height:150px;"></textarea> 
				!-->				
			</div>
		</div>
	</div>
</div>	
	
<?php
	$this->registerJs("					
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
			$('#sig-signup-password').on('show.bs.modal', function (event) {
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
				})
	",$this::POS_END);
		
	Modal::begin([
		'id' => 'sig-signup-password',
		'header' => '<h4 class="modal-title">Set Signature Password</h4>',
		'size' => Modal::SIZE_SMALL,
	]);
	Modal::end();
?>