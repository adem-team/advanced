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
use yii\data\ActiveDataProvider;

use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Termcustomers;
use lukisongroup\master\models\Distributor;
use lukisongroup\hrd\models\Corp;
use lukisongroup\purchasing\models\data_term\Rtdetail;
use lukisongroup\purchasing\models\data_term\Requesttermheader;


//print_r($dataProviderBudget->getModels());

//echo $model[0]->NmDis;

$id = $_GET['id'];



	/*
	 * Tombol List Acount INVESTMENT
	 * No Permission
	*/
	function tombolInvest($id_term,$cust_kd){
		$title = Yii::t('app', 'Account Investment');
		$options = ['id'=>'account-invest',
					'data-toggle'=>"modal",
					'data-target'=>"#account-invest-plan",
					'class' => 'btn btn-info btn-sm'
		];
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/data-term/account-investment','id'=>$id_term,'cus_kd'=>$cust_kd]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	/*
	 * Tombol List Acount INVESTMENT
	 * No Permission
	*/
	function tombolActual($id_term){
		$title = Yii::t('app', 'Actual Investment');
		$options = ['id'=>'actual-invest',
					'class' => 'btn btn-info btn-sm'
		];
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/data-term/actual-review','id'=>$id_term]);
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
					$connect = Yii::$app->db_esm;
					// select * from t0000detail td
					// INNER  JOIN t0001detail td1
					// on td.INVES_ID = td1.INVESTASI_TYPE WHERE td.TERM_ID = "trm.2016.0001" and td1.INVESTASI_TYPE = 8 ;
					// $sql1 = 'select sum(td1.HARGA) as BUDGET_ACTUAL from t0000detail td
					//       	INNER JOIN t0001detail td1
					//  				where td.TERM_ID ="'.$model->TERM_ID.'" and td1.INVESTASI_TYPE="'.$model->INVES_ID.'" and td1.KD_RIB LIKE "%RID" and td1.KD_RIB LIKE "%RI"';
					// $total_pp23 = ($model->HARGA*$model->pph)/100;
					// $total_ppn =  ($model->HARGA*$model->ppn)/100;
					//
					// 	$total = ($total_ppn + $model->HARGA)-$total_pp23 ;

					$total_ppn = Requesttermheader::find()->where(['TERM_ID'=>$model->TERM_ID])->andwhere(['like','KD_RIB','RI'])->sum('PPN');

					$total_harga = Rtdetail::find()->where(['TERM_ID'=>$model->TERM_ID,'INVESTASI_TYPE'=>$model->INVES_ID])->andwhere(['like','KD_RIB','RI'])->sum('HARGA');

					$total_pph = Requesttermheader::find()->where(['TERM_ID'=>$model->TERM_ID])->andwhere(['like','KD_RIB','RI'])->sum('PPH23');

					$hitung_ppn = ($total_harga*$total_ppn)/100;
					$hitung_pph = ($total_harga*$total_pph)/100;
					$sub_total = ($hitung_ppn + $total_harga)-$hitung_pph;
					// // $total_ppn = $cari_ppn->sum('PPN');
				  // $sql = 'select sum(th.PPN) from t0001detail ti
					// 				LEFT JOIN t0001header th on ti.KD_RIB = th.KD_RIB
        	// 				where ti.TERM_ID ="'.$model->TERM_ID.'" and ti.INVESTASI_TYPE="'.$model->INVES_ID.'" and ti.KD_RIB LIKE "RID%" and ti.KD_RIB LIKE "RI%"';
					// $execute = $connect->createCommand($sql)->queryScalar();
					if($sub_total!= '')
					{
					   return  number_format($sub_total,2);
					}else {
						# code...
						 return number_format(0.00,2);
						// return  number_format($sub_total,2);
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
          $connect = Yii::$app->db_esm;
          // select * from t0000detail td
          // INNER  JOIN t0001detail td1
          // on td.INVES_ID = td1.INVESTASI_TYPE WHERE td.TERM_ID = "trm.2016.0001" and td1.INVESTASI_TYPE = 8 ;
          // $sql1 = 'select sum(td1.HARGA) as BUDGET_ACTUAL from t0000detail td
          //       	INNER JOIN t0001detail td1
          //  				where td.TERM_ID ="'.$model->TERM_ID.'" and td1.INVESTASI_TYPE="'.$model->INVES_ID.'" and td1.KD_RIB LIKE "%RID" and td1.KD_RIB LIKE "%RI"';
          // $total_pp23 = ($model->HARGA*$model->pph)/100;
          // $total_ppn =  ($model->HARGA*$model->ppn)/100;
          //
          // 	$total = ($total_ppn + $model->HARGA)-$total_pp23 ;

          $total_ppn = Requesttermheader::find()->where(['TERM_ID'=>$model->TERM_ID])->andwhere('STATUS = 102')->orwhere(['like','KD_RIB','RA'])->orwhere(['like','KD_RIB','RB'])->sum('PPN');

          $total_harga = Rtdetail::find()->where(['TERM_ID'=>$model->TERM_ID,'INVESTASI_TYPE'=>$model->INVES_ID])->andwhere('STATUS = 102')->orwhere(['like','KD_RIB','RA'])->orwhere(['like','KD_RIB','RB'])->sum('HARGA');

          $total_pph = Requesttermheader::find()->where(['TERM_ID'=>$model->TERM_ID])->orwhere(['like','KD_RIB','RA'])->andwhere('STATUS = 102')->orwhere(['like','KD_RIB','RB'])->sum('PPH23');

          $hitung_ppn = ($total_harga*$total_ppn)/100;
          $hitung_pph = ($total_harga*$total_pph)/100;
          $sub_total = ($hitung_ppn + $total_harga)-$hitung_pph;
          // // $total_ppn = $cari_ppn->sum('PPN');
          // $sql = 'select sum(th.PPN) from t0001detail ti
          // 				LEFT JOIN t0001header th on ti.KD_RIB = th.KD_RIB
          // 				where ti.TERM_ID ="'.$model->TERM_ID.'" and ti.INVESTASI_TYPE="'.$model->INVES_ID.'" and ti.KD_RIB LIKE "RID%" and ti.KD_RIB LIKE "RI%"';
          // $execute = $connect->createCommand($sql)->queryScalar();
          if($sub_total!= '')
          {
             return  number_format($sub_total,2);
          }else {
            # code...
             return number_format(0.00,2);
            // return  number_format($sub_total,2);
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
		'detail'=>function ($model, $key, $index, $column){

		$connect = Yii::$app->db_esm;

		// $sql = "SELECT * FROM t0001detail ti
		// 				LEFT JOIN c0006 c on ti.INVESTASI_TYPE = c.ID
		// 				WHERE ti.TERM_ID ='".$model->TERM_ID."'
		// 				AND ti.INVESTASI_TYPE ='".$model->INVES_ID."'
		// 				AND ti.KD_RIB LIKE 'RID%'
		// 				AND ti.KD_RIB LIKE 'RI%'";

		$sql = "SELECT * FROM `t0001detail` ti
						LEFT JOIN t0001header th on ti.KD_RIB = th.KD_RIB
						LEFT JOIN c0006 c on ti.INVESTASI_TYPE = c.ID
						WHERE ti.TERM_ID ='".$model->TERM_ID."'
						AND ti.INVESTASI_TYPE ='".$model->INVES_ID."'
						AND (ti.KD_RIB LIKE 'RID%' OR ti.KD_RIB LIKE 'RI%')";

		// $sql = "SELECT * FROM `t0000detail` td
		// 				LEFT JOIN t0001header th on
		// 				td.CUST_KD_PARENT = th.CUST_ID_PARENT
		// 				LEFT JOIN t0001detail ti on th.KD_RIB = ti.KD_RIB
		// 				LEFT JOIN  c0006 c on ti.INVESTASI_TYPE = c.ID
		// 				WHERE th.TERM_ID ='".$model->TERM_ID."'
		// 				AND ti.INVESTASI_TYPE ='".$model->INVES_ID."'
		// 				AND th.KD_RIB LIKE 'RID%'
		// 				AND th.KD_RIB LIKE 'RI%'";

						$hasil = $connect->createCommand($sql)->queryAll();

						$dataProviderBudgetdetail_inves = new ArrayDataProvider([
				    'allModels' => $hasil,
				    'pagination' => [
				        'pageSize' => 10,
				    ],
				]);

				// $sql2 = "SELECT * FROM t0001detail ti
				// 				LEFT JOIN c0006 c on ti.INVESTASI_TYPE = c.ID
				// 				WHERE ti.TERM_ID ='".$model->TERM_ID."'
				// 				AND ti.INVESTASI_TYPE ='".$model->INVES_ID."'
				// 				AND ti.KD_RIB LIKE 'RB%' AND ti.KD_RIB LIKE 'RA%'";
				$sql2 = "SELECT * FROM t0001detail ti
								LEFT JOIN c0006 c on ti.INVESTASI_TYPE = c.ID
								LEFT JOIN t0001header th on ti.KD_RIB = th.KD_RIB
								WHERE ti.TERM_ID ='".$model->TERM_ID."'
								AND ti.INVESTASI_TYPE ='".$model->INVES_ID."'
								AND th.STATUS = 102
							  AND (ti.KD_RIB LIKE 'RA%' OR ti.KD_RIB LIKE 'RB%')";

				// $sql2 = "SELECT * FROM `t0000detail` td
				// 				LEFT JOIN t0001header th on
				// 				td.CUST_KD_PARENT = th.CUST_ID_PARENT
				// 				LEFT JOIN t0001detail ti on th.KD_RIB = ti.KD_RIB
				// 				LEFT JOIN  c0006 c on ti.INVESTASI_TYPE = c.ID
				// 				WHERE th.TERM_ID ='".$model->TERM_ID."'AND ti.INVESTASI_TYPE ='".$model->INVES_ID."'
				// 				AND th.KD_RIB LIKE 'RB%'";

								$hasil1 = $connect->createCommand($sql2)->queryAll();

								$dataProviderBudgetdetail = new ArrayDataProvider([
								'allModels' => $hasil1,
								'pagination' => [
										'pageSize' => 10,
								],
						]);

			/*query actual_detail*/
			// $query = Rtdetail::find()->JoinWith('invest',true,'left JOIN')
			// 				 ->JoinWith('termdet',true,'left JOIN')
			// 				 ->where(['t0000detail.TERM_ID'=>$model->TERM_ID])
			// 				 ->andwhere(['t0001detail.INVESTASI_TYPE'=>$model->INVES_ID])
			// 				 ->andwhere(['like','t0001detail.KD_RIB','RID'])
			// 				 ->andwhere(['like','t0001detail.KD_RIB','RI']);


			/*dataprovider actual_detail*/
			// $dataProviderBudgetdetail_inves = new ActiveDataProvider([
			// 													'query' => $query,
			// 													'pagination' => [
			// 													'pageSize' => 20,
			// 														 ],
			// 													]);

			/*query budget_plan*/
			// $query1 = Rtdetail::find()->JoinWith('invest',true,'left JOIN')
			// 					->JoinWith('termdet',true,'left JOIN')
			// 					->where(['t0000detail.TERM_ID'=>$model->TERM_ID])
			// 					->andwhere(['like','t0001detail.KD_RIB','RB'])
			// 					->andwhere(['t0001detail.INVESTASI_TYPE'=>$model->INVES_ID]);

			/*dataprovider budget_plan*/
			//  $dataProviderBudgetdetail = new ActiveDataProvider([
			// 														'query' => $query1,
			// 														 'pagination' => [
			// 															'pageSize' => 20,
			// 																	],
			// 																]);

				/*render*/
			return Yii::$app->controller->renderPartial('_reviewDataExpand',[
				'dataProviderBudgetdetail'=>$dataProviderBudgetdetail,
				'dataProviderBudgetdetail_inves'=>$dataProviderBudgetdetail_inves, //actual_detail
				'dataProviderBudget'=>$dataProviderBudget,
				'id'=>$model->ID
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

			<dd>1 :	<?= $model->NmCustomer ?></dd>


			<dd>2 :	<?= $model->Nmprincipel ?></dd>


			<dd>3 :	<?= $model->NmDis ?></dd>
		</dl>
	</div>

	<!-- PERIODE/JANGKA WAKTU !-->
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="font-family: tahoma ;font-size: 8pt">
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

	<!-- TARGET !-->
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="font-family: tahoma ;font-size: 8pt">
		<div>
			<?php //echo target($model); ?>
		</div>
		<dl>
			<dt style="width:80px;"><u><b>TARGET :</b></u></dt>
			<dd style="width:80px"> Rp.<?=$model->TARGET_VALUE?></dd>
			<dd><?=$model->TARGET_TEXT ?> Rupiah</dd>

		</dl>
	</div>
  <?php


	$total_tambahan_ppn = Requesttermheader::find()->where(['TERM_ID'=>$id])->sum('PPN');

	$total_tamabahan_harga = Rtdetail::find()->where(['TERM_ID'=>$id])->sum('HARGA');

	$total_tambahan_pph = Requesttermheader::find()->where(['TERM_ID'=>$id])->sum('PPH23');

	$hitung_ppn_tambahan = ($total_tamabahan_harga*$total_tambahan_ppn)/100;
	$hitung_pph_tambahan = ($total_tamabahan_harga*$total_tambahan_pph)/100;
	$Budget_tambahan = ($hitung_ppn_tambahan + $total_tamabahan_harga)-$hitung_pph_tambahan;

	$budget = number_format($Budget_tambahan,2);

	$invets = $model->BUDGET_AWAL+$Budget_tambahan;

	$total_invest= number_format($invets,2);

	$modal_awal = $model->BUDGET_AWAL !='' ? $model->BUDGET_AWAL: number_format(0.00,2);

  ?>
	<!-- BUDGET !-->
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="font-family: tahoma ;font-size: 8pt">
		<div>
			<?php //echo target($model); ?>
		</div>
		<dl>
			<dt style="width:80px;"><u><b>BUDGET :</b></u></dt><dd></dd>
			<dt style="width:120px; float:left;"> Budget Awal</dt>
			<dd>:  <?= $modal_awal ?> </dd>
			<dt style="width:120px; float:left;"> Budget Tambahan</dt>
			<dd>:<?=$budget?></dd>
			<dt style="width:120px; float:left;" > Total Inves</dt>
			<dd>: <?=$total_invest?></dd>
			<dt style="width:120px; float:left;" > Budget Sisa</dt>
			<dd>: <?=$model->TARGET_VALUE?></dd>
		</dl>
	</div>
</div>

<div style="font-family: tahoma ;font-size: 8pt;padding-top:10px;float:none">
	<!-- GRID VIEW DETAIL PLAN AND ACTUAL !-->
	<?php
		//print_r($model[0]->TERM_ID);
	?>
	<div style="margin-bottom:5px;margin-right:5px; float:left"><?=tombolInvest($model['TERM_ID'],$cus_kd);?></div>
	<div style="margin-bottom:5px"><?=tombolActual($model->TERM_ID);?></div>
	<?=$gvDetalPlanActual;?>
</div>
<?php
$this->registerJs("
	 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
	 $('#account-invest-plan').on('show.bs.modal', function (event) {
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
			'id' => 'account-invest-plan',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Account</b></h4></div>',
		// 'size' => Modal::SIZE_LARGE,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
		]
	]);
	Modal::end();
