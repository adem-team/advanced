<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

	
	/*
	 * GRIDVIEW CUSTOMER LIST DETAIL ON GROUP
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	$gvCustGroupListDetail= GridView::widget([
		'id'=>'gv-custgrp-list',
		'dataProvider' => $dpListCustGrp,
		'filterModel' => $searchModel,
		'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
		'columns' => [
			[	//COL-2
				/* Attribute Serial No */
				'class'=>'kartik\grid\SerialColumn',
				'width'=>'10px',
				'header'=>'No.',
				'hAlign'=>'center',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'background-color'=>'rgba(0, 95, 218, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
					]
				],
				'pageSummaryOptions' => [
					'style'=>[
							'border-right'=>'0px',
					]
				]
			],
			[  	//col-1
				//CUSTOMER GRAOUP NAME
				'attribute' =>'custgrp.SCDL_GROUP_NM',
				'label'=>'Customer Groups',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'200px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'200px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				  'group'=>true,
			],
			[  	//col-2
				//CUSTOMER GRAOUP NAME
				//'attribute' => 'cust_nm',
				'attribute' => 'CUST_NM',
				'label'=>'Nama Customers',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'200px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'200px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[	//col-3
				//STATUS
				'attribute' => 'STATUS',
				'filter' => $valStt,
				'format' => 'raw',
				'hAlign'=>'center',
				'value'=>function($model){
				   if ($model->STATUS == 1) {
						return Html::a('<i class="fa fa-check"></i> &nbsp;Enable', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
					} else if ($model->STATUS == 0) {
						return Html::a('<i class="fa fa-close"></i> &nbsp;Disable', '',['class'=>'btn btn-danger btn-xs', 'title'=>'Deactive']);
					}
				},
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'80px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'80px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[
				'class'=>'kartik\grid\ActionColumn',
				'dropdown' => true,
				'template' => '{view}{edit}',
				'dropdownOptions'=>['class'=>'pull-right dropup'],
				'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
				'buttons' => [
					 'view' =>function($url, $model, $key){
								return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
															['/master/schedule-group/view-group','id'=>$model->CUST_KD],[
															'data-toggle'=>"modal",
															'data-target'=>"#modal-view",
															'data-title'=> '',//$model->KD_BARANG,
															]). '</li>' . PHP_EOL;
						},
						'edit' =>function($url, $model, $key){
								return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Update'),
															['/master/schedule-group/update-group','id'=>$model->CUST_KD],[
															'data-toggle'=>"modal",
															'data-target'=>"#modalmap",
															'data-title'=>'',// $model->KD_BARANG,
															]). '</li>' . PHP_EOL;
						},
				],
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						//'width'=>'150px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
						//'width'=>'150px',
						//'height'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],

			],
		],
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-custgrp-list',
		   ],
		],
		'panel' => [
					'heading'=>'<h3 class="panel-title">LIST CUSTOMER GROUP</h3>',
					'type'=>'warning',
					'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Customer ',
							['modelClass' => 'Kategori',]),'/master/schedule-group/create-scdl',[
								'data-toggle'=>"modal",
									'data-target'=>"#modal-create",
										'class' => 'btn btn-success'
													]),

					'showFooter'=>false,
		],
		'toolbar'=> [
			//'{items}',
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
	]);
?>

<?=$gvCustGroupListDetail?>