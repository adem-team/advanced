<?php
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
use dosamigos\gallery\Gallery;

// use dashboard\assets\AppAssetFusionChart;
// AppAssetFusionChart::register($this);
use lukisongroup\master\models\ReviewHeaderSearch;
use lukisongroup\master\models\CustomercallTimevisitSearch;
use lukisongroup\master\models\CustomerVisitImageSearch;
use lukisongroup\master\models\CustomercallExpiredSearch;
use lukisongroup\master\models\CustomercallMemoSearch;
use lukisongroup\master\models\ReviewInventorySearch;

$this->sideCorp = 'PT.Effembi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_customers';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Produk');          				/* title pada header page */
$this->params['breadcrumbs'][] = $this->title;   


	function toMenuAwal(){
		$title = Yii::t('app', 'Back Menu');
		$options = ['id'=>'back-menu',
					'class' => 'btn btn-default btn-sm'
		];
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/efenbi/report']);
		$content = Html::a($label,$url, $options);
		return $content;
	}
	
	function toExportExcel(){
		$title = Yii::t('app', 'Excel');
		$options = ['id'=>'export-excel',
					'class' => 'btn btn-default btn-sm'
		];
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['#']);
		$content = Html::a($label,$url, $options);
		return $content;
	}
	

	//print_r($nmGroup);
	/*
	 * DAILY CUSTOMERS VISIT
	 * @author ptrnov  [piter@lukison.com]
	 * @since 1.2
	*/
	$actionClass='btn btn-info btn-xs';
	$actionLabel='View';
	$attDinamik =[];
	/*GRIDVIEW ARRAY FIELD HEAD*/
	$headColomnEvent=[
		['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'DATE','align'=>'center','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>true,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'USER_NM','SIZE' => '10px','label'=>'USER NAME','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'SCDL_GRP_NM','SIZE' => '10px','label'=>'SCHEDULE','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>3, 'ATTR' =>['FIELD'=>'TIME_DAYSTART','SIZE' => '10px','label'=>'START TIME','align'=>'center','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['TIME_DAYSTART']!=''?$models['TIME_DAYSTART']:"<span class='fa fa-remove fa-1x'></span>";}]],
		['ID' =>4, 'ATTR' =>['FIELD'=>'TIME_DAYEND','SIZE' => '10px','label'=>'END TIME','align'=>'center','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['TIME_DAYEND']!=''?$models['TIME_DAYEND']:"<span class='fa fa-remove fa-1x'></span>";}]],
	];
	$gvHeadColomn = ArrayHelper::map($headColomnEvent, 'ID', 'ATTR');
	if ($dataProviderHeader1){
		/*GRIDVIEW EXPAND*/
		$attDinamik[]=[	
			'class'=>'kartik\grid\ExpandRowColumn',
			'width'=>'50px',
			'header'=>'Detail',
			'value'=>function ($model, $key, $index, $column) {
				return GridView::ROW_COLLAPSED;
			},
			'detail'=>function ($model, $key, $index, $column){
				$searchModelTime = new CustomercallTimevisitSearch(['TGL'=>$model['TGL'],'USER_ID'=>$model['USER_ID']]);
				$searchModelStock= new ReviewInventorySearch(['TGL'=>$model['TGL'],'USER_ID'=>$model['USER_ID'],'SO_TYPE'=>'5']);
				$searchModelRequest= new ReviewInventorySearch(['TGL'=>$model['TGL'],'USER_ID'=>$model['USER_ID'],'SO_TYPE'=>'9']);
				$searchModelReture= new ReviewInventorySearch(['TGL'=>$model['TGL'],'USER_ID'=>$model['USER_ID'],'SO_TYPE'=>'8']);
				$searchModelSellIN= new ReviewInventorySearch(['TGL'=>$model['TGL'],'USER_ID'=>$model['USER_ID'],'SO_TYPE'=>'6']);
				$searchModelSellOut= new ReviewInventorySearch(['TGL'=>$model['TGL'],'USER_ID'=>$model['USER_ID'],'SO_TYPE'=>'7']);
				
				$dataProvider=$searchModelTime->search(Yii::$app->request->queryParams);
				// USER INFO
				$dataProviderInfo = $dataProvider->getModels();			
				//VISIT TIME
				$dataProviderTime = $dataProvider;			
				// IMAGE VISIT 
				$dataProviderImage = $dataProvider;						
				// IVENTORY STOCK|RETURE|REQUEST|SELL_IN|SELL_OUT
				$inventoryProvider= new ArrayDataProvider([
					// 'allModels'=>Yii::$app->db_esm->createCommand("CALL ERP_CUSTOMER_VISIT_inventory('".$model['TGL']."','".$model['CUST_ID']."','".$model['USER_ID']."')")->queryAll(),
					  'allModels'=>Yii::$app->db_esm->createCommand("
							SELECT (SELECT DISTINCT NM_BARANG FROM b0001 WHERE KD_BARANG=so_t2.KD_BARANG) AS NAME_ITEM, 
										 SUM(CASE WHEN SO_TYPE=5 THEN SO_QTY ELSE 0 END) as STOCK,								    
										 SUM(CASE WHEN SO_TYPE=6 THEN SO_QTY ELSE 0 END) as SELL_IN,
										 SUM(CASE WHEN SO_TYPE=7 THEN SO_QTY ELSE 0 END) as SELL_OUT,
										 SUM(CASE WHEN SO_TYPE=8 THEN SO_QTY ELSE 0 END) as RETURE,									 
										 SUM(CASE WHEN SO_TYPE=9 THEN SO_QTY ELSE 0 END) as REQUEST	
							FROM so_t2
							WHERE TGL='".$model['TGL']."' AND USER_ID='".$model['USER_ID']."'  GROUP BY	 KD_BARANG
						")->queryAll(),
					  'pagination' => [
						'pageSize' =>50,
					] 
				]);
				
				//EXPIRED DETAIL
				$searchModelExpired = new CustomercallExpiredSearch(['TGL_KJG'=>$model['TGL'],'USER_ID'=>$model['USER_ID']]);
				$dataProviderExpired=$searchModelExpired->searchReport(Yii::$app->request->queryParams);
				
				//MEMO DETAIL
				$searchModelMemo = new CustomercallMemoSearch(['TGL'=>$model['TGL'],'ID_USER'=>$model['USER_ID']]);
				$dataProviderMemo=$searchModelMemo->search(Yii::$app->request->queryParams);
				
				/* DETAIL & SUMMARY */
				
				

				//'SUMMARY_ALL','2016-05-31','','30','1'
				$aryProviderDetailSummary='';
				// $aryProviderDetailSummary= new ArrayDataProvider([
					////'allModels'=>Yii::$app->db_esm->createCommand("REPORT_CUSTOMERCALL_DETAIL_INVENTORY('SUMMARY_ALL','".$model['TGL']."','','".$model['USER_ID']."','1')")->queryAll(),
					// 'allModels'=>Yii::$app->db_esm->createCommand("CALL MOBILE_CUSTOMER_VISIT_inventory_summary('SUMMARY_ALL','2016-05-31','','30','1');")->queryAll(),
					  // 'pagination' => [
						// 'pageSize' =>50,
					// ] 
				// ]); 
				
				
				/**
				 * DETAIL STOCK - Per Customer
				 * ROW to COLUMN
				 * @author piter novian [ptr.nov@gmail.com]
				*/	
				$aryDataStock=$searchModelStock->search(Yii::$app->request->queryParams);			//AR ArrayDataProvider
				$dataModelStock=$aryDataStock->allModels; 											//Set ArrayProvider to Array	
				$dataMapStock =  ArrayHelper::map($dataModelStock, 'NM_BARANG','SO_QTY','CUST_NM');	//Get index string	
				$dataIndexStock =  ArrayHelper::index($dataModelStock, 'CUST_NM');					//Get index string	
				$StockMergeRowColumn= ArrayHelper::merge($dataIndexStock,$dataMapStock);			//index string Merge / Like Join index	
				$StockIndexVal=array_values($StockMergeRowColumn); 									//index string to int
				//$aryProviderDetailStock ='';
				$aryProviderDetailStock= new ArrayDataProvider([
					'allModels'=>$StockIndexVal,
					'pagination' => [
						'pageSize' => 50,
					]
				]);
				//$aryProviderHeaderStock='';
				/**
				 * Foreach to get All column form rows
				 * @author piter novian [ptr.nov@gmail.com]
				*/
				$getHeaderStck=[];
				foreach($StockIndexVal as $key => $value){
					$getHeaderStck=ArrayHelper::merge($getHeaderStck,$StockIndexVal[$key]);
				};
				
				/**
				 * Foreach to get All column Then remove Column selected
				 * @author piter novian [ptr.nov@gmail.com]
				*/
				$splitHeaderStck=[];
				foreach($getHeaderStck as $ky => $value){
					//$splitHeaderStck=ArrayHelper::merge($splitHeaderStck, array_splice($getHeaderStck, 3, 2));
					$splitHeaderStck=ArrayHelper::merge($splitHeaderStck, array_diff_key($getHeaderStck,[
						'TGL'=>'','USER_ID'=>'','SCDL_GROUP'=>'','KD_BARANG'=>'','NM_BARANG'=>'','SO_TYPE'=>'','SO_QTY'=>''
					]));
				};			
				$aryProviderHeaderStock=$splitHeaderStck;	
				
				//print_r($dataStock->allModels[0]);	
				// $aryProviderDetailStock = new ArrayDataProvider([
					// 'allModels'=>Yii::$app->db_esm->createCommand("CALL REPORT_CUSTOMERCALL_DETAIL_INVENTORY('SUMMARY_STOCK_ITEM_CUST','".$model['TGL']."','','".$model['USER_ID']."','".$model['SCDL_GROUP']."');")->queryAll(),
					// 'pagination' => [
						// 'pageSize' =>50,
					// ] 
				// ]); 
				
				/**
				 * DETAIL REQUEST ORDER - Per Customer
				 * ROW to COLUMN
				 * @author piter novian [ptr.nov@gmail.com]
				*/	
				$aryDataRequest=$searchModelRequest->search(Yii::$app->request->queryParams);			//AR ArrayDataProvider
				$dataModelRequest=$aryDataRequest->allModels; 											//Set ArrayProvider to Array	
				$dataMapRequest =  ArrayHelper::map($dataModelRequest, 'NM_BARANG','SO_QTY','CUST_NM');	//Get index string	
				$dataIndexRequest =  ArrayHelper::index($dataModelRequest, 'CUST_NM');					//Get index string	
				$RequestMergeRowColumn= ArrayHelper::merge($dataIndexRequest,$dataMapRequest);			//index string Merge / Like Join index	
				$RequestIndexVal=array_values($RequestMergeRowColumn); 									//index string to int
				//$aryProviderDetailRequest ='';
				$aryProviderDetailRequest= new ArrayDataProvider([
					'allModels'=>$RequestIndexVal,
					'pagination' => [
						'pageSize' => 50,
					]
				]);				
				//$aryProviderHeaderRequest='';
				/**
				 * Foreach to get All column form rows
				 * @author piter novian [ptr.nov@gmail.com]
				*/
				$getHeaderRequest=[];
				foreach($RequestIndexVal as $key => $value){
					$getHeaderRequest=ArrayHelper::merge($getHeaderRequest,$RequestIndexVal[$key]);
				};
				
				/**
				 * Foreach to get All column Then remove Column selected
				 * @author piter novian [ptr.nov@gmail.com]
				*/
				$splitHeaderRequest=[];
				foreach($getHeaderRequest as $ky => $value){
					$splitHeaderRequest=ArrayHelper::merge($splitHeaderRequest, array_diff_key($getHeaderRequest,[
						'TGL'=>'','USER_ID'=>'','SCDL_GROUP'=>'','KD_BARANG'=>'','NM_BARANG'=>'','SO_TYPE'=>'','SO_QTY'=>''
					]));
				};			
				$aryProviderHeaderRequest=$splitHeaderRequest;	
			
			
			
				/**
				 * DETAIL RETURE - Per Customer
				 * ROW to COLUMN
				 * @author piter novian [ptr.nov@gmail.com]
				*/	
				$aryDataReture=$searchModelReture->search(Yii::$app->request->queryParams);				//AR ArrayDataProvider
				$dataModelReture=$aryDataReture->allModels; 											//Set ArrayProvider to Array	
				$dataMapReture =  ArrayHelper::map($dataModelReture, 'NM_BARANG','SO_QTY','CUST_NM');	//Get index string	
				$dataIndexReture =  ArrayHelper::index($dataModelReture, 'CUST_NM');					//Get index string	
				$RetureMergeRowColumn= ArrayHelper::merge($dataIndexReture,$dataMapReture);				//index string Merge / Like Join index	
				$RetureIndexVal=array_values($RetureMergeRowColumn); 									//index string to int
				//$aryProviderDetailReture ='';
				$aryProviderDetailReture= new ArrayDataProvider([
					'allModels'=>$RetureIndexVal,
					'pagination' => [
						'pageSize' => 50,
					]
				]);			
				//$aryProviderHeaderReture='';
				/**
				 * Foreach to get All column form rows
				 * @author piter novian [ptr.nov@gmail.com]
				*/
				$getHeaderReture=[];
				foreach($RetureIndexVal as $key => $value){
					$getHeaderReture=ArrayHelper::merge($getHeaderReture,$RetureIndexVal[$key]);
				};
				
				/**
				 * Foreach to get All column Then remove Column selected
				 * @author piter novian [ptr.nov@gmail.com]
				*/
				$splitHeaderReture=[];
				foreach($getHeaderReture as $ky => $value){
					$splitHeaderReture=ArrayHelper::merge($splitHeaderReture, array_diff_key($getHeaderReture,[
						'TGL'=>'','USER_ID'=>'','SCDL_GROUP'=>'','KD_BARANG'=>'','NM_BARANG'=>'','SO_TYPE'=>'','SO_QTY'=>''
					]));
				};			
				$aryProviderHeaderReture=$splitHeaderReture;
									
				/**
				 * DETAIL SELL OUT - Per Customer
				 * ROW to COLUMN
				 * @author piter novian [ptr.nov@gmail.com]
				*/	
				$aryDataSellOut=$searchModelSellOut->search(Yii::$app->request->queryParams);				//AR ArrayDataProvider
				$dataModelSellOut=$aryDataSellOut->allModels; 											//Set ArrayProvider to Array	
				$dataMapSellOut =  ArrayHelper::map($dataModelSellOut, 'NM_BARANG','SO_QTY','CUST_NM');	//Get index string	
				$dataIndexSellOut =  ArrayHelper::index($dataModelSellOut, 'CUST_NM');					//Get index string	
				$SellOutMergeRowColumn= ArrayHelper::merge($dataIndexSellOut,$dataMapSellOut);				//index string Merge / Like Join index	
				$SellOutIndexVal=array_values($SellOutMergeRowColumn); 									//index string to int
				//$aryProviderDetailSellOut ='';
				$aryProviderDetailSellOut= new ArrayDataProvider([
					'allModels'=>$SellOutIndexVal,
					'pagination' => [
						'pageSize' => 50,
					]
				]);	
				//$aryProviderHeaderSellOut='';
				/**
				 * Foreach to get All column form rows
				 * @author piter novian [ptr.nov@gmail.com]
				*/
				$getHeaderSellOut=[];
				foreach($SellOutIndexVal as $key => $value){
					$getHeaderSellOut=ArrayHelper::merge($getHeaderSellOut,$SellOutIndexVal[$key]);
				};
				
				/**
				 * Foreach to get All column Then remove Column selected
				 * @author piter novian [ptr.nov@gmail.com]
				*/
				$splitHeaderSellOut=[];
				foreach($getHeaderSellOut as $ky => $value){
					$splitHeaderSellOut=ArrayHelper::merge($splitHeaderSellOut, array_diff_key($getHeaderSellOut,[
						'TGL'=>'','USER_ID'=>'','SCDL_GROUP'=>'','KD_BARANG'=>'','NM_BARANG'=>'','SO_TYPE'=>'','SO_QTY'=>''
					]));
				};			
				$aryProviderHeaderSellOut=$splitHeaderSellOut;
				
				
				/**
				 * DETAIL SELL IN - Per Customer
				 * ROW to COLUMN
				 * @author piter novian [ptr.nov@gmail.com]
				*/	
				$aryDataSellIN=$searchModelSellIN->search(Yii::$app->request->queryParams);				//AR ArrayDataProvider
				$dataModelSellIN=$aryDataSellIN->allModels; 												//Set ArrayProvider to Array	
				$dataMapSellIN =  ArrayHelper::map($dataModelSellIN, 'NM_BARANG','SO_QTY','CUST_NM');	//Get index string	
				$dataIndexSellIN =  ArrayHelper::index($dataModelSellIN, 'CUST_NM');					//Get index string	
				$SellINMergeRowColumn= ArrayHelper::merge($dataIndexSellIN,$dataMapSellIN);				//index string Merge / Like Join index	
				$SellINIndexVal=array_values($SellINMergeRowColumn); 									//index string to int
				//$aryProviderDetailSellIN ='';
				$aryProviderDetailSellIN= new ArrayDataProvider([
					'allModels'=>$SellINIndexVal,
					'pagination' => [
						'pageSize' => 50,
					]
				]);
				//$aryProviderHeaderSellIN='';
				/**
				 * Foreach to get All column form rows
				 * @author piter novian [ptr.nov@gmail.com]
				*/
				$getHeaderSellIN=[];
				foreach($SellINIndexVal as $key => $value){
					$getHeaderSellIN=ArrayHelper::merge($getHeaderSellIN,$SellINIndexVal[$key]);
				};
				
				/**
				 * Foreach to get All column Then remove Column selected
				 * @author piter novian [ptr.nov@gmail.com]
				*/
				$splitHeaderSellIN=[];
				foreach($getHeaderSellIN as $ky => $value){
					$splitHeaderSellIN=ArrayHelper::merge($splitHeaderSellIN, array_diff_key($getHeaderSellIN,[
						'TGL'=>'','USER_ID'=>'','SCDL_GROUP'=>'','KD_BARANG'=>'','NM_BARANG'=>'','SO_TYPE'=>'','SO_QTY'=>''
					]));
				};			
				$aryProviderHeaderSellIN=$splitHeaderSellIN;
				
				
				/* RENDER */
				return Yii::$app->controller->renderPartial('_expand1',[
					
					//=INFO
					'dataProviderInfo'=>$dataProviderInfo,
					
					//VISIT TIME
					'dataProviderTime'=>$dataProviderTime,
					
					//=IMAGE
					//'searchModelImage'=>$searchModelImage,
					'dataProviderImage'=>$dataProviderImage,
					
					//=SUMMRY STOCK|RETURE|SELL-IN|SELL-OUT
					'inventoryProvider'=>$inventoryProvider,
					 
					//=EXPIRED
					'dataProviderExpired'=>$dataProviderExpired,
					'searchModelExpired'=>$searchModelExpired,
					
					//=MEMO
					'dataProviderMemo'=>$dataProviderMemo,
					
					//DETAIL REQUEST ORDER - Per Customer
					'aryProviderDetailRequest'=>$aryProviderDetailRequest,
					'aryProviderHeaderRequest'=>$aryProviderHeaderRequest,
					
					//DETAIL STOCK - Per Customer
					'aryProviderDetailStock'=>$aryProviderDetailStock,
					'aryProviderHeaderStock'=>$aryProviderHeaderStock,
					
					//DETAIL RETURE - Per Customer
					'aryProviderDetailReture'=>$aryProviderDetailReture,
					'aryProviderHeaderReture'=>$aryProviderHeaderReture,
					
					//DETAIL SellOut - Per Customer
					'aryProviderDetailSellOut'=>$aryProviderDetailSellOut,				
					'aryProviderHeaderSellOut'=>$aryProviderHeaderSellOut,			
					
					//DETAIL SellIN - Per Customer
					'aryProviderDetailSellIN'=>$aryProviderDetailSellIN,
					'aryProviderHeaderSellIN'=>$aryProviderHeaderSellIN,
											
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
					'font-size'=>'9pt',
					'background-color'=>'rgba(74, 206, 231, 1)',
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
		
		/*GRIDVIEW ARRAY ROWS*/
		foreach($gvHeadColomn as $key =>$value[]){
			$attDinamik[]=[
				'attribute'=>$value[$key]['FIELD'],
				'value'=>$value[$key]['value'],
				'label'=>$value[$key]['label'],
				//'filterType'=>$value[$key]['filterType'],
				//'filter'=>$value[$key]['filter'],
				//'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
				'hAlign'=>'right',
				'vAlign'=>'middle',
				//'mergeHeader'=>true,
				'noWrap'=>true,
				'group'=>$value[$key]['GRP'],
				'format'=>$value[$key]['FORMAT'],						
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
		};
	}
	/*STATUS RADIUS
	$attDinamik[]=[
			'attribute'=>'sttKoordinat',
			'label'=>'STATUS',
			'filter'=>$SttFilter,
			'filterOptions'=>['style'=>'background-color:rgba(249, 215, 100, 1); align:center'],
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'value' => function ($model) {
				return statusRadius($model);
			},
			'noWrap'=>true,
			//'group'=>$value[$key]['GRP'],
			'format'=>'html',						
			'headerOptions'=>[
					'style'=>[
					'text-align'=>'center',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(249, 215, 100, 1)',								
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(13, 127, 3, 0.1)',
				]
			],
		];
	*/
	
	$btn_srch = Html::a('<i class="fa fa-search"></i> Search Date',
							'/master/review-visit/ambil-tanggal',
							[		
								'data-toggle'=>"modal",		
								'data-target'=>"#modal-tgl",		
								'class' => 'btn btn-info btn-sm'		
						   ]
						);
	
	
	/*SHOW GRID VIEW LIST*/
	$indexReviewDetail= GridView::widget([
		'id'=>'cust-visit-list',
		'dataProvider' => $dataProviderHeader1,
		'filterModel' => $searchModelHeader1,					
		//'filterRowOptions'=>['style'=>'background-color:rgba(74, 206, 231, 1); align:center'],
		'columns' => $attDinamik,
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
				'id'=>'cust-visit-list',
			],
		],
		'summary'=>false,
		'panel' => [
					'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-2x fa-bicycle"></div><div><h4 class="modal-title">DAILY REVIEW CUSTOMER CALL</h4></div>'.' '.'<div style="float:right; margin-top:-22px;margin-right:0px;">'.$btn_srch.'</div>', 
					'type'=>'success',
					//'showFooter'=>false,
		],
		'toolbar'=> [
			//['content'=>toMenuAwal().toExportExcel()],
			''//'{items}',
		],
		// 'hover'=>true, //cursor select
		// 'responsive'=>true,
		// 'responsiveWrap'=>true,
		// 'bordered'=>true,
		// 'striped'=>true,
	]);	
?>	
<?=$indexReviewDetail?>
<?php
Modal::begin([
			'id' => 'modal-view',
			'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-file-image-o"></div><div><h5 class="modal-title"><b>VIEWS IMAGE</b></h5></div>',
			'size' => Modal::SIZE_LARGE,
			'headerOptions'=>[
					'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
			],
		]);
		echo "<div id='modalContent'></div>";
		Modal::end();	
?>
<?php		
	$this->registerJs("		
          $.fn.modal.Constructor.prototype.enforceFocus = function(){};		
          $('#modal-tgl').on('show.bs.modal', function (event) {		
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
         'id' => 'modal-tgl',		
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-search"></div><div><h4 class="modal-title"> SEARCH DATE</h4></div>',	
		 'size' => Modal::SIZE_SMALL,	
         'headerOptions'=>[		
                 'style'=> 'border-radius:5px; background-color: rgba(90, 171, 255, 0.7)',		
         ],		
     ]);		
     Modal::end();
?>
<div class="container-full">
	<!-- Modal -->
	<div class="modal modal-wide fade" id="tampil-image" size="Modal::SIZE_LARGE" tabindex="-1" role="dialog" aria-labelledby="create-poLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="create-poLabel">VIEW IMAGE</h4>
			  </div>

			  <div class="modal-body" style="text-align:center">
				<?php
					$gambarkosong="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";
					$searchModelViewImg = new CustomercallTimevisitSearch(['TGL'=>'2016-09-01','USER_ID'=>'59']);
					$dataProviderViewImg=$searchModelViewImg->search(Yii::$app->request->queryParams);
					$listImg=$dataProviderViewImg->getModels();
					$startImg='';
					$endImg='';
					foreach ($listImg as $key => $value) {
						$startImg=$value['IMG_DECODE_START']!=''?$value['IMG_DECODE_START']:$gambarkosong;
						$endImg=$value['IMG_DECODE_START']!=''?$value['IMG_DECODE_START']:$gambarkosong;
					  $items[] = [
									'src'=>'data:image/jpg;charset=utf-8;base64,'.$startImg,
									'imageOptions'=>['width'=>"120px",'height'=>"120px",'class'=>'img-rounded'], //setting image display
							];
					  $items[] = [
									'src'=>'data:image/jpg;charset=utf-8;base64,'.$endImg,
									'imageOptions'=>['width'=>"120px",'height'=>"120px",'class'=>'img-rounded'], //setting image display
							];
					};			
					
					/* 2 amigos two galerry author mix:wawan and ptr.nov ver 1.0*/
					$viewItemImge =dosamigos\gallery\Gallery::widget([
						  'items' =>  $items]);
					echo Html::panel([
							'heading' => '<div> LIST IMAGE </div>',
							'body'=>$viewItemImge,
						],
						Html::TYPE_INFO
					);
				  ?>
			  </div>
		</div>
	  </div>
	</div>

</div>