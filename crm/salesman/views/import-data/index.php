<?php
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use kartik\widgets\Spinner;

/* TABLE CLASS DEVELOPE -> |DROPDOWN,PRIMARYKEY-> ATTRIBUTE */
use app\models\hrd\Dept;
/*	KARTIK WIDGET -> Penambahan componen dari yii2 dan nampak lebih cantik*/
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;

//use kartik\builder\Form;

//use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
//AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_sales';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\Pjax;


	/* function tombolCheck(){
		$title = Yii::t('app', 'Approved');
		$options = [ 'id'=>'approved',
					 'data-pjax' => true,
					 'data-toggle-approved'=>$fileName,
		];
		$icon = '<span class="glyphicon glyphicon-ok"></span>';
		$label = $icon . ' ' . $title;
		return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;
	} */







			?>


<div class="body-content">
    <div class="row" style="padding-left: 5px; padding-right: 5px">

        <div class="col-sm-6 col-md-6 col-lg-6 ">
            <?php
				 echo GridView::widget([
					'id'=>'gv-arryFile-salesman',
					'dataProvider' => $getArryFile,
					//'filterModel' => $searchModel,
					'columns'=>$gvColumnAryFile,
					'pjax'=>true,
					'pjaxSettings'=>[
					'options'=>[
						'enablePushState'=>false,
						'id'=>'gv-arryFile-salesman',
					   ],
					],
					'hover'=>true, //cursor select
					'responsive'=>true,
					'responsiveWrap'=>true,
					'bordered'=>true,
					'striped'=>'4px',
					'autoXlFormat'=>true,
					'export' => false,
					'toolbar' => [
						''
					],
					'panel' => [
						'heading'=>'<h3 class="panel-title">IMPORT FILES STOCK</h3>',
						'type'=>'danger',
						'before'=> Html::a('<i class="fa fa-upload"></i> '.Yii::t('app', 'Import File',
											['modelClass' => 'Kategori',]),'',[
												'data-toggle'=>"modal",
												'data-target'=>"#file-import",
												'class' => 'btn btn-danger btn-sm'
											]
									).' '.
									Html::a('<i class="fa fa-check-square"></i> '.
											Yii::t('app', 'Check',['modelClass' => 'check',]),'',[
												'id'=>'approved',
												'data-pjax' => true,
												'data-toggle-approved'=>$fileName,
												'class' => 'btn btn-success btn-sm'
											]
									).' '.
									Html::a('<i class="fa fa-clone"></i> '.Yii::t('app', 'Get Format1'),'/salesman/import-data/export_format',
												[
													'id'=>'export-x-id',
													'data-pjax' => true,
													'class' => 'btn btn-info btn-sm'
												]
									),
						'showFooter'=>false,
					],
				]);
            ?>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <?php
				//print_r($gvValidateColumn);
				echo GridView::widget([
					'id'=>'gv-validate-salesman',
					'dataProvider' => $gvValidateArrayDataProvider,
					'filterModel' => $searchModelValidate,
					'columns'=>$gvValidateColumn,
					'rowOptions' => function($model, $key, $index, $grid){
							if ($model->CUST_KD=='NotSet' or $model->ITEM_NM=='NotSet'){
								return ['class' => 'danger'];
							};
					},
					'pjax'=>true,
					'pjaxSettings'=>[
					'options'=>[
						'enablePushState'=>false,
						'id'=>'gv-validate-salesman',
					   ],
					],
					'hover'=>true, //cursor select
					'responsive'=>true,
					'responsiveWrap'=>true,
					'bordered'=>true,
					'striped'=>'4px',
					'autoXlFormat'=>true,
					'export' => false,
					'panel'=>[''],
					'toolbar' => [
						''
					],
					'panel' => [
						'heading'=>'<h3 class="panel-title">VALIDATION IMPORT DATA</h3>',
						'type'=>'warning',
						'before'=> Html::a('<i class="fa fa-remove"></i> '.
											Yii::t('app', 'Clear',['modelClass' => 'Clear',]),'',[
												'id'=>'clear',
												'data-pjax' => true,
												'data-toggle-clear'=>'1',
												'class' => 'btn btn-danger btn-sm'
											]
									).' '.
									Html::a('<i class="fa fa-database"></i> '.Yii::t('app', 'Send Data',
										['modelClass' => 'Kategori',]),'',[
												'id'=>'fix',
												'data-pjax' => true,
												'data-toggle-fix'=>'1',
											'class' => 'btn btn-success btn-sm'
										]
									),

						'showFooter'=>false,
					],
				]);
            ?>
        </div>
		<!--VIEW IMPORT!-->
		<div class="col-sm-12 col-md-12 col-lg-12">
            <?php
				//print_r($gvValidateColumn);
				echo GridView::widget([
					'id'=>'gv-view-import-salesman',
					'dataProvider' => $dataProviderViewImport,
					'filterModel' => $searchModelViewImport,
					'columns'=>$gvRows,
					'pjax'=>true,
					'pjaxSettings'=>[
					'options'=>[
						'enablePushState'=>false,
						'id'=>'gv-view-import-salesman',
					   ],
					],
					'hover'=>true, //cursor select
					'responsive'=>true,
					'responsiveWrap'=>true,
					'bordered'=>true,
					'striped'=>'4px',
					'autoXlFormat'=>true,
					'export' => false,
					'panel'=>[''],
					'toolbar' => [
						''
					],
					'panel' => [
						'heading'=>'<h3 class="panel-title">LIST DATA</h3>',
						'type'=>'info',
						'before'=> Html::a('<i class="fa fa-remove"></i> '.
											Yii::t('app', 'Clear',['modelClass' => 'Clear',]),'',[
												'id'=>'clear',
												'data-pjax' => true,
												'data-toggle-clear'=>'1',
												'class' => 'btn btn-danger btn-sm'
											]
									).' '.
									Html::a('<i class="fa fa-database"></i> '.Yii::t('app', 'Send Data',
										['modelClass' => 'Kategori',]),'',[
												'id'=>'fix',
												'data-pjax' => true,
												'data-toggle-fix'=>'1',
											'class' => 'btn btn-success btn-sm'
										]
									),

						'showFooter'=>false,
					],
				]);
            ?>
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
					'action' => ['/salesman/import-data/upload'],
				]);
				echo $form->field($modelFile, 'uploadExport')->widget(FileInput::classname(), [
					'options' => ['accept' => '*'],
					/* 'pluginOptions' => [
						'uploadUrl' => Url::to(['/sales/import-data/upload']),
					] */
				]);


				// echo FileInput::widget([
					// 'name'=>'import_file',
					 // 'name' => 'attachment_48[]',
					// 'options'=>[
						// 'multiple'=>true
					// ],
					// 'pluginOptions' => [
						// 'uploadUrl' => Url::to(['/sales/import-data/upload']),
						// 'showPreview' => false,
						// 'showUpload' => false,
						// 'showCaption' => true,
						// 'showRemove' => true,
						// 'uploadExtraData' => [
							// 'album_id' => 20,
							// 'cat_id' => 'Nature'
						// ],
						// 'maxFileCount' => 10
					// ]
				// ]);
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
				url: '/salesman/import-data/import_temp_validation',
				type: 'POST',
				//contentType: 'application/json; charset=utf-8',
				data:'id='+idx,
				dataType: 'json',
				success: function(result) {
					if (result == 1){
						// Success
						$.pjax.reload({container:'#gv-validate-salesman'});
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
				url: '/salesman/import-data/clear_temp_validation',
				type: 'POST',
				//contentType: 'application/json; charset=utf-8',
				data:'id='+idx,
				dataType: 'json',
				success: function(result) {
					if (result == 1){
						// Success
						$.pjax.reload({container:'#gv-validate-salesman'});
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
				url: '/salesman/import-data/send_temp_validation',
				type: 'POST',
				//contentType: 'application/json; charset=utf-8',
				data:'id='+idx,
				dataType: 'json',
				success: function(result) {
					if (result == 1){
						// Success
						$.pjax.reload({container:'#gv-validate-salesman'});
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
