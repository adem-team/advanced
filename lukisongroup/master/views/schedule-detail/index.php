<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Json;
use yii\web\Request;
use kartik\daterange\DateRangePicker;;
use yii\db\ActiveRecord;
use yii\data\ArrayDataProvider;

use lukisongroup\sales\models\Sot2Search;
use lukisongroup\sales\models\Sot2;
use lukisongroup\master\models\CustomerVisitImageSearch;

$this->sideCorp = 'PT.Effembi Sukses Makmur';                          /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_customers';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Group');          /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


	$SttFilterArray= [
		  ['ID' => '1', 'DESCRIP' => 'Suitable'],
		  ['ID' => '2', 'DESCRIP' => 'Deviate'],
		  ['ID' => '3', 'DESCRIP' => 'Missing'],
	];
	$SttFilter = ArrayHelper::map($SttFilterArray, 'ID', 'DESCRIP');

function statusRadius($model){
		if($model->sttKoordinat==1){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> Suitable', '#',['class'=>'btn btn-success btn-xs', 'style'=>['width'=>'100px'],'title'=>'Detail']);
		}elseif ($model->sttKoordinat==2){
			return Html::a('<i class="glyphicon glyphicon-time"></i> Deviate', '#',['class'=>'btn btn-warning btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->sttKoordinat==3){
			return Html::a('<i class="glyphicon glyphicon-thumbs-down"></i> Missing', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		};
	}



?>

<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
    <div  class="row" style="margin-top:15px">
        <div class="col-sm-12 col-md-12 col-lg-12">
			<?php
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
					['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'Date','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>$aryCorpID,'filterType'=>GridView::FILTER_SELECT2,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>1, 'ATTR' =>['FIELD'=>'nmuser','SIZE' => '10px','label'=>'User','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>2, 'ATTR' =>['FIELD'=>'nmgroup','SIZE' => '10px','label'=>'Group','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>3, 'ATTR' =>['FIELD'=>'nmcust','SIZE' => '10px','label'=>'Customer','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>4, 'ATTR' =>['FIELD'=>'CREATE_AT','SIZE' => '10px','label'=>'DateTime','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>5, 'ATTR' =>['FIELD'=>'LAT','SIZE' => '10px','label'=>'Latitute','align'=>'right','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>6, 'ATTR' =>['FIELD'=>'LAG','SIZE' => '10px','label'=>'Logitute','align'=>'right','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>7, 'ATTR' =>['FIELD'=>'radiusMeter','SIZE' => '10px','label'=>'Radius/Meter','align'=>'right','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					//['ID' =>8, 'ATTR' =>['FIELD'=>'sttKoordinat','SIZE' => '10px','label'=>'Status','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
				];
				$gvHeadColomn = ArrayHelper::map($headColomnEvent, 'ID', 'ATTR');
				
				
				/*GRIDVIEW ARRAY ACTION*/
				$attDinamik[]=[
					'class'=>'kartik\grid\ActionColumn',
					'dropdown' => true,
					'template' => '{view1}{view2}',
					'dropdownOptions'=>['class'=>'pull-left dropdown','style'=>['disable'=>true]],
					'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
					'dropdownButton'=>[
						'class' => $actionClass,
						'label'=>$actionLabel,
						//'caret'=>'<span class="caret"></span>',
					],
					'buttons' => [
						'view1' =>function($url, $model, $key){
								return  '<li>' .Html::a('<span class="fa fa-search-plus fa-dm"></span>'.Yii::t('app', 'Image Start'),
															['/master/schedule-detail/img1','id'=>$model->ID],[
															'id'=>'img1-id',
															'data-toggle'=>"modal",
															'data-target'=>"#img1-visit",
															]). '</li>' . PHP_EOL;
						},
						'view2' =>function($url, $model, $key){
								return  '<li>' .Html::a('<span class="fa fa-search-plus fa-dm"></span>'.Yii::t('app', 'Image End'),
															['/master/schedule-detail/img2','id'=>$model->ID],[
															'id'=>'img2-id',
															'data-toggle'=>"modal",
															'data-target'=>"#img2-visit",
															]). '</li>' . PHP_EOL;
						},
					],
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
				
				/*GRIDVIEW EXPAND*/
				$attDinamik[]=[	
					'class'=>'kartik\grid\ExpandRowColumn',
					'width'=>'50px',
					'value'=>function ($model, $key, $index, $column) {
						return GridView::ROW_COLLAPSED;
					},
					'detail'=>function ($model, $key, $index, $column){						
						$dataInventory=Yii::$app->db_esm->createCommand("CALL CUSTOMER_VISIT_inventory('".$model->TGL."','".$model->CUST_ID."','".$model->USER_ID."')")->queryAll();
						$inventoryProvider= new ArrayDataProvider([
							//'key' => 'ID',
							'allModels'=>$dataInventory,
							  'pagination' => [
								'pageSize' =>50,
							] 
						]);
						
						
						/*INFO*/
							$modelInfo=$model;
						/*INVENTORY*/
							//Sot2Search
							//$modelInvntory =Sot2::find()->where('TGL="'.$model->TGL.'" AND CUST_KD="'.$model->CUST_ID.'" AND USER_ID="'.$model->USER_ID.'"')->All();
							$modelInvntory =Sot2::find()->where('TGL="'.$model->TGL.'" AND USER_ID="'.$model->USER_ID.'"')->All();
							//$modelInvntory =Sot2::find()->where('USER_ID="'.$model->USER_ID.'"')->all();
							//$modelImage =CustomerVisitImage::find()->where('ID="'.$model->ID.'"')->One();
							$aryDataProvider= new ArrayDataProvider([
								'key' => 'ID',
								'allModels'=>$modelInvntory,
								 // 'pagination' => [
									// 'pageSize' =>50,
								// ]
							]);
							
						/*IMAGE VISIT*/
							$searchModel = new CustomerVisitImageSearch([
								'ID_DETAIL'=>''.$model->ID.'',
							]);
							$dataProviderImage = $searchModel->search(Yii::$app->request->queryParams);
			
						return Yii::$app->controller->renderPartial('indexExpand',[
							'cust_id'=>$model->ID,
							/* 'tgl'=>$model->TGL,
							'cust_id'=>$model->CUST_ID,
							'user_id'=>$model->USER_ID, */
							/*INFO*/
							'modelInfo'=>$modelInfo,
							/*INVENTORY*/
							'dataProviderInventory'=>$aryDataProvider,
							'searchModelImage'=>$searchModel,
							'inventoryProvider'=>$inventoryProvider,							
							/*IMAGE*/
							'dataProviderImage'=>$dataProviderImage,
													
						]);
					},
					'headerOptions'=>['class'=>'kartik-sheet-style'] ,
					'expandOneOnly'=>false,
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
						'filterType'=>$value[$key]['filterType'],
						'filter'=>$value[$key]['filter'],
						'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
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
						//'pageSummaryFunc'=>GridView::F_SUM,
						//'pageSummary'=>true,
						// 'pageSummaryOptions' => [
							// 'style'=>[
									// 'text-align'=>'right',
									//'width'=>'12px',
									// 'font-family'=>'tahoma',
									// 'font-size'=>'8pt',
									// 'text-decoration'=>'underline',
									// 'font-weight'=>'bold',
									// 'border-left-color'=>'transparant',
									// 'border-left'=>'0px',
							// ]
						// ],
					];
				};
				
				/*STATUS RADIUS*/
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
				
				
				
				
				/*SHOW GRID VIEW LIST EVENT*/
				echo GridView::widget([
					'id'=>'cust-visit-list',
					'dataProvider' => $dataProvider,
					'filterModel' => $searchModel,					
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
					'panel' => [
								'heading'=>'<h3 class="panel-title">DAILY CUSTOMERS VISIT</h3>',
								'type'=>'info',
								//'showFooter'=>false,
					],
					'toolbar'=> [
						''//'{items}',
					],
					'hover'=>true, //cursor select
					'responsive'=>true,
					'responsiveWrap'=>true,
					'bordered'=>true,
					'striped'=>true,
				]);
				
				
				
				
				
			?>
		</div>
	</div>
</div>

<?php

	/*IMAGE1*/
	$this->registerJs("
		 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
		 $('#img1-visit').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var modal = $(this)
			var title = button.data('title')
			var href = button.attr('href')
			//modal.find('.modal-title').html(title)
			modal.find('.modal-body').html('<i class=\"fa fa-dolar fa-spin\"></i>')
			$.post(href)
				.done(function( data ) {
					modal.find('.modal-body').html(data)
				});
			})
	",$this::POS_READY);
    Modal::begin([
        'id' => 'img1-visit',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-image"></div><div><h4 class="modal-title">IMAGE START</h4></div>',
			'size' => Modal::SIZE_LARGE,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(92, 174, 244, 0.7)'
			]
    ]);
    Modal::end();
	
	/*IMAGE2*/
	$this->registerJs("
		 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
		 $('#img2-visit').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var modal = $(this)
			var title = button.data('title')
			var href = button.attr('href')
			//modal.find('.modal-title').html(title)
			modal.find('.modal-body').html('<i class=\"fa fa-dolar fa-spin\"></i>')
			$.post(href)
				.done(function( data ) {
					modal.find('.modal-body').html(data)
				});
			})
	",$this::POS_READY);
    Modal::begin([
        'id' => 'img2-visit',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-image"></div><div><h4 class="modal-title">IMAGE END</h4></div>',
			'size' => Modal::SIZE_LARGE,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(92, 174, 244, 0.7)'
			]
    ]);
    Modal::end();

?>


