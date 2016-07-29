<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

	
	/*
	 * GRIDVIEW GROUP LIST
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */	 
	$gvGroupListLocation= GridView::widget([
			//'id'=>'gv-custgrp-id',
			'id'=>'gv-listgroup-location',
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
			'rowOptions'   => function ($model, $key, $index, $grid) {
				 return ['id' => $model->ID,'onclick' => '$.pjax.reload({
							url: "'.Url::to(['/master/schedule-group/index']).'?CustomersSearch[SCDL_GROUP]="+this.id,
							container: "#gv-custgrp-list",
							timeout: 10,
					});'];
				//  return ['data-id' => $model->USER_ID];
		 },
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
					'attribute' => 'SCDL_GROUP_NM',
					'label'=>'Customer Groups',
					'hAlign'=>'left',
					'vAlign'=>'middle',
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'200px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'8pt',
							'background-color'=>'rgba(97, 211, 96, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'left',
							'width'=>'200px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'8pt',
						]
					],
				],
				[  	//col-2
					//CUSTOMER GRAOUP NAME
					'attribute' => 'KETERANGAN',
					'label'=>'Keterangan',
					'hAlign'=>'left',
					'vAlign'=>'middle',
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'200px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'8pt',
							'background-color'=>'rgba(97, 211, 96, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'left',
							'width'=>'200px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'8pt',
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
							'font-size'=>'8pt',
							'background-color'=>'rgba(97, 211, 96, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'80px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'8pt',
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
																['/master/schedule-group/view','id'=>$model->ID],[
																'data-toggle'=>"modal",
																'data-target'=>"#modal-view",
																'data-title'=> '',//$model->KD_BARANG,
																]). '</li>' . PHP_EOL;
							},
							'edit' =>function($url, $model, $key){
									return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Update'),
																['/master/schedule-group/update','id'=>$model->ID],[
																'data-toggle'=>"modal",
																'data-target'=>"#modal-create",
																'data-title'=>'',// $model->KD_BARANG,
																]). '</li>' . PHP_EOL;
							},
					],
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							//'width'=>'150px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'8pt',
							'background-color'=>'rgba(97, 211, 96, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'center',
							//'width'=>'150px',
							//'height'=>'10px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'8pt',
						]
					],

				],
			],
			'pjax'=>true,
			'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-listgroup-location',
			   ],
			],
			'panel' => [
						'heading'=>'<h3 class="panel-title" style="font-family:tahoma, arial, sans-serif;font-size:9pt;text-align:left;"><b>GROUPING CUSTOMER LOCALTIONS</b></h3>',
						'type'=>'warning',
						'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Group ',
								['modelClass' => 'Kategori',]),'/master/schedule-group/create',[
									'data-toggle'=>"modal",
										'data-target'=>"#modal-create",
											'class' => 'btn btn-success btn-sm'
														]).' '.
			Html::a('<i class="fa fa-history"></i> '.Yii::t('app', 'Refresh'),'',
								[
									
									'id'=>'refresh-group',
									'data-pjax' => true,
									'data-toggle-group-erp'=>'erp-group-refsehs',
									'class' => 'btn btn-info btn-sm'
								]
								),
						'showFooter'=>false,
			],
			'toolbar'=> [
				//'{items}',
			],
			'summary'=>false,
			'hover'=>true, //cursor select
			'responsive'=>true,
			'responsiveWrap'=>true,
			'bordered'=>true,
			'striped'=>'4px',
			'autoXlFormat'=>true,
			'export' => false,
		]);
?>

<?=$gvGroupListLocation?>

<?php

$this->registerJs("
$(document).on('click', '[data-toggle-group-erp]', function(e){

 e.preventDefault();

 $.pjax.reload({
				url: '/master/schedule-group/index',
	            container: '#gv-listgroup-location',
	            timeout: 100,
       });

})

// })

",$this::POS_READY);


?>