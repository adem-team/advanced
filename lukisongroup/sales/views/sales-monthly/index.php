<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use lukisongroup\master\models\Barang;
/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\sales\models\Sot2Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_sales';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


//public function atr(){
	/* foreach($attributeField as $key =>$value)
	{
			//$attDinamik[]=("'attribute'=>'".$key . "',");
			//if ($key!='ID' ||$key!='TGL'|| $key!='CUST_KD_ALIAS' || $key!='KD_DIS' || $key!='KD_BARANG'){
			if ($key!='ID'){
				//$brg=Barang::find()->Where(['KD_BARANG'=>str_replace("'","",$key)])->one();
				$brg=Barang::find()->where(['KD_BARANG'=>$key])->one();
				$LbNmBarang=$brg!=''?$brg->NM_BARANG:$key;
				$attDinamik[]=['attribute'=>$key,'label'=>$LbNmBarang];
				//$attDinamik[]='label';
				//$attDinamik1[]=$attDinamik;
			}
			//$attDinamik[]="['attribute'=>'".$key."']";
	} */
	//print_r($attDinamik);
	
	//return $attDinamik;
//}


$attDinamik =[];
$attDinamik1=[];
$attDinamik[]=[

	'class'=>'kartik\grid\SerialColumn',
	'contentOptions'=>['class'=>'kartik-sheet-style'],
	'width'=>'10px',
	'header'=>'No.',
	'headerOptions'=>[
		'style'=>[
			'text-align'=>'center',
			'width'=>'10px',
			'font-family'=>'verdana, arial, sans-serif',
			'font-size'=>'9pt',
			'background-color'=>'rgba(97, 211, 96, 0.3)',
		]
	],
	'contentOptions'=>[
		'style'=>[
			'text-align'=>'center',
			'width'=>'10px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'8pt',
		]
	],
	'noWrap' => false
];
$attDinamik[]=[

	'attribute' => 'CUST_KD_ALIAS',
	'headerOptions'=>[
		'style'=>[
			'text-align'=>'center',
			'width'=>'50px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
			'background-color'=>'rgba(97, 211, 96, 0.3)',
		]
	],
	'contentOptions'=>[
		'style'=>[
			'text-align'=>'center',
			'width'=>'50px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
		]
	],
	
];

$attDinamik[]=[

	//'class'=>'kartik\grid\EditableColumn',
	'attribute' => 'KD_CUSTOMERS',
	'headerOptions'=>[
		'style'=>[
			'text-align'=>'center',
			'width'=>'100px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
			'background-color'=>'rgba(97, 211, 96, 0.3)',
		]
	],
	'contentOptions'=>[
		'style'=>[
			'text-align'=>'left',
			'width'=>'100px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
		]
	],
	
];

$attDinamik[]=[

	'attribute' => 'CUST_NM',
	'headerOptions'=>[
		'style'=>[
			'text-align'=>'center',
			'width'=>'250px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
			'background-color'=>'rgba(97, 211, 96, 0.3)',
		]
	],
	'contentOptions'=>[
		'style'=>[
			'text-align'=>'left',
			'width'=>'250px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
		]
	],
	
];
$attDinamik[]=[

	'attribute' => 'CUST_NM',
	'headerOptions'=>[
		'style'=>[
			'text-align'=>'center',
			'width'=>'250px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
			'background-color'=>'rgba(97, 211, 96, 0.3)',
		]
	],
	'contentOptions'=>[
		'style'=>[
			'text-align'=>'left',
			'width'=>'250px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
		]
	],
	
];
$attDinamik[]=[

	'attribute' => 'CUST_NM',
	'headerOptions'=>[
		'style'=>[
			'text-align'=>'center',
			'width'=>'250px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
			'background-color'=>'rgba(97, 211, 96, 0.3)',
		]
	],
	'contentOptions'=>[
		'style'=>[
			'text-align'=>'left',
			'width'=>'250px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
		]
	],
	
];
$attDinamik[]=[

	'attribute' => 'CUST_NM',
	'headerOptions'=>[
		'style'=>[
			'text-align'=>'center',
			'width'=>'250px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
			'background-color'=>'rgba(97, 211, 96, 0.3)',
		]
	],
	'contentOptions'=>[
		'style'=>[
			'text-align'=>'left',
			'width'=>'250px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
		]
	],
	
];
$attDinamik[]=[

	'attribute' => 'CUST_NM',
	'headerOptions'=>[
		'style'=>[
			'text-align'=>'center',
			'width'=>'250px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
			'background-color'=>'rgba(97, 211, 96, 0.3)',
		]
	],
	'contentOptions'=>[
		'style'=>[
			'text-align'=>'left',
			'width'=>'250px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
		]
	],
	
];
$attDinamik[]=[

	'attribute' => 'CUST_NM',
	'headerOptions'=>[
		'style'=>[
			'text-align'=>'center',
			'width'=>'250px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
			'background-color'=>'rgba(97, 211, 96, 0.3)',
		]
	],
	'contentOptions'=>[
		'style'=>[
			'text-align'=>'left',
			'width'=>'250px',
			'font-family'=>'tahoma, arial, sans-serif',
			'font-size'=>'9pt',
		]
	],
	
];
	foreach($attributeField as $key =>$value)
	{
		//$brg=Barang::find()->where(['KD_BARANG'=>str_replace("'","",$value)])->one();
		//$LbNmBarang=$brg!=''?$brg->NM_BARANG:$value;
		
		$kd = explode('.',$key);
		if ($kd[0]=='BRG'|| $kd[0]=='KRT' ){
			$lbl=$kd[0]=='BRG'? 'PCS':'KRT';
			$attDinamik[]=[
			
				'attribute'=>$key,'label'=>$lbl,//'label'=>$value,
							/*  'value'=>function(){							
								//if ($model->'BRG.ESM.01.01.E01.0004'==''){
									return 0;
								//}							
							},  */
								 'headerOptions'=>[
									'style'=>[
										'text-align'=>'center',
										'width'=>'50px',
										'font-family'=>'tahoma, arial, sans-serif',
										'font-size'=>'9pt',
										'background-color'=>'rgba(97, 211, 96, 0.3)',
									]
								],
								'contentOptions'=>[
									'style'=>[
										'text-align'=>'center',
										'width'=>'50px',
										'font-family'=>'tahoma, arial, sans-serif',
										'font-size'=>'9pt',
									]
								],
								
							];	
		}
	} 

	
$clm=$attDinamik;
//print_r($attDinamik);
//print_r($clmKdBarang);
// print_r($attributeField);
?>
<div class="sot2-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sot2', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
		'id'=>'gv-rpt-sales',
        'dataProvider' => $dataProviderX,
        //'filterModel' => $searchModel,
		'columns' =>$clm,
		//'responsiveWrap'=>false,
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-rpt-sales',
		   ],						  
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
    ]); ?>

</div>
