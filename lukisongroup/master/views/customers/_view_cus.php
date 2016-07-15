<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model modulprj\master\models\IjinDetail */

$this->title = $model->CUST_KD;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

	/*Customers info*/
	$cusviewinfo=DetailView::widget([
		'model' => $model,
		'attributes' => [
			[
				'attribute' =>'CUST_NM',
				'label'=>'Customer.NM',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			[
				'attribute' =>'parentName',
				'label'=>'Customers.parent',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			[
				'attribute' =>'CusT',
				'value'=>$model->custype->CUST_KTG_NM, 
				'label'=>'Type:',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
				[
				'attribute' =>	'ALAMAT',
				'label'=>'Alamat :',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			
		],
	]);

	
	/*update alias*/
	$attalias = [
		[
			'group'=>true,
			'label'=>false,
			'rowOptions'=>['class'=>'info'],
			'groupOptions'=>['class'=>'text-left'] //text-center 
		],
		[ 	//KD_DISTRIBUTOR
			'attribute' =>'KD_DISTRIBUTOR',
			'format'=>'raw',
			'value'=>$model->custdis->NM_DISTRIBUTOR,
			'type'=>DetailView::INPUT_SELECT2,
			'widgetOptions'=>[
				'data'=>$datadis_view,
				'options'=>['placeholder'=>'Select ...'],
				'pluginOptions'=>['allowClear'=>true],
			],	
		],
		
		[ 	//CUST_KD_ALIAS
			'attribute' =>'CUST_KD_ALIAS',
			'label'=>'alias',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 15px']
		],
	];

	/*data detail*/
	$data_detail = [
		[
			'group'=>true,
			'label'=>false,
			'rowOptions'=>['class'=>'info'],
			'groupOptions'=>['class'=>'text-left'] //text-center 
		],
		[ 	//TLP1
			'attribute' =>'CUST_NM',
			'label'=>'Customers.nm:',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 15px']
		],
		[ 	//TLP1
			'attribute' =>'TLP1',
			'label'=>'TLP1',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 15px']
		],
		[ 	//PIC
			'attribute' =>'PIC',
			'label'=>'PIC',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 15px']
		],

		[ 	//TLP2
			'attribute' =>'TLP2',
			'label'=>'TLP2',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 15px']
		],
		[ 	//EMAIL
			'attribute' =>'EMAIL',
			'label'=>'EMAIL',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 15px']
		],
		[
        'attribute'=>'JOIN_DATE', 
        'format'=>'date',
        'type'=>DetailView::INPUT_DATE,
        'widgetOptions' => [
            'pluginOptions'=>['format'=>'yyyy-mm-dd'],
            'pluginEvents'=>[
	       'show' => "function(e) {errror}",
	           ],
        ],
        'valueColOptions'=>['style'=>'width:30%']
    ],

		[ 	//FAX
			'attribute' =>'FAX',
			'label'=>'FAX',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 15px']
		],
		[ 	//NPWP
			'attribute' =>'NPWP',
			'label'=>'NPWP',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 15px']
		],
		[ 	//WEBSITE
			'attribute' =>'WEBSITE',
			'label'=>'WEBSITE',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 15px']
		],
		[ 	//STATUS
			'attribute' =>'STATUS',
			'format'=>'raw',
			'value'=>$model->STATUS ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>',
			'type'=>DetailView::INPUT_SWITCH,
        	'widgetOptions' => [
            'pluginOptions' => [
                'onText' => 'Aktif',
                'offText' => 'Tidak Aktif',
            ]
        ],
          'valueColOptions'=>['style'=>'width:30%']
	]
	];

	/*Detail data View Editing*/
	$detail_data_view=DetailView::widget([
		'id'=>'detail-data-view-id',
		'model' => $model,
		'attributes'=>$data_detail,
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',
		'panel'=>[
					'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b> Detail Customers</b></h6></div>',
					'type'=>DetailView::TYPE_INFO,
				],
		'saveOptions'=>[ 
			'id' =>'saveBtn',
			'value'=>'/master/customers/viewcust?id='.$model->CUST_KD,
			'params' => ['custom_param' => true],
		],		
	]);


	
	/*Detail alias View Editing*/
	$alias=DetailView::widget([
		'id'=>'alias-view-id',
		'model' => $model,
		'attributes'=>$attalias,
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',
		'panel'=>[
					'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b>Alias Customers</b></h6></div>',
					'type'=>DetailView::TYPE_INFO,
				],
		'saveOptions'=>[ 
			'id' =>'saveBtn',
			'value'=>'/master/customers/viewcust?id='.$model->CUST_KD,
			'params' => ['custom_param' => true],
		],		
	]);
	
	/*update alamat*/
	$update_alamat_view = [
		[
			'group'=>true,
			'label'=>false,
			'rowOptions'=>['class'=>'info'],
			'groupOptions'=>['class'=>'text-left'] //text-center 
		],
		[ 	//PROVINCE_ID
			'attribute' =>'PROVINCE_ID',
			'format'=>'raw',
			'value'=>$model->custprov->PROVINCE,
			'type'=>DetailView::INPUT_SELECT2,
			'widgetOptions'=>[
				'data'=>$valpro,
				'options'=>['placeholder'=>'Select ...'],
				'pluginOptions'=>['allowClear'=>true],
			],	
		],
		[ 	//CITY_ID
			'attribute' =>'CITY_ID',
			'format'=>'raw',
			'value'=>$model->custkota->CITY_NAME,
			'type'=>DetailView::INPUT_DEPDROP,
			'widgetOptions'=>[
				'options' => ['id'=>'customers-city_id',
			'placeholder' => 'Select Kota'],
			'type' => DepDrop::TYPE_SELECT2,
			'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
			'pluginOptions'=>[
				'depends'=>['customers-province_id'],
				'url' => Url::to(['/master/customers/lisarea']),
			  'loadingText' => 'Loading data ...',
			]
			],	
		],
		// ALAMAT
		[
			'attribute' =>	'ALAMAT',
			'label'=>'Alamat',
			'type'=>DetailView::INPUT_TEXTAREA,
			'labelColOptions' => ['style' => 'text-align:right;width: 15px']
		],
	];

	
	/*Detail View ALAMAT Editing*/
	$detail_alamat=DetailView::widget([
		'id'=>'update-alamat-detail-id',
		'model' => $model,
		'attributes'=>$update_alamat_view ,
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',
		'panel'=>[
					'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b>Update Alamat</b></h6></div>',
					'type'=>DetailView::TYPE_INFO,
				],
		'saveOptions'=>[ 
			'id' =>'saveBtn',
			'value'=>'/master/customers/viewcust?id='.$model->CUST_KD,
			'params' => ['custom_param' => true],
		],		
	]);

		/*update kategori*/
	$detail_kategori = [
		[
			'group'=>true,
			'label'=>false,
			'rowOptions'=>['class'=>'info'],
			'groupOptions'=>['class'=>'text-left'] //text-center 
		],
		[ 	//CUST_TYPE
			'attribute' =>'CUST_TYPE',
			'format'=>'raw',
			'value'=>$model->custype->CUST_KTG_NM,
			'type'=>DetailView::INPUT_SELECT2,
			'widgetOptions'=>[
				'data'=>$kategori_view,
				'options'=>['placeholder'=>'Select ...'],
				'pluginOptions'=>['allowClear'=>true],
			],	
		],
		[ 	//CUST_KTG
			'attribute' =>'CUST_KTG',
			'format'=>'raw',
			'type'=>DetailView::INPUT_DEPDROP,
			'value'=>$model->cus->CUST_KTG_NM,
			'widgetOptions'=>[
				'options' => [
				'id'=>'customers-cust_ktg',
		    	'placeholder' => 'Select Customers kategory'],
		    	'type' => DepDrop::TYPE_SELECT2,
		    	'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
    	'pluginOptions'=>[
    		'depends'=>['customers-cust_type'],
    		'url' => Url::to(['/master/customers/lisdata']),
    	  'loadingText' => 'Loading data ...',
		  'initialize'=>true,
    	],
			],
				
		],
	];

	
	/*Detail View Kategori Editing*/
	$detail_kategori_update=DetailView::widget([
		'id'=>'kategory-view',
		'model' => $model,
		'attributes'=>$detail_kategori ,
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',
		'panel'=>[
					'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b>Update Kategori</b></h6></div>',
					'type'=>DetailView::TYPE_INFO,
				],
		'saveOptions'=>[ 
			'id' =>'saveBtn',
			'value'=>'/master/customers/viewcust?id='.$model->CUST_KD,
			'params' => ['custom_param' => true],
		],		
	]);
	
	
	
	
	
?>
<div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="row" >
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<?= $cusviewinfo ?>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<?= $detail_alamat ?>
		</div>
		</div>
		<div class="row" >
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<?=$alias?>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<?=$detail_kategori_update?>
		</div>
		</div>
		<div class="row" >
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?=$detail_data_view?>
		</div>
	</div>
</div>
