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

use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Termcustomers;
use lukisongroup\master\models\Distributor;
use lukisongroup\hrd\models\Corp;

//print_r($model[0]);
//print_r($dataProviderBudget->getModels());

//echo $model[0]->NmDis;

	
	/*
	 * Tombol List Acount INVESTMENT
	 * No Permission
	*/
	function tombolInvest(){
		$title = Yii::t('app', 'Account Investment');
		$options = ['id'=>'account-invest',
					'data-toggle'=>"modal",
					'data-target'=>"#check-barang-umum",
					'class' => 'btn btn-info btn-sm'
		];
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['#']);
		$content = Html::a($label,$url, $options);
		return $content;
	}
	
	
	/*==PLAN BUDGET|ACTUAL BUDGET==*/
	$attDinamik =[];
	/*GRIDVIEW ARRAY FIELD HEAD*/
	$headColomnEvent=[
		['ID' =>0, 'ATTR' =>['FIELD'=>'Namainvest','SIZE' => '50px','label'=>'Trade Investment','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'PERIODE_START','SIZE' => '10px','label'=>'Periode','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'BUDGET_PLAN','SIZE' => '10px','label'=>'Budget Plan','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>3, 'ATTR' =>['FIELD'=>'STATUS','SIZE' => '10px','label'=>'%','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>4, 'ATTR' =>['FIELD'=>'BUDGET_ACTUAL','SIZE' => '10px','label'=>'Budget Actual','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>5, 'ATTR' =>['FIELD'=>'STATUS','SIZE' => '10px','label'=>'%','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
	];
	$gvHeadColomn = ArrayHelper::map($headColomnEvent, 'ID', 'ATTR');	
	/*GRIDVIEW SERIAL ROWS*/
	$attDinamik[] =[
		'class'=>'kartik\grid\SerialColumn',
		//'contentOptions'=>['class'=>'kartik-sheet-style'],
		'width'=>'10px',
		'header'=>'No.',
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(249,215,100,1)',
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
	foreach($gvHeadColomn as $key =>$value[]){
	if($value[$key]['FIELD'] == 'BUDGET_ACTUAL')
		{
			$attDinamik[]=[
				'attribute'=>$value[$key]['FIELD'],
				'value'=>function($model){
					  /*connect*/
					$connect = Yii::$app->db_esm;
		
					/*caculate ppn*/
					 $sql_ppn = "select sum(PPN) as PPN from t0001header where TERM_ID='".$model->TERM_ID."' AND STATUS = 102 AND (KD_RIB LIKE 'RI%' OR KD_RIB LIKE 'RID%')";
          		     $total_ppn =  $connect->createCommand($sql_ppn)->queryScalar();
					

					/*caculate harga*/
		          	$total_sql = "select sum(HARGA) as harga from t0001detail where TERM_ID='".$model->TERM_ID."' and ID_INVEST='".$model->INVES_ID."' and STATUS = 102 and (KD_RIB LIKE 'RI%' OR KD_RIB LIKE 'RID%')";
				  	$total_harga = Yii::$app->db_esm->createCommand($total_sql)->queryScalar();

					/*caculate pph23*/
					$sql_pph = "select sum(PPH23) as PPH23 from t0001header where TERM_ID='".$model->TERM_ID."' AND STATUS = 102 AND (KD_RIB LIKE 'RI%' OR KD_RIB LIKE 'RID%')";
          			$total_pph = $connect->createCommand($sql_pph)->queryScalar();
					

					/*formula sub total*/
					$hitung_ppn = ($total_harga*$total_ppn)/100;
					$hitung_pph = ($total_harga*$total_pph)/100;
					$sub_total = ($hitung_ppn + $total_harga)-$hitung_pph;
					
					 /* if subtotal equal null then number format using sub total*/

					if($sub_total!= '')
					{
					    return  number_format($sub_total,2);
					}else {
						# code...
						return number_format(0.00,2);
						
					}

				},
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
		}elseif ($value[$key]['FIELD'] == 'BUDGET_PLAN') {
		  # code...
      $attDinamik[]=[
        'attribute'=>$value[$key]['FIELD'],
        'value'=>function($model){
          /*connect*/
          $connect = Yii::$app->db_esm;
          
          /*caculate ppn*/
          $sql_ppn = "select sum(PPN) as PPN from t0001header where TERM_ID='".$model->TERM_ID."' AND STATUS = 102 AND (KD_RIB LIKE 'RA%' OR KD_RIB LIKE 'RB%')";
          $total_ppn =  $connect->createCommand($sql_ppn)->queryScalar();

        
          /*caculate harga*/
          $total_sql = "select sum(HARGA) as harga from t0001detail where TERM_ID='".$model->TERM_ID."' and ID_INVEST='".$model->INVES_ID."' and STATUS = 102 and (KD_RIB LIKE 'RA%' OR KD_RIB LIKE 'RB%')";
		  $total_harga = Yii::$app->db_esm->createCommand($total_sql)->queryScalar();
          
		  /*caculate pph23*/
		  $sql_pph = "select sum(PPH23) as PPH23 from t0001header where TERM_ID='".$model->TERM_ID."' AND STATUS = 102 AND (KD_RIB LIKE 'RA%' OR KD_RIB LIKE 'RB%')";
          $total_pph = $connect->createCommand($sql_pph)->queryScalar();
         
         	/*formula sub total*/
          $hitung_ppn = ($total_harga*$total_ppn)/100;
          $hitung_pph = ($total_harga*$total_pph)/100;
          $sub_total = ($hitung_ppn + $total_harga)-$hitung_pph;
      
          

       	  /* if subtotal equal null then number format using sub total*/
          if($sub_total!= '')
          {
             return  number_format($sub_total,2);
          }else {
            # code...
             return number_format(0.00,2);
          }

        },
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
		}else {
			# code...
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
			];
		}
	};
	/*GRIDVIEW EXPAND*/
	$attDinamik[]=[	
		'class'=>'kartik\grid\ExpandRowColumn',
		'width'=>'50px',
		'header'=>'Detail',
		'expandOneOnly'=>true,
		'detailRowCssClass'=>GridView::TYPE_DEFAULT,
		'value'=>function ($model, $key, $index, $column) {
			return GridView::ROW_COLLAPSED;
		},
		'detail'=>function ($model, $key, $index, $column) use($dataProviderBudget){

				$connect = Yii::$app->db_esm;

		/* viewDataexpandPlan || budget_plan */
		$sql = "SELECT * FROM `t0001detail` ti
					LEFT JOIN t0001header th on ti.KD_RIB = th.KD_RIB
					LEFT JOIN c0006 c on ti.ID_INVEST = c.ID
					WHERE ti.TERM_ID ='".$model->TERM_ID."'
					AND ti.ID_INVEST ='".$model->INVES_ID."'
					AND ti.STATUS = 102
					AND (ti.KD_RIB LIKE 'RID%' OR ti.KD_RIB LIKE 'RI%')";


		$hasil = $connect->createCommand($sql)->queryAll();

		$dataProviderBudgetdetail_inves = new ArrayDataProvider([
				    'allModels' => $hasil,
				    'pagination' => [
				        'pageSize' => 10,
				    ],
				]);



		/* viewDataexpandActual || budget_actual */
		$sql2 = "SELECT * FROM t0001detail ti
					LEFT JOIN c0006 c on ti.ID_INVEST = c.ID
					LEFT JOIN t0001header th on ti.KD_RIB = th.KD_RIB
					WHERE ti.TERM_ID ='".$model->TERM_ID."'
					AND ti.ID_INVEST ='".$model->INVES_ID."'
					AND ti.STATUS = 102
					AND (ti.KD_RIB LIKE 'RA%' OR ti.KD_RIB LIKE 'RB%')";

				

		$hasil1 = $connect->createCommand($sql2)->queryAll();

		$dataProviderBudgetdetail = new ArrayDataProvider([
								'allModels' => $hasil1,
								'pagination' => [
										'pageSize' => 10,
								],
						]);

			/* RENDER */
			return Yii::$app->controller->renderPartial('_viewDataExpand',[
				'dataProviderDetailBudget'=>$dataProviderBudgetdetail, //viewDataexpandActual
				'dataProviderBudgetdetail_inves'=>$dataProviderBudgetdetail_inves, //viewDataexpandPlan
				'id'=>$model->ID,
			]); 
		},
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
				'background-color'=>'rgba(231, 183, 108, 0.2)',
			]
		],
	];
	/*GRIDVIEW ARRAY ACTION*/
	/* $actionClass='btn btn-info btn-xs';
	$actionLabel='Action';
	$attDinamik[]=[
		'class'=>'kartik\grid\ActionColumn',
		'dropdown' => true,
		'template' => '{view1}',
		'dropdownOptions'=>['class'=>'pull-right dropup','style'=>['disable'=>true]],
		'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
		'dropdownButton'=>[
			'class' => $actionClass,
			'label'=>$actionLabel,
			'caret'=>'<span class="caret"></span>',
		],
		 'buttons' => [
			'view1' =>function($url, $model, $key){
					return  '<li>' .Html::a('<span class="fa fa-search-plus fa-dm"></span>'.Yii::t('app', 'Review'),
												['/purchasing/plan-term/review','id'=>$model->CUST_KD_PARENT],[
												'id'=>'img1-id',
												'data-toggle'=>"modal",
												//'data-target'=>"#img1-visit",
												]). '</li>' . PHP_EOL;
			}
		],
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(249, 215, 100, 1)',
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
	]; */
	/*GRID VIEW BASE*/
	$gvDetalPlanActual= GridView::widget([
		'id'=>'plan-term-budget',
		'dataProvider' => $dataProviderBudget,
		//'filterModel' => $searchModel,					
		//'filterRowOptions'=>['style'=>'background-color:rgba(74, 206, 231, 1); align:center'],
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
				'id'=>'plan-term-budget',
			],
		],
		'panel' => [
					'heading'=>'<h3 class="panel-title" style="font-family: verdana, arial, sans-serif ;font-size: 9pt;">TERM PLAN</h3>',
					'type'=>'info',
					//'showFooter'=>false,
		],
		'summary'=>false,
		'toolbar'=>false,
		'panel'=>false,
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
	]);

?>

<div class="row" style="font-family: tahoma ;font-size: 9pt;padding-top:10px">
	<!-- PARTIES/PIHAK !-->
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="font-family: tahoma ;font-size: 8pt">
		<div>
			<?php //echo pihak($model); ?>
		</div>
		<dl>				
			<dt><u><b>PARTIES/PIHAK BERSANGKUTAN :</b></u></dt>

			<dd>1 :	<?= $model[0]->NmCustomer ?></dd>


			<dd>2 :	<?= $model[0]->Nmprincipel ?></dd>


			<dd>3 :	<?= $model[0]->NmDis ?></dd>
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
			<dd>:	<?=$model[0]->PERIOD_START ?></dd>

			<dt style="width:80px; float:left;">Sampai:</dt>
			<dd>:	<?=$model[0]->PERIOD_END ?></dd>
		</dl>
	</div>
	
	<!-- TARGET !-->
	<div class="col-xs-3 col-sm-6 col-md-3 col-lg-3" style="font-family: tahoma ;font-size: 8pt;padding-left:30px">
		<div>
			<?php //echo target($model); ?>
		</div>
		<dl>
			<dt style="width:80px;"><h6><u><b>TARGET :</b></u></h6></dt>
			<dd style="width:80px"> Rp.<?=$model->TARGET_VALUE?></dd>
			<dd><?=$model->TARGET_TEXT ?> Rupiah</dd>

		</dl>
	</div>
</div>
<div style="font-family: tahoma ;font-size: 9pt;padding-top:10px">
	<!-- GRID VIEW DETAIL PLAN AND ACTUAL !-->
	<?=$gvDetalPlanActual;?>
</div>
