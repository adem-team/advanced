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
		'fileName'=>$fileName,
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
        <div class="col-sm-12 col-md-12 col-lg-12 ">
            <?=$gvImportFile?>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12">
            <?php //$gvValidateFile?>
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
				'pluginOptions' => [
					'showPreview' => false,
					'showUpload' => false,
					//'uploadUrl' => Url::to(['/sales/import-data/upload']),
				] 
			]);
			echo '<div style="text-align:right; padding-top:10px">';
			echo Html::submitButton('Upload',['class' => 'btn btn-success']);
			echo '</div>';
		ActiveForm::end();
	Modal::end();
	
	/**
	 * MODAL NOTIFY ERROR UPLOAD DATA FILE
	*/
	Modal::begin([
		'id' => 'error-msg-stockgudang',
		'header' => 'WARNING',
		'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
		]
	]);
		echo "<div>Check Excel Data<br>";
		echo "1.Pastikan Format Excel sudah sesuai.</br>";
		echo "2.Pastikan Column STATUS='stock-gudang' </br>";
		echo "</div>";
	Modal::end();
	
	/**
	 * MODAL NOTIFY SUCCESS IMPORT DATA
	*/
	Modal::begin([
		'id' => 'success-msg-stockgudang',
		'header' => 'WARNING',
		'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
		]
	]);
		echo "<div>Data berhasil di Import<br></div>";
	Modal::end();
	
	/**
	 * MODAL NOTIFY NO DATA IMPORT
	*/
	Modal::begin([
		'id' => 'nodata-msg-stockgudang',
		'header' => 'WARNING',
		'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
		]
	]);
		echo "<div>Data tidak ada, pastikan upload file<br></div>";
	Modal::end();
	
	/**
	 * MODAL NOTIFY Validasi data column tidak komplit
	*/
	Modal::begin([
		'id' => 'validate-msg-stockgudang',
		'header' => 'WARNING',
		'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
		]
	]);
		echo "<div>Data Gagal di Import, Excel data Column tidak Komplit, Check kembali data sebelum di import<br></div>";
	Modal::end();
?>

<?php
	
	$this->registerJs("
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
				url: '/sales/import-gudang/send-fix',
				type: 'POST',
				//contentType: 'application/json; charset=utf-8',
				data:'id='+idx,
				dataType: 'json',
				success: function(result) {
					if (result == 'sukses'){
						// Success
						//$.pjax.reload({container:'#gv-validate-gudang-id'});
						$('#success-msg-stockgudang').modal('show');
					}else if(result == 'validasi') {
						$('#validate-msg-stockgudang').modal('show');
					}else if(result == 'nodata'){
						$('#nodata-msg-stockgudang').modal('show');
					}
				}
			});

		});
		
		$(document).ready(function(){
			$('#success-msg-stockgudang').on('hidden.bs.modal', function () {
				//alert('The modal is now hidden.');
				//$.post('/controller/action/whatever');
				window.location.assign('http://lukisongroup.com/sales/import-gudang/');
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