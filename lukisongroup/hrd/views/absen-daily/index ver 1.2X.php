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
	$clmMachine=[
		[
			'class'=>'kartik\grid\ExpandRowColumn',
			'width'=>'20px',
			/* 'pluginOption'=>[
				'options'=>['id'=>'gv-index-id',]
			], */
			//'options'=>['id'=>'gvxs'],		
			'value'=>function ($model, $key, $index, $column) {
				return GridView::ROW_COLLAPSED;
				//return GridView::ROW_NONE;
			},
			'detail'=>function ($model, $key, $index, $column){
					//$qryEmp=Yii::$app->db2->createCommand("CALL absensi_grid('inout_maintain_grp=2016-02-01=2016-02-22=0=0=0=0=0')")->queryAll();
					$qryEmp=Yii::$app->db2->createCommand("CALL absensi_grid('inout_maintain_grp=2016-02-01=2016-02-22=0=0=0=".$model['MesinID']."=0')")->queryAll();					
								
				$absenEmp= new ArrayDataProvider([
					//'key' => 'idno',
					'allModels'=>$qryEmp,
					  'pagination' => [
						'pageSize' =>80,
					] 
				]);
				//$attributeField=$plsql_exp1->allModels[0];
				return Yii::$app->controller->renderPartial('absen_employe',[
					//'dataProvider'=>$plsql_exp1,
					'absenEmp'=>$absenEmp,
				]); 
			},
			'detailOptions'=>[
                'id'=>'gvxs'
            ],

			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
			'hiddenFromExport' => false,
			//'hidden' => true,
			//'expandOneOnly'=>true
		
		],		
		[  	//col-3
			//Finger-Machine
			'attribute' => 'MesinID',			
			'label'=>'Finger-Machine',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			//'groupedRow'=>true,
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		
		[  	//col-2
			//MESIN_NM
			'attribute' => 'MesinNm',
			'label'=>'Machine-Name',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'350px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'350px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],				
	];

	
	$gvAbsenIndex=GridView::widget([
		'id'=>'gv-index-id',
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
		//'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
		//'showPageSummary' => true,
		'columns' =>$clmMachine,
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>true,
			'id'=>'gv-index-id',
		   ],
		],
		'panel' => [
					'heading'=>'<h3 class="panel-title">LOG ABSENSI</h3>',
					/* 'type'=>'warning',
					'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Customer ',
							['modelClass' => 'Kategori',]),'/master/barang/create',[
								'data-toggle'=>"modal",
									'data-target'=>"#modal-create",
										'class' => 'btn btn-success'
													]), */
					'showFooter'=>false,
		],
		'toolbar'=> [
			//'{items}',
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
        <div class="col-sm-12 col-md-2 col-lg-12" style="padding-left:20px; padding-right:20px">
            <?php
				echo $gvAbsenIndex;
            ?>
        </div>
    </div>
</div>