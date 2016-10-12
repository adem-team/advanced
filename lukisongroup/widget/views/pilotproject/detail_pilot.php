<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model modulprj\master\models\IjinDetail */


	/*Pilot info*/
	$pilotviewinfo=DetailView::widget([
		'model' => $model,
		'attributes' => [
			[
				'attribute' =>'PILOT_NM',
				'label'=>'Pilot Nm:',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			[
				'attribute' =>'PLAN_DATE1',
				'value'=> $model->dateplan,
				'label'=>'Planning',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			[
				'attribute' =>'ACTUAL_DATE1',
				'value'=>$model->ACTUAL_DATE1.' - '.$model->ACTUAL_DATE2, 
				'label'=>'Actual',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			[
				'attribute' =>'Sendto',
				'label'=>'Di Tujukan:',
				'value'=> $model->employenm,
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			
		],
	]);

	
	/*update planning*/
	$attalias = [
		[
			'group'=>true,
			'label'=>false,
			'rowOptions'=>['class'=>'info'],
			'groupOptions'=>['class'=>'text-left'] //text-center 
		],

    		[
        	'attribute'=>'PLAN_DATE1', 
	        'format'=>'datetime',
	        'type'=>DetailView::INPUT_DATETIME,
	        'widgetOptions' => [
	            'pluginOptions'=>['format' => 'yyyy-mm-dd H:i:s'],
	            'pluginEvents'=>[
		       'show' => "function(e) {errror}",
		           ],
	        ],
	        'valueColOptions'=>['style'=>'width:60%']
    	],
		
		[
        	'attribute'=>'PLAN_DATE2', 
	        'format'=>'datetime',
	        'value'=>new DateTime(),
	        'type'=>DetailView::INPUT_DATETIME,
	        'widgetOptions' => [
	             'pluginOptions'=>['format' => 'yyyy-mm-dd H:i:s'],
	            'pluginEvents'=>[
		       'show' => "function(e) {errror}",
		           ],
	        ],
	        'valueColOptions'=>['style'=>'width:60%']
    	],
	];

	/*update actual*/
	$actual = [
		[
			'group'=>true,
			'label'=>false,
			'rowOptions'=>['class'=>'info'],
			'groupOptions'=>['class'=>'text-left'] //text-center 
		],
		[
        	'attribute'=>'ACTUAL_DATE1', 
	        'format'=>'datetime',
	        'value'=>new DateTime(),
	        'type'=>DetailView::INPUT_DATETIME,
	        'widgetOptions' => [
	            'pluginOptions'=>['format' => 'dd-MM-yyyy HH:ii P'],
	            'pluginEvents'=>[
		       'show' => "function(e) {errror}",
		           ],
	        ],
	        'valueColOptions'=>['style'=>'width:55%']
    	],
		
		[
        	'attribute'=>'ACTUAL_DATE2', 
	         'format'=>'datetime',
	         'type'=>DetailView::INPUT_DATETIME,
	        'value'=>new DateTime(),
	        'widgetOptions' => [

	            'pluginOptions'=>['format' => 'dd-MM-yyyy HH:ii P'],
	            'pluginEvents'=>[
		       'show' => "function(e) {errror}",
		           ],
	        ],
	        'valueColOptions'=>['style'=>'width:55%']
    	],
	];

	/*update destination*/
	$dest = [
		[
			'group'=>true,
			'label'=>false,
			'rowOptions'=>['class'=>'info'],
			'groupOptions'=>['class'=>'text-left'] //text-center 
		],
		[
        	'attribute'=>'USER_CC', 
	        'type'=>DetailView::INPUT_SELECT2,
	         'value'=>$model->employenmcc,
	        'widgetOptions'=>[
				'data'=>$dropemploy,
				'options'=>['placeholder'=>'Select ...'],
				'pluginOptions'=>['allowClear'=>true],
			],	
	        'valueColOptions'=>['style'=>'width:30%']
    	],	
		[
           'attribute'=>'DESTINATION_TO', 
	       'type'=>DetailView::INPUT_SELECT2,
	       'value'=>$model->employenm,
	       'widgetOptions'=>[
				'data'=>$dropemploy,
				'options'=>['placeholder'=>'Select ...'],
				'pluginOptions'=>['allowClear'=>true],
			],	
	        'valueColOptions'=>['style'=>'width:30%']
    	],
    	[
    		//BOBOT
			'attribute' =>'DSCRP',
			// 'visible'=> true,
			// 'displayOnly'=>true,
			'type'=>DetailView::INPUT_TEXTAREA ,
    	],
	];


	/*update parent*/
	$parent = [
		[
			'group'=>true,
			'label'=>false,
			'rowOptions'=>['class'=>'info'],
			'groupOptions'=>['class'=>'text-left'] //text-center 
		],
		[
        	'attribute'=>'parentpilot', 
	        'type'=>DetailView::INPUT_SWITCH,
	        'format'=>'raw',
        	'value'=>$model->PARENT == 0 ? '<span class="label label-success">Parent</span>' : '<span class="label label-danger">No Parent</span>',
			'widgetOptions' => [
			'options'=>['id'=>'parent-id'],
            'pluginOptions' => [
                'onText' => 'Yes',
                'offText' => 'No',
            ]
        ],
	        'valueColOptions'=>['style'=>'width:30%']
    	],	
		[
           'attribute'=>'PARENT', 
	       'type'=>DetailView::INPUT_SELECT2,
	       'value'=>$model->PARENT != 0?$model->parentName : $model->PILOT_NM,
	       'widgetOptions'=>[
				'data'=>$pilot,
				'options'=>['placeholder'=>'Select ...'],
				'pluginOptions'=>['allowClear'=>true],
			],	
	        'valueColOptions'=>['style'=>'width:30%']
    	],
	];

	// /*data detail*/
	// $data_detail = [
	// 	[
	// 		'group'=>true,
	// 		'label'=>false,
	// 		'rowOptions'=>['class'=>'info'],
	// 		'groupOptions'=>['class'=>'text-left'] //text-center 
	// 	],
	// 	[ 	//TLP1
	// 		'attribute' =>'CUST_NM',
	// 		'label'=>'Customers.nm:',
	// 		'type'=>DetailView::INPUT_TEXT,
	// 		'labelColOptions' => ['style' => 'text-align:right;width: 15px']
	// 	],
	// 	[ 	//TLP1
	// 		'attribute' =>'TLP1',
	// 		'label'=>'TLP1',
	// 		'type'=>DetailView::INPUT_TEXT,
	// 		'labelColOptions' => ['style' => 'text-align:right;width: 15px']
	// 	],
	// 	[ 	//PIC
	// 		'attribute' =>'PIC',
	// 		'label'=>'PIC',
	// 		'type'=>DetailView::INPUT_TEXT,
	// 		'labelColOptions' => ['style' => 'text-align:right;width: 15px']
	// 	],

	// 	[ 	//TLP2
	// 		'attribute' =>'TLP2',
	// 		'label'=>'TLP2',
	// 		'type'=>DetailView::INPUT_TEXT,
	// 		'labelColOptions' => ['style' => 'text-align:right;width: 15px']
	// 	],
	// 	[ 	//EMAIL
	// 		'attribute' =>'EMAIL',
	// 		'label'=>'EMAIL',
	// 		'type'=>DetailView::INPUT_TEXT,
	// 		'labelColOptions' => ['style' => 'text-align:right;width: 15px']
	// 	],
	// 	[
 //        'attribute'=>'JOIN_DATE', 
 //        'format'=>'date',
 //        'type'=>DetailView::INPUT_DATE,
 //        'widgetOptions' => [
 //            'pluginOptions'=>['format'=>'yyyy-mm-dd'],
 //            'pluginEvents'=>[
	//        'show' => "function(e) {errror}",
	//            ],
 //        ],
 //        'valueColOptions'=>['style'=>'width:30%']
 //    ],

	// 	[ 	//FAX
	// 		'attribute' =>'FAX',
	// 		'label'=>'FAX',
	// 		'type'=>DetailView::INPUT_TEXT,
	// 		'labelColOptions' => ['style' => 'text-align:right;width: 15px']
	// 	],
	// 	[ 	//NPWP
	// 		'attribute' =>'NPWP',
	// 		'label'=>'NPWP',
	// 		'type'=>DetailView::INPUT_TEXT,
	// 		'labelColOptions' => ['style' => 'text-align:right;width: 15px']
	// 	],
	// 	[ 	//WEBSITE
	// 		'attribute' =>'WEBSITE',
	// 		'label'=>'WEBSITE',
	// 		'type'=>DetailView::INPUT_TEXT,
	// 		'labelColOptions' => ['style' => 'text-align:right;width: 15px']
	// 	],
	// 	[ 	//STATUS
	// 		'attribute' =>'STATUS',
	// 		'format'=>'raw',
	// 		'value'=>$model->STATUS ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>',
	// 		'type'=>DetailView::INPUT_SWITCH,
 //        	'widgetOptions' => [
 //            'pluginOptions' => [
 //                'onText' => 'Aktif',
 //                'offText' => 'Tidak Aktif',
 //            ]
 //        ],
 //          'valueColOptions'=>['style'=>'width:30%']
	// ]
	// ];

	// /*actual data View Editing*/
	$actual_view=DetailView::widget([
		'id'=>'actual-id',
		'model' => $model,
		'attributes'=>$actual,
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',
		'panel'=>[
					'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b> Actual</b></h6></div>',
					'type'=>DetailView::TYPE_INFO,
				],
		// 'saveOptions'=>[ 
		// 	'id' =>'saveBtn',
		// 	'value'=>'/master/customers/viewcust?id='.$model->CUST_KD,
		// 	'params' => ['custom_param' => true],
		// ],		
	]);

	// /*destination data View Editing*/
	$dest_view=DetailView::widget([
		'id'=>'destination-id',
		'model' => $model,
		'attributes'=>$parent,
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',
		'panel'=>[
					'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b> pilih parent</b></h6></div>',
					'type'=>DetailView::TYPE_INFO,
				],
		// 'saveOptions'=>[ 
		// 	'id' =>'saveBtn',
		// 	'value'=>'/master/customers/viewcust?id='.$model->CUST_KD,
		// 	'params' => ['custom_param' => true],
		// ],		
	]);

	// /*destination data View Editing*/
	$desta=DetailView::widget([
		'id'=>'desta-id',
		'model' => $model,
		'attributes'=>$dest,
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',
		'panel'=>[
					'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b>Description</b></h6></div>',
					'type'=>DetailView::TYPE_INFO,
				],
		// 'saveOptions'=>[ 
		// 	'id' =>'saveBtn',
		// 	'value'=>'/master/customers/viewcust?id='.$model->CUST_KD,
		// 	'params' => ['custom_param' => true],
		// ],		
	]);


	
	// /*Detail alias View Editing*/
	$alias=DetailView::widget([
		'id'=>'plan-id',
		'model' => $model,
		'attributes'=>$attalias,
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',
		'panel'=>[
					'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b>Update Planning</b></h6></div>',
					'type'=>DetailView::TYPE_INFO,
				],
		// 'saveOptions'=>[ 
		// 	'id' =>'saveBtn',
		// 	'value'=>'/master/customers/viewcust?id='.$model->CUST_KD,
		// 	'params' => ['custom_param' => true],
		// ],		
	]);
	
	// /*update alamat*/
	// $update_alamat_view = [
	// 	[
	// 		'group'=>true,
	// 		'label'=>false,
	// 		'rowOptions'=>['class'=>'info'],
	// 		'groupOptions'=>['class'=>'text-left'] //text-center 
	// 	],
	// 	[ 	//PROVINCE_ID
	// 		'attribute' =>'PROVINCE_ID',
	// 		'format'=>'raw',
	// 		'value'=>$model->custprov->PROVINCE,
	// 		'type'=>DetailView::INPUT_SELECT2,
	// 		'widgetOptions'=>[
	// 			'data'=>$valpro,
	// 			'options'=>['placeholder'=>'Select ...'],
	// 			'pluginOptions'=>['allowClear'=>true],
	// 		],	
	// 	],
	// 	[ 	//CITY_ID
	// 		'attribute' =>'CITY_ID',
	// 		'format'=>'raw',
	// 		'value'=>$model->custkota->CITY_NAME,
	// 		'type'=>DetailView::INPUT_DEPDROP,
	// 		'widgetOptions'=>[
	// 			'options' => ['id'=>'customers-city_id',
	// 		'placeholder' => 'Select Kota'],
	// 		'type' => DepDrop::TYPE_SELECT2,
	// 		'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
	// 		'pluginOptions'=>[
	// 			'depends'=>['customers-province_id'],
	// 			'url' => Url::to(['/master/customers/lisarea']),
	// 		  'loadingText' => 'Loading data ...',
	// 		]
	// 		],	
	// 	],
	// 	// ALAMAT
	// 	[
	// 		'attribute' =>	'ALAMAT',
	// 		'label'=>'Alamat',
	// 		'type'=>DetailView::INPUT_TEXTAREA,
	// 		'labelColOptions' => ['style' => 'text-align:right;width: 15px']
	// 	],
	// ];

	
	// /*Detail View ALAMAT Editing*/
	// $detail_alamat=DetailView::widget([
	// 	'id'=>'update-alamat-detail-id',
	// 	'model' => $model,
	// 	'attributes'=>$update_alamat_view ,
	// 	'condensed'=>true,
	// 	'hover'=>true,
	// 	'mode'=>DetailView::MODE_VIEW,
	// 	'buttons1'=>'{update}',
	// 	'buttons2'=>'{view}{save}',
	// 	'panel'=>[
	// 				'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b>Update Alamat</b></h6></div>',
	// 				'type'=>DetailView::TYPE_INFO,
	// 			],
	// 	'saveOptions'=>[ 
	// 		'id' =>'saveBtn',
	// 		'value'=>'/master/customers/viewcust?id='.$model->CUST_KD,
	// 		'params' => ['custom_param' => true],
	// 	],		
	// ]);

	// 	/*update kategori*/
	$detail = [
		[
			'group'=>true,
			'label'=>false,
			'rowOptions'=>['class'=>'info'],
			'groupOptions'=>['class'=>'text-left'] //text-center 
		],
		[ 	//PILOT_NM
			'attribute' =>'PILOT_NM',

		],
		[ 	//BOBOT
			'attribute' =>'BOBOT',
			'type'=>DetailView::INPUT_RANGE ,
    	],
    	[ 	//BOBOT
			'attribute' =>'COLOR',
			'type'=>DetailView::INPUT_COLOR ,
    	],
    	[
        	'attribute'=>'STATUS', 
	        'type'=>DetailView::INPUT_SWITCH,
	        'format'=>'raw',
        	'value'=>$model->STATUS != 1 ? '<span class="label label-success">OPEN</span>' : '<span class="label label-danger">CLOSE</span>',
        'widgetOptions' => [
            'pluginOptions' => [
                'onText' => 'OPEN',
                'offText' => 'CLOSE',
            ]
        ],
	        'valueColOptions'=>['style'=>'width:30%']
    	],	
    	
		// 	],
				
		// ],
	];

	
	/*Detail View Kategori Editing*/
	$detail_update=DetailView::widget([
		'id'=>'detail-view',
		'model' => $model,
		'attributes'=>$detail,
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',
		'panel'=>[
					'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b>Detail Pilot</b></h6></div>',
					'type'=>DetailView::TYPE_INFO,
				],
		// 'saveOptions'=>[ 
		// 	'id' =>'saveBtn',
		// 	'value'=>'/master/customers/viewcust?id='.$model->CUST_KD,
		// 	'params' => ['custom_param' => true],
		// ],		
	]);
	
	
	
	
// $this->registerJs("
 
//  $('#pilotproject-pilot_nm').change(function(){
//  	alert('tes');
//  })

// ",$this::POS_READY);

	
?>
<div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="row" >
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<?= $pilotviewinfo ?>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			 <?= $alias ?>
		</div>
		</div>
		<div class="row" >
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<?= $dest_view?>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<?= $desta?>
		</div>
		</div>
		<div class="row" >
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			
			<?= $detail_update?>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			
			
			<?= $actual_view?>
		</div>
	</div>
</div>


