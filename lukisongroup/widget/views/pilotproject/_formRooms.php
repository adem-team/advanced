<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\widgets\DateTimePicker;
?>

<?php  //yii\widgets\Pjax::begin(['id' => 'parent-room']) ?>
	<?php
		$form = ActiveForm::begin([
			'id'=> $model->formName(),
			'enableClientValidation'=> true,
			'enableAjaxValidation'=>true,
			//'validationUrl'=>Url::toRoute('/widget/pilotproject/room-form'),
			//'options' => ['data-pjax' => true],
		]);
	?>


	<?=$form->field($model, 'pARENT_NM')->textInput()  ?>

	<?= $form->field($model, 'pARENT_TGLPLAN1')->widget(DatePicker::classname(), [
			'options' => ['placeholder' => 'Enter date ...'],
			'convertFormat' => true,
			'pluginOptions' => [
				'autoclose'=>true,
				'todayHighlight' => true,
				'format' => 'yyyy-M-dd'
			],
			'pluginEvents' => [
							  'show' => "function(e) {show}",
			],
		]);
	?>
	 <?= $form->field($model, 'pARENT_TGLPLAN2')->widget(DatePicker::classname(), [
			'options' => ['placeholder' =>'date greater or equal '],
			'convertFormat' => true,
			'pluginOptions' => [
				'autoclose'=>true,
				'todayHighlight' => true,
				'format' => 'yyyy-M-dd'
			],
			'pluginEvents' => [
							  'show' => "function(e) {show}",
			],
		]);
	?>    

	<?= $form->field($model, 'DESTINATION_TO')->widget(Select2::classname(), [
         'data' => $dropemploy,
        'options' => [
        'placeholder' => 'Pilih Karyawan ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],
        
    ]);?>	
		
	<div style="text-align: right;"">
		<?php echo Html::submitButton('Submit',['class' => 'btn btn-primary', 'data-pjax' => 0]); ?>
	</div>
	<?php ActiveForm::end(); ?>
<?php //yii\widgets\Pjax::end() ?>	

<?php
$this->registerJs("
	/**
	* Before Action Handling Modal.
	* Status : Fixed.
	* author piter novian [ptr.nov@gmail.com].
	*/
	$(document).on('beforeSubmit',".$model->formName().", function () {
		 var form = $(this);
		 // return false if form still have some validation errors
		 if (form.find('.has-error').length) {
			  return false;
		 }
		 // submit form
		 $.ajax({
			  url:'/widget/pilotproject/room-form',
			  type: 'post',
			  //data: form.serialize(),
			  success: function (response) {
				 	$('#modal-rooms').modal('hide');	
					//alert(getCookie('tglParenRoom'));
					//document.cookie = 'tglParenRoom';
					fcRefresh();
					document.cookie = 'tglParenRoom';					
					//$('#calendar_test').load(location.href + ' #calendar_test');
					// window.location = '/widget/pilotproject';
					
				   // console.log('chck before submit ptr.nov');
				   
			  }
		 });
		 return false;
		 
		/**
		* Fullcalendar Refresh by date, rooms parent submit.
		* Status : Fixed.
		* author piter novian [ptr.nov@gmail.com].
		*/
		function fcRefresh(){
			var tglCurrent =  getCookie('PilotprojectParent_cookie1');
			//set fullcalendar on date.
			$('#calendar_test').fullCalendar( 'gotoDate', tglCurrent )
			//Remove resources.
			$.get('".Url::base()."/widget/pilotproject/render-data-resources', function(data, status){
				//var obj = new JSONObject(data);
				coba =  JSON.parse(data);
				for (var key in coba) {
					$('#calendar_test').fullCalendar('removeResources',coba[key].id);
					console.log(coba[key].id);
				};
				//alert(coba[1].id);
				//alert(coba.count);
			}); 					

			//Add resources.
			$.get('".Url::base()."/widget/pilotproject/update-data-resources?start='+tglCurrent, function(datarcvd, status){
				rcvd =  JSON.parse(datarcvd);
				for (var key in rcvd) {
					$('#calendar_test').fullCalendar('addResource',
						rcvd[key]
					, scroll );
					console.log(rcvd[1]);
				};						
			});			
				//Refresh with fetch.
				$('#calendar_test').fullCalendar('refetchEvents');
				$('#calendar_test').fullCalendar('refetchResources');					
		};
		
		/**
		* Get Cookie from PHP 
		* Status : Fixed.
		* author piter novian [ptr.nov@gmail.com].
		*/
		function getCookie(cname) {
			var name = cname +'=';
			var ca = document.cookie.split(';');
			for(var i = 0; i <ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') {
					c = c.substring(1);
				}
				if (c.indexOf(name) == 0) {
					return c.substring(name.length,c.length);
				}
			}
			return '';
		};
	}); 
",$this::POS_READY);
?>


