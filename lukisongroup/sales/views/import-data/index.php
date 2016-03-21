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
use kartik\builder\Form;

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
			?>


<div class="body-content">
    <div class="row" style="padding-left: 5px; padding-right: 5px">

        <div class="col-sm-6 col-md-6 col-lg-6 ">
            <?php
				 echo GridView::widget([
					'id'=>'gv-arryFile',
					'dataProvider' => $getArryFile,
					//'filterModel' => $searchModel,
					'columns'=>$gvColumnAryFile,						
					'pjax'=>true,
					'pjaxSettings'=>[
					'options'=>[
						'enablePushState'=>false,
						'id'=>'gv-arryFile',
					   ],						  
					],
					'hover'=>true, //cursor select
					'responsive'=>true,
					'responsiveWrap'=>true,
					'bordered'=>true,
					'striped'=>'4px',
					'autoXlFormat'=>true,
					'export' => false,
					'panel' => [
						'heading'=>'<h3 class="panel-title">LIST VIEW FILES</h3>',
						'type'=>'danger',
						'before'=> Html::a('<i class="fa fa-upload"></i> '.Yii::t('app', 'Import File',
											['modelClass' => 'Kategori',]),'',[
												'data-toggle'=>"modal",
												'data-target'=>"#file-import",
												'class' => 'btn btn-danger btn-sm'
											]
									).' '.
									Html::a('<i class="fa fa-check-square"></i> '.Yii::t('app', 'Check',
											['modelClass' => 'Kategori',]),'/master/barang/create',[
												'data-toggle'=>"modal",
												'data-target'=>"#modal-create",
												'class' => 'btn btn-success btn-sm'
											]
									).' '.
									Html::a('<i class="fa fa-clone"></i> '.Yii::t('app', 'Get Format',
											['modelClass' => 'Kategori',]),'/master/barang/create',[
												'data-toggle'=>"modal",
												'data-target'=>"#modal-create",
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
					'id'=>'gv-validate',
					'dataProvider' => $gvValidateArrayDataProvider,
					//'filterModel' => $searchModel,
					'columns'=>$gvValidateColumn,					
					'pjax'=>true,
					'pjaxSettings'=>[
					'options'=>[
						'enablePushState'=>false,
						'id'=>'gv-validate',
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
						'{export}',
					],
					'panel' => [
						'heading'=>'<h3 class="panel-title">LIST VALIDATION IMPORT DATA</h3>',
						'type'=>'warning',
						'before'=> Html::a('<i class="fa fa-save"></i> '.Yii::t('app', 'Send Data',
										['modelClass' => 'Kategori',]),'/master/barang/create',[
											'data-toggle'=>"modal",
											'data-target'=>"#modal-create",
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
			$form1 = ActiveForm::begin([
					'options'=>['enctype'=>'multipart/form-data'] // important
				]);
				echo FileInput::widget([
					'name'=>'kartiks_file',
					 // 'name' => 'attachment_48[]',
					// 'options'=>[
						// 'multiple'=>true
					// ],
					'pluginOptions' => [
						'uploadUrl' => Url::to(['/sales/import-data/upload']),
						'showPreview' => false,
						'showUpload' => false,
						'showCaption' => true,
						'showRemove' => true,
						// 'uploadExtraData' => [
							// 'album_id' => 20,
							// 'cat_id' => 'Nature'
						// ],
						// 'maxFileCount' => 10
					]
				]);
			echo '<div style="text-align:right; padding-top:10px">';
			echo Html::submitButton('Upload',['class' => 'btn btn-success']);
			echo '</div>';
			ActiveForm::end();
		Modal::end();

?>