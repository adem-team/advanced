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
	
	$actionClass='btn btn-info btn-xs';
	$actionLabel='View';
	$attDinamik2 =[];
	/*GRIDVIEW ARRAY FIELD HEAD*/
	$headColomnEvent2=[
		['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'Date','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'USER_NM','SIZE' => '10px','label'=>'User','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '10px','label'=>'Customer','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>3, 'ATTR' =>['FIELD'=>'SCDL_GRP_NM','SIZE' => '10px','label'=>'Schadule','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>4, 'ATTR' =>['FIELD'=>'CUST_TIPE_NM','SIZE' => '10px','label'=>'Type','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>5, 'ATTR' =>['FIELD'=>'CUST_KTG_NM','SIZE' => '10px','label'=>'Cetegory','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		//['ID' =>7, 'ATTR' =>['FIELD'=>'radiusMeter','SIZE' => '10px','label'=>'Radius/Meter','align'=>'right','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		//['ID' =>8, 'ATTR' =>['FIELD'=>'sttKoordinat','SIZE' => '10px','label'=>'Status','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
	];
	$gvHeadColomn2 = ArrayHelper::map($headColomnEvent2, 'ID', 'ATTR');
	
	/*GRIDVIEW EXPAND*/
				/* $attDinamik2[]=[
					'class'=>'kartik\grid\ExpandRowColumn',
					'width'=>'50px',
					'header'=>'',
					'value'=>function ($model, $key, $index, $column) {
						return GridView::ROW_COLLAPSED;
						//return GridView::ROW_EXPANDED;
					},
					'detail'=>function (){						
						//return Yii::$app->controller->renderPartial('_expand2');
					},
					//'headerOptions'=>['class'=>'kartik-sheet-style'] ,
					'collapseTitle'=>'b1',
					'expandTitle'=>'b2',
					// 'allowBatchToggle'=>true,
					// 'expandOneOnly'=>true,
					// 'enableRowClick'=>true,
					'headerOptions'=>[
						'style'=>[
						'id'=>'text123',
							'text-align'=>'center',
							'width'=>'10px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'9pt',
							'background-color'=>'rgba(74, 206, 231, 1)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'id'=>'text123',
							'text-align'=>'center',
							'width'=>'10px',
							'height'=>'10px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'9pt',
						]
					],
				]; */
				
	/*GRIDVIEW ARRAY ROWS*/
	foreach($gvHeadColomn2 as $key =>$value[]){
		$attDinamik2[]=[
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
		];
	};
	
/* 	echo "test expand";
	echo "</br></br>";
	echo $tgl;
	echo "</br></br>";
	echo $cust_id;
	echo "</br></br>";
	echo $user_id; */
?>

<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
    <div  class="row" style="margin-top:15px">
        <div class="col-sm-12 col-md-12 col-lg-12">
			<?php
				/*SHOW GRID VIEW LIST*/
				echo GridView::widget([
					'id'=>'header2-id',
					 'export' => false,
  'panel' => false,
					'dataProvider' => $dataProviderHeader2,
					//'filterModel' => $searchModel,					
					//'filterRowOptions'=>['style'=>'background-color:rgba(74, 206, 231, 1); align:center'],
					'columns' => $attDinamik2,
					/* [
						['class' => 'yii\grid\SerialColumn'],
						'start',
						'end',
						'title',
						['class' => 'yii\grid\ActionColumn'],
					], */
					//'pjax'=>true,
					// 'pjaxSettings'=>[
						// 'options'=>[
							// 'enablePushState'=>false,
							// 'id'=>'header2',
						// ],
					// ],
										// 'hover'=>true, //cursor select
					//'responsive'=>true,
					//'responsiveWrap'=>true,
					//'bordered'=>true,
					//'striped'=>true,
				]);			
			?>
		</div>
	</div>
</div>