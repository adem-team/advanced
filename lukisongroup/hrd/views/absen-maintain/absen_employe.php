<?php
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use app\models\hrd\Dept;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;
use yii\data\ArrayDataProvider;

$this->sideCorp = 'PT. Lukisongroup';                                   /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_absensi';                                       /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'HRM - Absensi	 Dashboard');             /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                          /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


	/*
	 * COLUMN MAINTAIN ABSENSI
	 * @author ptrnov  [piter@lukison.com]
	 * @since 1.2
	*/
	$clmEmploye=[
		/* [	//COL-0
			// Attribute Serial No 
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
		], */
		[
			'class'=>'kartik\grid\ExpandRowColumn',
			'width'=>'20px',
			
			'value'=>function ($model, $key, $index, $column) {
				return GridView::ROW_COLLAPSED;
			},
			'detail'=>function ($model, $key, $index, $column){
					$absenQryMaintain=Yii::$app->db2->createCommand("CALL absensi_grid('inout_maintain=2016-02-01=2016-02-22=0=".$model['KAR_ID1']."=0=".$model['MesinID1']."=0')")->queryAll();				
					$absenMaintain= new ArrayDataProvider([
					//'key' => 'idno',
					'allModels'=>$absenQryMaintain,
					  'pagination' => [
						'pageSize' =>80,
					] 
				]);
				//$attributeField=$plsql_exp1->allModels[0];
				return Yii::$app->controller->renderPartial('absen_maintain',[
					//'dataProvider'=>$plsql_exp1,
					'absenMaintain'=>$absenMaintain,
				]);  
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'detailOptions'=>[
                'id'=>'gvxs1'
            ],
			'contentOptions'=>[
				
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
			
			'expandOneOnly'=>true
		], 		 
		[  	//col-1
			//Employee-ID
			'attribute' => 'KAR_ID1',
			'label'=>'Employee-ID',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			//'groupedRow'=>true,
			//'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'150px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'150px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		[  	//col-2
			//Employee-Name
			'attribute' => 'EMP_NM1',
			'label'=>'Employee-Name',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'320px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'320px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		]		
	];

	
	$gvAbsenEmploye=GridView::widget([
		'id'=>'gv-employe-id',
        'dataProvider' => $absenEmp,
        //'filterModel' => $searchModel,
		//'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
		//'showPageSummary' => true,
		'columns' =>$clmEmploye,
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>true,
			'id'=>'gv-employe-id',
		   ],
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		//'autoXlFormat'=>true,
		//'export' => false,
	]);
?>


<div class="body-content">
    <div class="row" style="padding-left: 5px; padding-right: 5px">
        <div class="col-sm-12 col-md-2 col-lg-12" style="padding-left:15px; padding-right:15px">
            <?php
				echo $gvAbsenEmploye;
            ?>
        </div>
    </div>
</div>