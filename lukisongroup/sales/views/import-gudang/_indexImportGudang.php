<?php
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use kartik\widgets\Spinner;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\Pjax;

use app\models\hrd\Dept;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;


	/**
	* GRIDVIEW DATA EXCEL FROM FILE
	* @return mixed
	* @author piter [ptr.nov@gmail.com]
	*/
	$gvImportFile=$this->render('_indexImportGudangFile',[
		'getArryFile'=>$getArryFile,
	]);
	
	/**
	* GRIDVIEW VALIDATE DATA| EDITING 
	* @return mixed
	* @author piter [ptr.nov@gmail.com]
	*/
	$gvValidateFile=$this->render('_indexImportGudangValidate',[
		'gvValidateArrayDataProvider'=>$gvValidateArrayDataProvider,
		'searchModelValidate'=>$searchModelValidate,
	]);	

	/**
	* GRIDVIEW LIST IMPORT DATA
	* @return mixed
	* @author piter [ptr.nov@gmail.com]
	*/
	// $gvListImport=$this->render('_indexImportGudangListData',[
		// 'dataProviderViewImport'=>$dataProviderViewImport,
		// 'searchModelViewImport'=>$searchModelViewImport,
	// ]);	
	
?>

<div class="body-content">
    <div class="row" style="padding-left: 5px; padding-right: 5px">
        <div class="col-sm-6 col-md-6 col-lg-6 ">
            <?=$gvImportFile?>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <?=$gvValidateFile?>
        </div>
		<!--VIEW IMPORT!-->
		<div class="col-sm-12 col-md-12 col-lg-12">
            <?php //$gvListImport?>
        </div>
    </div>
</div>

<?php

	Modal::begin([
		'id' => 'file-import',
		'header' => '<div style="float:left;margin-right:10px">'. 
						Html::img('@web/img_setting/warning/upload1.png',  
						['class' => 'pnjg', 'style'=>'width:40px;height:40px;'])
					.'</div><div style="margin-top:10px;"><h4><b>Upload Path Of File!</b></h4></div>',
		//'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
		]
	]);
		$form = ActiveForm::begin([
			'options'=>['enctype'=>'multipart/form-data'], // important,
			'method' => 'post',
			'action' => ['/sales/import-gudang/upload'],
		]);
			echo $form->field($modelFile, 'uploadExport')->widget(FileInput::classname(), [
				'options' => ['accept' => '*'],
				/* 'pluginOptions' => [
					'uploadUrl' => Url::to(['/sales/import-data/upload']),
				] */
			]);
			echo '<div style="text-align:right; padding-top:10px">';
			echo Html::submitButton('Upload',['class' => 'btn btn-success']);
			echo '</div>';
		ActiveForm::end();
	Modal::end();
?>

<?php
	
	$this->registerJs("
		/**====================================
		 * ACTION : VALIDATION 
		 * @return mixed
		 * @author piter [ptr.nov@gmail.com]
		 * @since 1.2
		 * ====================================
		 */
		$(document).on('click', '[data-toggle-approved]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-approved');
			$.ajax({
				url: '/sales/import-gudang/import_temp_validation',
				type: 'POST',
				//contentType: 'application/json; charset=utf-8',
				data:'id='+idx,
				dataType: 'json',
				success: function(result) {
					if (result == 1){
						// Success
						$.pjax.reload({container:'#gv-validate-gudang-id'});
					} else {
						// Fail
					}
				}
			});
		});
		
		
		/**====================================
		 * ACTION : DELETE & CLEAR VALIDATION 
		 * @return mixed
		 * @author piter [ptr.nov@gmail.com]
		 * @since 1.2
		 * ====================================
		 */
		$(document).on('click', '[data-toggle-clear]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-clear');
			$.ajax({
				url: '/sales/import-gudang/clear_temp_validation',
				type: 'POST',
				//contentType: 'application/json; charset=utf-8',
				data:'id='+idx,
				dataType: 'json',
				success: function(result) {
					if (result == 1){
						// Success
						$.pjax.reload({container:'#gv-validate-gudang-id'});
					} else {
						// Fail
					}
				}
			});

		});
		
		/**====================================
		 * ACTION : SEND DATA TO STORED
		 * @return mixed
		 * @author piter [ptr.nov@gmail.com]
		 * @since 1.2
		 * ====================================
		 */
		$(document).on('click', '[data-toggle-fix]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-fix');
			$.ajax({
				url: '/sales/import-gudang/send_temp_validation',
				type: 'POST',
				//contentType: 'application/json; charset=utf-8',
				data:'id='+idx,
				dataType: 'json',
				success: function(result) {
					if (result == 1){
						// Success
						$.pjax.reload({container:'#gv-validate-gudang-id'});
					} else {
						// Fail
					}
				}
			});

		});
	",$this::POS_READY);
	
	$this->registerJs("
		/**====================================
		 * ACTION : Alias Customer
		 * @return mixed
		 * @author piter [ptr.nov@gmail.com]
		 * @since 1.2
		 * ====================================
		 */
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
		$('#alias-cust').on('show.bs.modal', function (event) {
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
			'id' => 'alias-cust',
			'header' => '<h4 class="modal-title">Setting Alias Code Customers</h4>',
			//'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
			//'size' => 'modal-xs'
			//'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();
	
	$this->registerJs("
		/**====================================
		 * ACTION : Alias Prodak
		 * @return mixed
		 * @author piter [ptr.nov@gmail.com]
		 * @since 1.2
		 * ====================================
		 */
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
		$('#alias-prodak').on('show.bs.modal', function (event) {
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
			'id' => 'alias-prodak',
			'header' => '<h4 class="modal-title">Setting Alias Code Product</h4>',
			//'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
			//'size' => Modal::SIZE_MEDIUM,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();
	
?>