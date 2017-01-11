<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Json;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use kartik\tabs\TabsX;
use yii\widgets\ListView;
use yii\data\ArrayDataProvider;

use lukisongroup\roadsales\models\SalesRoadHeaderSearch;
use lukisongroup\sistem\models\Userlogin;

$this->sideCorp = 'PT.Effembi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'sales_road';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - SALES ROAD');          				/* title pada header page */
$this->params['breadcrumbs'][] = $this->title; 

	/* function AryUserSalesKAM()
    {
		$sql = Userlogin::find()->with('emp')->where('POSITION_ACCESS = 1 AND status <>1')->all();
		return ArrayHelper::map($sql,'id','username');
		
		// return ArrayHelper::map($sql,'username',function ($sql, $defaultValue) {
			// return $sql->emp->EMP_NM . ' - ' . $sql->emp->EMP_NM_BLK; });
    } */

	$userArray=ArrayHelper::map(Userlogin::find()->with('emp')->where('POSITION_ACCESS = 1 AND status <>1')->all(),'id','username');
	/**
	* COLUMN DATA.
	*/
	$columnRoadHeader=[
		/*No Urut*/
		[
			'class'=>'kartik\grid\SerialColumn',
			'contentOptions'=>['class'=>'kartik-sheet-style'],
			'width'=>'10px',
			'header'=>'No.',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		[
			'class'=>'kartik\grid\ExpandRowColumn',
			'width'=>'50px',
			'header'=>'Detail',
			'value'=>function ($model, $key, $index, $column) {
				return GridView::ROW_COLLAPSED;
			},
			'detail'=>function ($model, $key, $index, $column){
				$searchModelExpand = new SalesRoadHeaderSearch([
					'USER_ID'=>$model->USER_ID,
					//'CREATED_BY'=>$models->CREATED_BY,
					'TGL'=>$model->TGL
				]);
				$dataProviderExpand = $searchModelExpand->searchDetail(Yii::$app->request->queryParams);
				
				return Yii::$app->controller->renderPartial('indexExpand',[
					'dataProviderExpand'=>$dataProviderExpand,
					//'searchModelExpand'=>$searchModelExpand
				]); 
			},
			'collapseTitle'=>'Close Exploler',
			'expandTitle'=>'Click to views detail',
			
			//'headerOptions'=>['class'=>'kartik-sheet-style'] ,
			// 'allowBatchToggle'=>true,
			'expandOneOnly'=>true,
			// 'enableRowClick'=>true,
			//'disabled'=>true,
			'headerOptions'=>[
				'style'=>[
					
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(74, 206, 231, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
				
					'text-align'=>'center',
					'width'=>'10px',
					'height'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],		
		/*HARI*/
		[
			'attribute'=>'TGL',
			'label'=>'HARI',
			'hAlign'=>'center',
			'vAlign'=>'middle',
			'mergeHeader'=>true,
			'filter' =>false,
			'value'=>function($model){
				$nilaiHari= Yii::$app->formatter->asDate($model->TGL,'php:N');
				if ($nilaiHari==1){
					return "Senin";
				}elseif ($nilaiHari==2){
					return "Selasa";
				}elseif ($nilaiHari==3){
					return "Rabu";
				}elseif ($nilaiHari==4){
					return "Kamis";
				}elseif ($nilaiHari==5){
					return "Jumat";
				}elseif ($nilaiHari==6){
					return "Sabtu";
				}elseif ($nilaiHari==7){
					return "Minggu";
				}else{
					return $nilaiHari;
				}
			},
            'filterWidgetOptions' => [					
				'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',					 
                    'autoclose' => true,
                    'todayHighlight' => true,
					//'format' => 'dd-mm-yyyy hh:mm',
					'autoWidget' => false,
					//'todayBtn' => true,
                ]
            ],	
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'150px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'150px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*TGL*/
		[
			'attribute'=>'TGL',
			'label'=>'TGL',
			'hAlign'=>'center',
			'vAlign'=>'middle',
			//'group'=>true,
			//'filter'=>true,
			'filterType' => GridView::FILTER_DATE,
			'filterOptions'=>[
				'style'=>'id:test',
			 ],
            'filterWidgetOptions' => [					
				'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',					 
                    'autoclose' => true,
                    'todayHighlight' => true,
					//'format' => 'dd-mm-yyyy hh:mm',
					'autoWidget' => false,
					//'todayBtn' => true,
                ]
            ],	
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*USER*/
		[
			'attribute'=>'USER_ID',
			'label'=>'Employee',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'mergeHeader'=>true,
			'filter' => $userArray,
			/* 'filter'=>true,
			'filterType'=>GridView::FILTER_SELECT2,
			'filter' => $userArray,
			'filterWidgetOptions'=>[
				'pluginOptions'=>[
					'allowClear'=>true,
					'contentOptions'=>[
						'style'=>[
						  'text-align'=>'left',
						  'font-family'=>'tahoma, arial, sans-serif',
						  'font-size'=>'8pt',
						]	
					]
				],
			],  */
			'value'=>function($model){
				return $model->username;
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'100px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'100px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],		
		[
			'class'=>'kartik\grid\ActionColumn',
			//'dropdown' => false,
			'template' => '{view}',
			//'dropdownOptions'=>['class'=>'pull-right dropup'],	
			//'dropdownButton'=>['class'=>'btn btn-default btn-lg'],
			'buttons' => [
					'view' =>function($url, $model, $key){
							return  Html::a('<span class="fa fa-eye fa-lg"></span>'.Yii::t('app', ''),
														['/roadsales/header/view-detail','tgl'=>$model->TGL,'user'=>$model->USER_ID],[
														'data-toggle'=>"modal",
														'data-target'=>"#modal-view-header",
														]);
					},
			],
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],				
		], 
	];

	/*
	 * GRIDVIEW ROAD LIST
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	$_gvRoadHeader= GridView::widget([
		'id'=>'gv-road-header',
		'dataProvider'=> $dataProvider,
		'filterModel' => $searchModel,
		'filterRowOptions'=>['style'=>'background-color:rgba(214, 255, 138, 1); align:center'],
		'columns' =>$columnRoadHeader,		
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-road-header',
			   ],
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
		'toolbar'=> ['',
				//['content'=>''],
				//'{export}',
				//'{toggleData}',
				
			],
		'panel'=>[
			'type'=>GridView::TYPE_INFO,
			'heading'=>"<span class='fa fa-motorcycle fa-xs'><b> Sales Road</b></span>",
			'type'=>'info',
			'before'=> false,								
			'footer'=>false,
		],
		'floatOverflowContainer'=>true,
		'floatHeader'=>true,
	]);
?>
<div class="content">
  <div  class="row" style="padding:10px;padding-left:3px ">
		<div class="col-xs-12 col-sm-12 col-lg-12" style="font-family: tahoma ;font-size: 9pt;">
			<?=$_gvRoadHeader?>
		</div>
	</div>
</div>

<?php
	Modal::begin([
			'id' => 'modal-view',
			'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-file-image-o"></div><div><h5 class="modal-title"><b>VIEWS IMAGE</b></h5></div>',
			'size' => Modal::SIZE_LARGE,
			'headerOptions'=>[
					'style'=> 'border-radius:5px; background-color: rgba(113, 235, 29, 0.8)',
			]
	]);
	echo "<div id='modalContent' style='min-height:500px'></div>";
	Modal::end();	
	
	
	$this->registerJs("
         $('#modal-view-header').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            var title = button.data('title') 
            var href = button.attr('href') 
            //modal.find('.modal-title').html(title)
            modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
            $.post(href)
                .done(function( data ) {
                    modal.find('.modal-body').html(data)
                });
            })
    ",$this::POS_READY);
	
	Modal::begin([
			'id' => 'modal-view-header',
			'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-map-o"></div><div><h5 class="modal-title"><b>DETAIL VIEWS</b></h5></div>',
			'size' => Modal::SIZE_LARGE,
			'headerOptions'=>[
					'style'=> 'border-radius:5px; background-color: rgba(113, 235, 29, 0.8)',
			]
	]);
	Modal::end();	
?>