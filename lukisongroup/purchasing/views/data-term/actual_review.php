<?php
/*extensions */
use kartik\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use yii\db\ActiveRecord;
use yii\data\ArrayDataProvider;

/* namespace models*/
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Termcustomers;
use lukisongroup\master\models\Distributor;
use lukisongroup\hrd\models\Corp;


$this->sideCorp = 'ESM-Trading Terms';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_trading_term';               /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Trading Terms ');
?>

<?php
	/*
	 * Tombol List Acount INVESTMENT
	 * No Permission
	*/
	function tombolInvestInput($id){
		$title = Yii::t('app', 'Investment input');
		$options = ['id'=>'input-invest',
					'data-toggle'=>"modal",
					'data-target'=>"#input-invest-actual",
					'class' => 'btn btn-info btn-sm'
		];
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/data-term/actual-review-add','id'=>$id]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

$id_term = $_GET['id'];





	/*
	 * GRID DETAIL BUDGET
	 * Table [t0001header,t0001detail]
	 * Input Status -> Direct=1 | Request=0
	*/
	$attDinamikInputActual =[];
	/*GRIDVIEW ARRAY FIELD HEAD*/
	$headColomnInputActual=[
		// ['ID' =>0, 'ATTR' =>['FIELD'=>'KD_RIB','SIZE' => '50px','label'=>'Trade Investment','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>0, 'ATTR' =>['FIELD'=>'nminvest','SIZE' => '10px','label'=>'Type Investasi','align'=>'left','warna'=>'126, 189, 188, 0.9','GRP'=>false,'filter'=>true,'filterType'=>true,'filterwarna'=>'126, 189, 188, 0.9']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'INVESTASI_PROGRAM','SIZE' => '10px','label'=>'Keterangan','align'=>'left','warna'=>'126, 189, 188, 0.9','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'STORE_ID','SIZE' => '10px','label'=>'Toko','align'=>'left','warna'=>'126, 189, 188, 0.9','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>true,'filterwarna'=>'126, 189, 188, 0.9']],
		['ID' =>3, 'ATTR' =>['FIELD'=>'PERIODE_START','SIZE' => '10px','label'=>'periode start','align'=>'left','warna'=>'126, 189, 188, 0.9','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>true,'filterwarna'=>'126, 189, 188, 0.9']],
		['ID' =>4, 'ATTR' =>['FIELD'=>'PERIODE_END','SIZE' => '10px','label'=>'periode end','align'=>'left','warna'=>'126, 189, 188, 0.9','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>true,'filterwarna'=>'126, 189, 188, 0.9']],
		['ID' =>5, 'ATTR' =>['FIELD'=>'NOMER_FAKTURPAJAK','SIZE' => '10px','label'=>'Nomer Faktur','align'=>'left','warna'=>'126, 189, 188, 0.9','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
		['ID' =>6, 'ATTR' =>['FIELD'=>'NOMER_INVOCE','SIZE' => '10px','label'=>'Nomer Invoice','align'=>'left','warna'=>'126, 189, 188, 0.9','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
		['ID' =>7, 'ATTR' =>['FIELD'=>'HARGA','SIZE' => '10px','label'=>'Biaya','align'=>'left','warna'=>'126, 189, 188, 0.9','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
		['ID' =>8, 'ATTR' =>['FIELD'=>'PPN','SIZE' => '10px','label'=>'Ppn','align'=>'left','warna'=>'126, 189, 188, 0.9','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
		['ID' =>9, 'ATTR' =>['FIELD'=>'PPH23','SIZE' => '10px','label'=>'PPH 23','align'=>'left','warna'=>'126, 189, 188, 0.9','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
		['ID' =>10, 'ATTR' =>['FIELD'=>'total','SIZE' => '10px','label'=>'Total','align'=>'left','warna'=>'126, 189, 188, 0.9','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
	];
	$gvHeadColomnInputActual = ArrayHelper::map($headColomnInputActual, 'ID', 'ATTR');
	/*GRIDVIEW SERIAL ROWS*/
	$attDinamikInputActual[] =[
		'class'=>'kartik\grid\SerialColumn',
		// 'contentOptions'=>['class'=>'kartik-sheet-style'],
		'width'=>'10px',
		'header'=>'No.',
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		],
	];
	/*GRIDVIEW ARRAY ROWS*/
	foreach($gvHeadColomnInputActual as $key =>$value[]){
		if($value[$key]['FIELD'] == 'total')
		{
			$attDinamikInputActual[]=[
				'attribute'=>$value[$key]['FIELD'],
				'value' => function($model) {

					$total_pp23 = ($model->HARGA*$model->PPH23)/100;
					$total_ppn =  ($model->HARGA*$model->PPN)/100;

						$total = ($total_ppn + $model->HARGA)-$total_pp23 ;

					//return $model->PERIODE_START . " - " . $model->PERIODE_END;
					return number_format($total,2);
				},
				'label'=>$value[$key]['label'],
				'filterType'=>$value[$key]['filterType'],
				'filter'=>$value[$key]['filter'],
				// 'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
				'hAlign'=>'right',
				'vAlign'=>'middle',
				//'mergeHeader'=>true,
				// 'noWrap'=>true,
				'group'=>$value[$key]['GRP'],
				// 'format'=>$value[$key]['FORMAT'],
				'headerOptions'=>[
						'style'=>[
						'text-align'=>'center',
						'width'=>$value[$key]['FIELD'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(74, 206, 231, 1)',
						'background-color'=>'rgba('.$value[$key]['warna'].')',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>$value[$key]['align'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(13, 127, 3, 0.1)',
					]
				],
			];
			/*GRIDVIEW ARRAY ACTION*/
			$actionClass='btn btn-info btn-xs';
			$actionLabel='Action';
			$attDinamikInputActual[]=[
				'class'=>'kartik\grid\ActionColumn',
				'dropdown' => true,
				'template' => '{edit}{delete}{view}',
				'dropdownOptions'=>['class'=>'pull-right dropup','style'=>['disable'=>true]],
				'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
				'dropdownButton'=>[
					'class' => $actionClass,
					'label'=>$actionLabel,
					'caret'=>'<span class="caret"></span>',
				],
				 'buttons' => [
					 'edit' =>function($url, $model, $key)use($id_term){
							 return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Edit'),
														 ['update-term','id'=>$model->KD_RIB,'kd_term'=>$id_term],[
														 'data-toggle'=>"modal",
														 'data-target'=>"#modal-update",
														 ]). '</li>' . PHP_EOL;
					 },
					 'delete' =>function($url, $model, $key)use($id_term){
							 return  '<li>' . Html::a('<span class="fa fa-trash fa-dm"></span>'.Yii::t('app', 'delete'),
														 ['delete-actual','id'=>$id_term,'kd'=>$model->KD_RIB],[
														 ]). '</li>' . PHP_EOL;
													 },
					 'view' =>function($url, $model, $key)use($id_term){
							return  '<li>' .Html::a('<span class="fa fa-eye "></span>'.Yii::t('app', 'view'),
														['/purchasing/data-term/actual-view','id'=>$model->KD_RIB,'kd_term'=>$id_term],[
														 'data-toggle'=>"modal",
														 'data-target'=>"#modal-update",
														]). '</li>' . PHP_EOL ;
					}
				],
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(126, 189, 188, 0.9)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'height'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			];
		}elseif($value[$key]['FIELD'] == 'PPH23'){

			$attDinamikInputActual[]=[
				'attribute'=>$value[$key]['FIELD'],
				'value' => function($model) {

					if($model->PPH23)
					{
						return $model->PPH23;
					}else{
						return '0';
					}
					//return $model->PERIODE_START . " - " . $model->PERIODE_END;
					
				},
				'label'=>$value[$key]['label'],
				'filterType'=>$value[$key]['filterType'],
				'filter'=>$value[$key]['filter'],
				// 'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
				'hAlign'=>'right',
				'vAlign'=>'middle',
				//'mergeHeader'=>true,
				// 'noWrap'=>true,
				'group'=>$value[$key]['GRP'],
				// 'format'=>$value[$key]['FORMAT'],
				'headerOptions'=>[
						'style'=>[
						'text-align'=>'center',
						'width'=>$value[$key]['FIELD'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(74, 206, 231, 1)',
						'background-color'=>'rgba('.$value[$key]['warna'].')',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>$value[$key]['align'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(13, 127, 3, 0.1)',
					]
				],
			];

		}elseif($value[$key]['FIELD'] == 'HARGA'){


			$attDinamikInputActual[]=[
				'attribute'=>$value[$key]['FIELD'],
				'value' => function($model) {

					return number_format($model->HARGA,2);
					
				},
				'label'=>$value[$key]['label'],
				'filterType'=>$value[$key]['filterType'],
				'filter'=>$value[$key]['filter'],
				// 'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
				'hAlign'=>'right',
				'vAlign'=>'middle',
				//'mergeHeader'=>true,
				// 'noWrap'=>true,
				'group'=>$value[$key]['GRP'],
				// 'format'=>$value[$key]['FORMAT'],
				'headerOptions'=>[
						'style'=>[
						'text-align'=>'center',
						'width'=>$value[$key]['FIELD'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(74, 206, 231, 1)',
						'background-color'=>'rgba('.$value[$key]['warna'].')',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>$value[$key]['align'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(13, 127, 3, 0.1)',
					]
				],
			];

		}elseif($value[$key]['FIELD'] == 'PERIODE_START'){
			$attDinamikInputActual[]=[
							/* Attribute */
							'class'=>'kartik\grid\EditableColumn',
							'attribute'=>$value[$key]['FIELD'],
							'refreshGrid'=>true,
							'label'=>$value[$key]['label'],

							'vAlign'=>'middle',
							'hAlign'=>'center',
							'filterType'=>GridView::FILTER_DATE,
							'filter'=>$value[$key]['filter'],
							'filterWidgetOptions'=>[
								'pluginOptions' => [
				        				'autoclose'=>true,
				        			'format' => 'yyyy-mm-dd'
				    				],
							],
							// 'mergeHeader'=>true,
							// 'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
							// 	//return (101 == $model->STATUS || 10 == $model->STATUS  || 3 == $model->STATUS  || 4 == $model->STATUS);// or 101 == $roHeader->STATUS);
							// 	return (0 <> $model->STATUS || 103==$headerStatus); // Allow Status Process = 0);
							// },
							'editableOptions' => [
								'header' => 'Update periode',
								'inputType' => \kartik\editable\Editable::INPUT_DATE,
								'size' => 'sm',
								'options' => [
									'pluginOptions' => ['todayHighlight' => true,
                            		'autoclose'=>true,
                              		'format' => 'yyyy-m-dd']
								]
							],
								'headerOptions'=>[
								'style'=>[
								'text-align'=>'center',
								'width'=>$value[$key]['FIELD'],
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								//'background-color'=>'rgba(74, 206, 231, 1)',
								'background-color'=>'rgba('.$value[$key]['warna'].')',
							]
						],
							'contentOptions'=>[
								'style'=>[
									'text-align'=>'left',
									'width'=>'220px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
								]
							],
						];
		}elseif($value[$key]['FIELD'] == 'PERIODE_END'){
			$attDinamikInputActual[]=[
							/* Attribute */
							'class'=>'kartik\grid\EditableColumn',
							'attribute'=>$value[$key]['FIELD'],
							'refreshGrid'=>true,
							'label'=>$value[$key]['label'],
							'vAlign'=>'middle',
							'hAlign'=>'center',
							'filterType'=>GridView::FILTER_DATE,
							'filter'=>$value[$key]['filter'],
							'filterWidgetOptions'=>[
								'pluginOptions' => [
				        				'autoclose'=>true,
				        			'format' => 'yyyy-mm-dd'
				    				],
							],
							// 'mergeHeader'=>true,
							// 'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
							// 	//return (101 == $model->STATUS || 10 == $model->STATUS  || 3 == $model->STATUS  || 4 == $model->STATUS);// or 101 == $roHeader->STATUS);
							// 	return (0 <> $model->STATUS || 103==$headerStatus); // Allow Status Process = 0);
							// },
							'editableOptions' => [
								'header' => 'Update periode',
								'inputType' => \kartik\editable\Editable::INPUT_DATE,
								'size' => 'sm',
								'options' => [
									'pluginOptions' => ['todayHighlight' => true,
                            		'autoclose'=>true,
                              		'format' => 'yyyy-m-dd']
								]
							],
								'headerOptions'=>[
								'style'=>[
								'text-align'=>'center',
								'width'=>$value[$key]['FIELD'],
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								//'background-color'=>'rgba(74, 206, 231, 1)',
								'background-color'=>'rgba('.$value[$key]['warna'].')',
							]
						],
							'contentOptions'=>[
								'style'=>[
									'text-align'=>'left',
									'width'=>'220px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
								]
							],
						];
		}elseif($value[$key]['FIELD'] == 'STORE_ID'){
			$attDinamikInputActual[]=[
							/* Attribute */
							'class'=>'kartik\grid\EditableColumn',
							'attribute'=>$value[$key]['FIELD'],
							// 'refreshGrid'=>true,
							'label'=>$value[$key]['label'],
							'vAlign'=>'middle',
							'hAlign'=>'center',
							'filterType'=>GridView::FILTER_SELECT2,
								'filter' =>$data_toko,
							    'filterWidgetOptions'=>[
							      'pluginOptions'=>['allowClear'=>true],
							    ],
    						'filterInputOptions'=>['placeholder'=>'Pilih'],
							// 'mergeHeader'=>true,
							// 'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
							// 	//return (101 == $model->STATUS || 10 == $model->STATUS  || 3 == $model->STATUS  || 4 == $model->STATUS);// or 101 == $roHeader->STATUS);
							// 	return (0 <> $model->STATUS || 103==$headerStatus); // Allow Status Process = 0);
							// },
							'editableOptions' => [
								'header' => 'Update Toko',
								'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
								'size' => 'xs',
							'options' => [
							  'data' =>$data_toko,
							  'pluginOptions' => [
								'allowClear' => true,
								
							  ],
							],    
								// Refresh Display
								'displayValueConfig' => $data_toko,
								],
								'headerOptions'=>[
								'style'=>[
								'text-align'=>'center',
								'width'=>$value[$key]['FIELD'],
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								//'background-color'=>'rgba(74, 206, 231, 1)',
								'background-color'=>'rgba('.$value[$key]['warna'].')',
							]
						],

							'contentOptions'=>[
								'style'=>[
									'text-align'=>'left',
									'width'=>'220px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
								]
							],

						// ],
					];
		}elseif($value[$key]['FIELD'] == 'nminvest'){
			$attDinamikInputActual[]=[
							/* Attribute */
							// 'class'=>'kartik\grid\EditableColumn',
							'attribute'=>$value[$key]['FIELD'],
							// 'refreshGrid'=>true,
							'label'=>$value[$key]['label'],
							
							'hAlign'=>'left',
     					 	'vAlign'=>'top',
							'filterType'=>GridView::FILTER_SELECT2,
								'filter' =>$data_invest,
							    'filterWidgetOptions'=>[
							      'pluginOptions'=>['allowClear'=>true],
							    ],
    						'filterInputOptions'=>['placeholder'=>'Pilih'],
    						'filterOptions'=>[
									'colspan'=>2,
			 				 ],

							// 'mergeHeader'=>true,
							// 'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
							// 	//return (101 == $model->STATUS || 10 == $model->STATUS  || 3 == $model->STATUS  || 4 == $model->STATUS);// or 101 == $roHeader->STATUS);
							// 	return (0 <> $model->STATUS || 103==$headerStatus); // Allow Status Process = 0);
							// },
							// 'editableOptions' => [
							// 	'header' => 'Update Toko',
							// 	'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
							// 	'size' => 'xs',
							// 'options' => [
							//   'data' =>$data_toko,
							//   'pluginOptions' => [
							// 	'allowClear' => true,
								
							//   ],
							// ],    
							// 	// Refresh Display
							// 	'displayValueConfig' => $data_toko,
							// 	],
								'headerOptions'=>[
								'style'=>[
								'text-align'=>'center',
								'width'=>$value[$key]['FIELD'],
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								//'background-color'=>'rgba(74, 206, 231, 1)',
								'background-color'=>'rgba('.$value[$key]['warna'].')',
							]
						],

							'contentOptions'=>[
								'style'=>[
									'text-align'=>'left',
									'width'=>'120px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
								]
							],

						// ],
					];
		}elseif($value[$key]['FIELD'] == 'INVESTASI_PROGRAM'){
			$attDinamikInputActual[]=[
				'attribute'=>$value[$key]['FIELD'],
				'label'=>$value[$key]['label'],
				'filterType'=>$value[$key]['filterType'],
				'filter'=>$value[$key]['filter'],
				'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
				 'hAlign'=>'left',
      			'vAlign'=>'top',
				'mergeHeader'=>true,
				// 'filter'=>true,
				// 'noWrap'=>true,
				'group'=>$value[$key]['GRP'],
				// 'format'=>$value[$key]['FORMAT'],
				'headerOptions'=>[
						'style'=>[
						'text-align'=>'center',
						'width'=>$value[$key]['FIELD'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(74, 206, 231, 1)',
						'background-color'=>'rgba('.$value[$key]['warna'].')',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>$value[$key]['align'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(13, 127, 3, 0.1)',
					],
				],

			];

		}else{
			$attDinamikInputActual[]=[
				'attribute'=>$value[$key]['FIELD'],
				'label'=>$value[$key]['label'],
				'filterType'=>$value[$key]['filterType'],
				'filter'=>$value[$key]['filter'],
				// 'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
				'hAlign'=>'right',
				'vAlign'=>'middle',
				// 'mergeHeader'=>true,
				// 'noWrap'=>true,
				'group'=>$value[$key]['GRP'],
				// 'format'=>$value[$key]['FORMAT'],
				'headerOptions'=>[
						'style'=>[
						'text-align'=>'center',
						'width'=>$value[$key]['FIELD'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(74, 206, 231, 1)',
						'background-color'=>'rgba('.$value[$key]['warna'].')',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>$value[$key]['align'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(13, 127, 3, 0.1)',
					]
				],
			];
		}

	};
	/*GRID VIEW BASE*/
	$gvDetalInputActual= GridView::widget([
		'id'=>'input-actual-budget-id',
		'dataProvider' => $dataProviderRdetail,
		'filterModel' => $searchModelRdetail,
		'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.9); align:center'],
		// 'filterRowOptions'=>['style'=>'background-color:rgba(74, 206, 231, 1); align:center'],
		/* 'beforeHeader'=>[
			[
				'columns'=>[
					['content'=>'ITEMS TRAIDE INVESTMENT', 'options'=>['colspan'=>3,'class'=>'text-center info',]],
					['content'=>'PLAN BUDGET', 'options'=>['colspan'=>2, 'class'=>'text-center info']],
					['content'=>'ACTUAL BUDGET', 'options'=>['colspan'=>2, 'class'=>'text-center info']],
					['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center info']],
					//['content'=>'Action Status ', 'options'=>['colspan'=>1,  'class'=>'text-center info']],
				],
			]
		], */
		'columns' => $attDinamikInputActual,
		/* [
			['class' => 'yii\grid\SerialColumn'],
			'start',
			'end',
			'title',
			['class' => 'yii\grid\ActionColumn'],
		], */
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'input-actual-budget-id',
			],
		],
		'panel' => [
					'heading'=>'<h3 class="panel-title" style="font-family: verdana, arial, sans-serif ;font-size: 9pt;">Actual Budget Proccess</h3>',
					'type'=>'info',
					//'showFooter'=>false,
		],
		'summary'=>false,
		'toolbar'=>false,
		'panel'=>false,
		// 'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
	]);
?>


<div class="content" >
	<!-- HEADER !-->
	<div  class="row">
		<div class="col-lg-12">
				<!-- HEADER !-->
				<div class="col-md-1" style="float:left;">
					<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
				</div>
				<div class="col-md-9">
					<h4 class="text-center"><b> <?php echo 'ACTUAL BUDGET';  ?> </b></h4>

					<h4 class="text-center"><b> <?php echo ucwords($model->NmCustomer)  ?> </b></h4>
				</div>
				<div class="col-md-12">
					<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
				</div>
		</div>
	</div>
		<!-- PARTIES/PIHAK !-->
		<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="font-family: tahoma ;font-size: 8pt">
			<dl>
				<dt><u><b>PARTIES/PIHAK BERSANGKUTAN :</b></u></dt>

				<dd>1 :	<?= $model->NmCustomer ?></dd>


				<dd>2 :	<?= $model->Nmprincipel ?></dd>


				<dd>3 :	<?= $model->NmDis ?></dd>
			</dl>
		</div>

		<!-- PERIODE/JANGKA WAKTU !-->
		<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="font-family: tahoma ;font-size: 8pt;padding-left:30px">
			<div>
				<?php //echo periode($model); ?>
			</div>
			<dl>
				<dt><u><b>PERIODE/JANGKA WAKTU :</b></u></dt>
				<dt style="width:80px; float:left;"> Dari: </dt>
				<dd>:	<?=$model->PERIOD_START ?></dd>

				<dt style="width:80px; float:left;">Sampai:</dt>
				<dd>:	<?=$model->PERIOD_END ?></dd>
			</dl>
		</div>


<?php
$url = "/purchasing/data-term/review?id=".$model->TERM_ID."&cus_kd=".$model->CUST_KD_PARENT."";

?>
	<!-- GRID VIEW !-->
	<div  class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<div style="margin-bottom:5px;margin-right:5px">
			<?=tombolInvestInput($model->TERM_ID);?>
			<a href=<?php echo $url ?> class="btn btn-info btn-sm" role="button" style="width:90px">Kembali</a>
			<?= Html::a('<i class="fa fa-history "></i> '.Yii::t('app', 'Refresh',
					['modelClass' => 'Rtdetail',]),'/purchasing/data-term/actual-review?id='.$model->TERM_ID,[
									   'id'=>'erp-data-term-id',
									   'data-pjax' => 0,
									   'class' => 'btn btn-info btn-sm'
									  ]) ?>

	        <?= Html::a('<i class="fa fa-file-excel-o"></i> '.Yii::t('app', 'Export',
					// ['modelClass' => 'Rtdetail',]),'/export/export/export-data-investasi?id='.$model->TERM_ID,[
	        	['modelClass' => 'Rtdetail',]),'/export/export/export-data-investasi?id='.$model->TERM_ID,[
									   'id'=>'erp-data-term-export-id',
									   'data-pjax' => true,
									   'class' => 'btn btn-info btn-sm'
									  ]) ?>
				
			</div>
			<?=$gvDetalInputActual?>
		</div>
	</div>
</div><!-- Body !-->

<?php
	$this->registerJs("
	   $.fn.modal.Constructor.prototype.enforceFocus = function(){};
	   $('#input-invest-actual').on('show.bs.modal', function (event) {
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
	    'id' => 'input-invest-actual',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Actual Investment</h4></div>',
		'headerOptions'=>[
		  'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
		],
	]);
	Modal::end();

	$this->registerJs("
		 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
		 $('#modal-update').on('show.bs.modal', function (event) {
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
			'id' => 'modal-update',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Actual Investment</h4></div>',
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
		],
	]);
	Modal::end();
?>
