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
		['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'DATE','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>true,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'USER_NM','SIZE' => '10px','label'=>'USER NAME','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'SCDL_GRP_NM','SIZE' => '10px','label'=>'SCHEDULE','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>3, 'ATTR' =>['FIELD'=>'TIME_DAYSTART','SIZE' => '10px','label'=>'START TIME','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>4, 'ATTR' =>['FIELD'=>'TIME_DAYEND','SIZE' => '10px','label'=>'END TIME','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
	];
	$gvHeadColomn = ArrayHelper::map($headColomnEvent, 'ID', 'ATTR');
	
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
			$dataProvider=$searchModelTime->search(Yii::$app->request->queryParams);
			// USER INFO
			$dataProviderInfo = $dataProvider;			
			//VISIT TIME
			$dataProviderTime = $dataProvider;			
			// IMAGE VISIT 
			$dataProviderImage = $dataProvider;
						
			// IVENTORY 
			//$inventoryProvider='';
			$inventoryProvider= new ArrayDataProvider([
				// 'allModels'=>Yii::$app->db_esm->createCommand("CALL ERP_CUSTOMER_VISIT_inventory('".$model['TGL']."','".$model['CUST_ID']."','".$model['USER_ID']."')")->queryAll(),
				  'allModels'=>Yii::$app->db_esm->createCommand("
						SELECT (SELECT DISTINCT NM_BARANG FROM b0001 WHERE KD_BARANG=so_t2.KD_BARANG) AS NAME_ITEM, 
								   MAX(CASE WHEN SO_TYPE=5 THEN SO_QTY ELSE 0 END) as STOCK,
									 MAX(CASE WHEN SO_TYPE=6 THEN SO_QTY ELSE 0 END) as SELL_IN,
									 MAX(CASE WHEN SO_TYPE=7 THEN SO_QTY ELSE 0 END) as SELL_OUT,
									 MAX(CASE WHEN SO_TYPE=8 THEN '0000-00-00' ELSE '0000-00-00' END) as ED
						FROM so_t2
						WHERE TGL='".$model['TGL']."' AND USER_ID='".$model['USER_ID']."'  GROUP BY KD_BARANG
					")->queryAll(),
				  'pagination' => [
					'pageSize' =>50,
				] 
			]);
			
			/* [4] EXPIRED */
			/* [5] REQUEST */
			
			
			
			/* DETAIL & SUMMARY */
			//'SUMMARY_ALL','2016-05-31','','30','1'
			$aryProviderDetailSummary='';
			// $aryProviderDetailSummary= new ArrayDataProvider([
				////'allModels'=>Yii::$app->db_esm->createCommand("DASHBOARD_ESM_VISIT_inventory_summary('SUMMARY_ALL','".$model['TGL']."','','".$model['USER_ID']."','1')")->queryAll(),
				// 'allModels'=>Yii::$app->db_esm->createCommand("CALL MOBILE_CUSTOMER_VISIT_inventory_summary('SUMMARY_ALL','2016-05-31','','30','1');")->queryAll(),
				  // 'pagination' => [
					// 'pageSize' =>50,
				// ] 
			// ]); 
			
			
			/*SUMMRY STOCK*/
			// $aryProviderDataStock = new ArrayDataProvider([
				// 'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_VISIT_inventory_summary('SUMMARY_STOCK_ITEM_CUST','".$model['TGL']."','','".$model['USER_ID']."','".$model['SCDL_GROUP']."');")->queryAll(),
				// 'pagination' => [
					// 'pageSize' =>50,
				// ] 
			// ]); 
			$aryProviderHeaderStock='';
			// $aryProviderHeaderStock=$aryProviderDataStock->allModels[0];				
			
			/*SUMMRY SELL IN*/
			// $aryProviderDataSellIN = new ArrayDataProvider([
				// 'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_VISIT_inventory_summary('SUMMARY_SELL_IN_ITEM_CUST','".$model['TGL']."','','".$model['USER_ID']."','".$model['SCDL_GROUP']."');")->queryAll(),
				// 'pagination' => [
					// 'pageSize' =>50,
				// ] 
			// ]); 
			$aryProviderHeaderSellIN='';
			// $aryProviderHeaderSellIN=$aryProviderDataSellIN->allModels[0];
			
			/*SUMMRY SELL OUT*/
			// $aryProviderDataSellOut = new ArrayDataProvider([
				// 'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_VISIT_inventory_summary('SUMMARY_SELL_OUT_ITEM_CUST','".$model['TGL']."','','".$model['USER_ID']."','".$model['SCDL_GROUP']."');")->queryAll(),
				// 'pagination' => [
					// 'pageSize' =>50,
				// ] 
			// ]); 
			$aryProviderHeaderSellOut='';
			// $aryProviderHeaderSellOut=$aryProviderDataSellOut->allModels[0];
			
			/*SUMMRY RETURE*/
			// $aryProviderDataReture = new ArrayDataProvider([
				// 'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_VISIT_inventory_summary('SUMMARY_RETURE_ITEM_CUST','".$model['TGL']."','','".$model['USER_ID']."','".$model['SCDL_GROUP']."');")->queryAll(),
				// 'pagination' => [
					// 'pageSize' =>50,
				// ] 
			// ]); 
			$aryProviderHeaderReture='';
			// $aryProviderHeaderReture=$aryProviderDataReture->allModels[0];
			
			/*SUMMRY REQUEST*/
			// $aryProviderDataRequest = new ArrayDataProvider([
				// 'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_VISIT_inventory_summary('SUMMARY_REQUEST_ITEM_CUST','".$model['TGL']."','','".$model['USER_ID']."','".$model['SCDL_GROUP']."');")->queryAll(),
				// 'pagination' => [
					// 'pageSize' =>50,
				// ] 
			// ]); 
			$aryProviderHeaderRequest='';
			// $aryProviderHeaderRequest=$aryProviderDataRequest->allModels[0];
			
			/* RENDER */
			return Yii::$app->controller->renderPartial('_expand1',[
				'dataProviderInfo'=>$dataProviderInfo->getModels(),
				'dataProviderTime'=>$dataProviderTime,
				//'searchModelImage'=>$searchModelImage,
				'dataProviderImage'=>$dataProviderImage,
				'inventoryProvider'=>$inventoryProvider,
				
				// 'aryproviderDetailSummary'=>$aryProviderDetailSummary,
				//SUMMRY STOCK
				// 'aryProviderHeaderStock'=>$aryProviderHeaderStock,
				// 'aryProviderDataStock'=>$aryProviderDataStock,
				//SUMMRY SELL IN
				// 'aryProviderHeaderSellIN'=>$aryProviderHeaderSellIN,
				// 'aryProviderDataSellIN'=>$aryProviderDataSellIN,
				//SUMMRY SELL OUT
				// 'aryProviderHeaderSellOut'=>$aryProviderHeaderSellOut,
				// 'aryProviderDataSellOut'=>$aryProviderDataSellOut,
				//SUMMRY RETURE
				// 'aryProviderHeaderReture'=>$aryProviderHeaderReture,
				// 'aryProviderDataReture'=>$aryProviderDataReture,
				//SUMMRY REQUEST
				// 'aryProviderHeaderRequest'=>$aryProviderHeaderRequest,
				// 'aryProviderDataRequest'=>$aryProviderDataRequest
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
