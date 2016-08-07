
<?php
use yii\helpers\Url;
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\nav\NavX;
use lukisongroup\master\models\Customers;
use yii\helpers\ArrayHelper;
// use lukisongroup\assets\MapAsset;       /* CLASS ASSET CSS/JS/THEME Author: -wawan-*/
// MapAsset::register($this);


$this->params['breadcrumbs'][] = $this->title;
$this->sideCorp = 'Customers';                 				 /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = $sideMenu_control;//'umum_datamaster';   	 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Customers');   	 			 /* title pada header page */

// $parent = ArrayHelper::map(Customers::find()->where('STATUS<>3 and CUST_KD=CUST_GRP')->all(), 'CUST_KD', 'CUST_NM');

/*modal*/
Modal::begin([
    'id' => 'modal-view_cus-customer',
    'header' => '<div style="float:left;margin-right:10px" class="fa fa-user"></div><div><h5 class="modal-title"><b>VIEW CUSTOMERS</b></h5></div>',
    'size' => Modal::SIZE_LARGE,
    'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
    ],
  ]);
  echo "<div id='modalContentcustomers'></div>";
  Modal::end();

/*CUSTOMER DATA*/
$tabcustomersData = \kartik\grid\GridView::widget([
  'id'=>'gv-cus-erp',
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
  'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.9); align:center'],
  // 'floatHeader'=>true,
  // 'floatHeaderOptions'=>['scrollingTop'=>'50'],
  'columns'=>[
    [
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
          'background-color'=>'rgba(126, 189, 188, 0.9)',
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
    ],
     [
      'class' => '\kartik\grid\CheckboxColumn',
      'contentOptions'=>['class'=>'kartik-sheet-style'],
      'width'=>'10px',
      // 'header'=>'No.',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'10px',
          'font-family'=>'verdana, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
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
    ],
    [
      'attribute' => 'parentName',
      'label'=>'Customer Group',
      'filterType'=>GridView::FILTER_SELECT2,
      'filter' => $parent,

	  'filterOptions'=>[
		'colspan'=>2,
	  ],
	  'filterWidgetOptions'=>[
        'pluginOptions'=>[
			'allowClear'=>true,
			'contentOptions'=>[
				'style'=>[
				  'text-align'=>'left',
				  'font-family'=>'tahoma, arial, sans-serif',
				  'font-size'=>'8pt',
				]
			]
		],
	  ],
      'filterInputOptions'=>['placeholder'=>'Parent Customer'],
      'hAlign'=>'left',
      'vAlign'=>'top',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'250px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'250px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
      'group'=>true,
    ],
    [
    	'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'CUST_KD',
      'refreshGrid'=>true,
      'readonly'=>function($model, $key, $index, $widget){ // readonly
        if($model->CUST_GRP == $model->CUST_KD)
        {

          return true;
        }else{
			 return false;
		}
      },  
      'label'=>'Customer.Id',
      'hAlign'=>'left',
      'vAlign'=>'top',
  	  'filter'=>false,
  	  'mergeHeader'=>true,
  	  'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'120px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
		  'style'=>[
		  'vertical-align'=>'text-middle',
          'text-align'=>'left',
          'width'=>'120px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
    
      'editableOptions' => [
        'header' => 'Customers',
        'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
        'size' => 'md',
        'options' => [
          'data' =>$parent,
          'pluginOptions' => [
            'allowClear' => true
          ],
        ],
        
        //Refresh Display
        // 'displayValueConfig' => ArrayHelper::map(Customers::find()->where('STATUS<>3')->all(), 'CUST_KD', 'CUST_KD'),
      ],
    ],
   
    [
      'attribute' => 'CUST_NM',
      'label'=>'Customer Name',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'250px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'250px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
    ],
      
    [
      'attribute' => 'cus.CUST_KTG_NM',
	  'label'=>'Category',
      'filter' => $dropType,
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'100px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'100px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
        // 'group'=>true,
    ],
    [
      'attribute' =>'custype.CUST_KTG_NM',
      'filter' => $dropKtg,
	  'label'=>'Type',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'230px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'230px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
    ],
	[
		'class'=>'kartik\grid\EditableColumn',
		'attribute' => 'GEO',
		'refreshGrid'=>true,
		'label'=>'Geo',
		'hAlign'=>'left',
		'vAlign'=>'top',
		'filter'=>true,
		'filterType'=>GridView::FILTER_SELECT2,
		'filter' => $data_group,
		'filterWidgetOptions'=>[
			'pluginOptions'=>[
				'allowClear'=>true,
				'contentOptions'=>[
					'style'=>[
					  'text-align'=>'left',
					  'font-family'=>'tahoma, arial, sans-serif',
					  'font-size'=>'8pt',
					]	
				]
			],
		],
		'filterInputOptions'=>['placeholder'=>'Select'],
		// 'mergeHeader'=>true,
		'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'120px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
		],
			'contentOptions'=>[
			'style'=>[
				'vertical-align'=>'text-middle',
				  'text-align'=>'center',
				  'width'=>'120px',
				  'font-family'=>'tahoma, arial, sans-serif',
				  'font-size'=>'8pt',
			]
		],    
		'editableOptions' => [
			'header' => 'GEO',
			'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
			'size' => 'xs',
			'options' => [
			  'data' =>$data_group,
			  'pluginOptions' => [
				'allowClear' => true,
				
			  ],
			],    
			// Refresh Display
			'displayValueConfig' => $data_group,
		],
    ],
	[
		'class'=>'kartik\grid\EditableColumn',
		'attribute' => 'LAYER',
		'refreshGrid'=>true,
		'label'=>'Layer',
		'hAlign'=>'left',
		'vAlign'=>'top',
		'filter'=>true,
		'filterType'=>GridView::FILTER_SELECT2,
		'filter' => $data_layer,
		'filterWidgetOptions'=>[
		'pluginOptions'=>[
			'allowClear'=>true,
			'contentOptions'=>[
					'style'=>[
					  'text-align'=>'left',
					  'font-family'=>'tahoma, arial, sans-serif',
					  'font-size'=>'8pt',
					]
				]
			],
		],
		'filterInputOptions'=>['placeholder'=>'Select'],
		// 'mergeHeader'=>true,
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'120px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'vertical-align'=>'text-middle',
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
			]
		],    
		'editableOptions' => [
		'header' => 'layer',
		'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
		'size' => 'xs',
		'options' => [
				'data' =>$data_layer,
				'pluginOptions' => [
					'allowClear' => true,
					// 'class'=>'pull-top dropup'
				],
			],    
			// Refresh Display
			'displayValueConfig' => $data_layer,
		],
	],
	/* //test
		[
		'attribute' => 'layerNm',
		'label'=>'Layer',
		'hAlign'=>'left',
		'vAlign'=>'top',
		'filter'=>false,
		// 'mergeHeader'=>true,
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'120px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'vertical-align'=>'text-middle',
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
			]
		],
	], */
    [
      'attribute' => 'STATUS',
      'filter' => $valStt,
      'format' => 'raw',
      'hAlign'=>'center',
      'value'=>function($model){
             if ($model->STATUS == 1) {
              return Html::a('<i class="fa fa-edit"></i> &nbsp;Enable', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
            } else if ($model->STATUS == 0) {
              return Html::a('<i class="fa fa-close"></i> &nbsp;Disable', '',['class'=>'btn btn-danger btn-xs', 'title'=>'Deactive']);
            }
      },
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'80px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'80px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
    ],
    [
      'class' => 'kartik\grid\ActionColumn',
      'template' => '{view}{edit}',
      'header'=>'Action',
      'dropdown' => true,
      'dropdownOptions'=>['class'=>'pull-right dropup'],
      'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
      'buttons' => [
            'view' =>function($url, $model, $key){
					  return  Html::button(Yii::t('app', 'View Customers'),
						['value'=>url::to(['viewcust','id'=>$model->CUST_KD]),
						'id'=>'modalButtonCustomers',
						'class'=>"btn btn-default btn-xs",      
						'style'=>['width'=>'170px', 'height'=>'25px','border'=> 'none'],
					  ]);
				  },        
            'edit' =>function($url, $model,$key){
                  return '<li>'. Html::a('<i class="glyphicon glyphicon-globe"></i>'.Yii::t('app', 'Create Map'),
                                ['create-map','id'=>$model->CUST_KD],
                                 [

                                ]).'</li>';

                   },

      ],
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          //'width'=>'150px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          '//width'=>'150px',
          //'height'=>'10px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
    ],
  ],
  'toolbar'=>[
	''
  ],
  'panel'=>[
    // 'type' =>GridView::TYPE_SUCCESS,
    'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create  ',
            ['modelClass' => 'Customers',]),'/master/customers/createcustomers',[
                              'data-toggle'=>"modal",
                              'id'=>'modcus',
                               'data-target'=>"#createcus",
                               'class' => 'btn btn-success btn-sm'
                              ]).' '.
			Html::a('<i class="fa fa-history "></i> '.Yii::t('app', 'Refresh',
					['modelClass' => 'Customers1',]),'/master/customers',[
									   'id'=>'refresh-cust-erp',
									   'data-pjax' => 0,
									   'class' => 'btn btn-info btn-sm'
									  ]).' '.
			Html::a('<i class="fa fa-file-excel-o"></i> '.Yii::t('app', 'Export All'),'/export/export/export-data',
								[
									'id'=>'export-data-erp-customers',
									'data-pjax' => 0,
									'class' => 'btn btn-info btn-sm'
								]
					).' '.  Html::a('<i class="fa fa-file-excel-o"></i> '.Yii::t('app', 'Export selected'),'',
                [
                    // 'data-toggle'=>"modal",
                    'id'=>'exportmodal-erp',
                    'data-pjax' => 0,
                     'data-toggle-export-erp'=>'erp-customers-modal',
                    // 'data-target'=>"#export-mod",
                    'class' => 'btn btn-success btn-sm'
                 
                ]
          ).' '.  Html::a('<i class="fa fa-file-excel-o"></i> '.Yii::t('app', 'Pilih Export'),'/export/export/pilih-export-data',
                [
                    'data-toggle'=>"modal",
                    'id'=>'exportmodal-erp-pilih',
                    'data-target'=>"#export-mod",
                    'class' => 'btn btn-success btn-sm'
                 
                ]
          ).' '.  Html::a('<i class="fa fa-file-excel-o"></i> '.Yii::t('app', 'Pilih delete'),'',
                [
                    'data-toggle-delete-erp'=>'erp-customers-delete',
                    'id'=>'delete-all-erp',
                    'data-pjax' => 0,
                    'class' => 'btn btn-danger btn-sm'
                 
                ]
            )

  ],
  'pjax'=>true,
  'pjaxSettings'=>[
    'options'=>[
      'enablePushState'=>false,
      'id'=>'gv-cus-erp',
    ],
  ],
  'summary'=>false,
  'hover'=>true,
  'responsive'=>true,
  'responsiveWrap'=>true,
  'bordered'=>true,
  'striped'=>'4px',
  'autoXlFormat'=>true,
  'export'=>[
    'fontAwesome'=>true,
    'showConfirmAlert'=>false,
    'target'=>GridView::TARGET_BLANK
  ],
  ]);
 ?>
<?php
	 $navmenu= NavX::widget([
		'options'=>['class'=>'nav nav-tabs'],
		'encodeLabels' => false,
		'items' => [
			['label' => 'MENU', 'active'=>true, 'items' => [
				['label' => '<span class="fa fa-user fa-md"></span>Customers', 'url' => '/master/customers/esm-index'],
				['label' => '<span class="fa fa-cogs fa-md"></span>Alias Customers', 'url' => '/master/customers/login-alias','linkOptions'=>['id'=>'performance','data-toggle'=>'modal','data-target'=>'#formlogin']],
				'<li class="divider"></li>',
				['label' => 'Properties', 'items' => [
					['label' => '<span class="fa fa-flag fa-md"></span>Kota', 'url' => '/master/kota-customers/esm-index-city'],
					['label' => '<span class="fa fa-flag-o fa-md"></span>Province', 'url' => '/master/customers/esm-index-provinsi'],
					['label' => '<span class="fa fa-table fa-md"></span>Category', 'url' => '/master/customers-kategori/esm-index-kategori'],
					['label' => '<span class="fa fa-table fa-md"></span>Geografis', 'url' => '/master/customers/esm-index-geo'],
					['label' => '<span class="fa fa-table fa-md"></span>Layers', 'url' => '/master/customers/esm-index-layer'],
					['label' => '<span class="fa fa-table fa-md"></span>Layers Mutasi', 'url' => '/master/customers/esm-index-layermutasi'],
					'<li class="divider"></li>',
					['label' => '<span class="fa fa-map-marker fa-md"></span>Customers Map', 'url' => '/master/customers/esm-map'],
				]],
			]],

		]
	]);
?>
<div class="content">
  <div  class="row" style="padding-left:3px">
		<div class="col-sm-12 col-md-12 col-lg-12" >
		  <!-- Menu !-->
		  <?php
				echo $navmenu;
		  ?>
		  <!-- Customers !-->
		</div>
		<div class="col-sm-12">
			<?php
				echo $tabcustomersData;
			?>
		</div>
	</div>
</div>


<?php

/** *js export if click then export 
    *@author adityia@lukison.com

**/
//$this->registerJs("
//$(document).on('click', '[data-toggle-refsehs-erp]', function(e){
//
//  e.preventDefault();
//
//  $.pjax.reload({
//				url: '/master/customers/esm-index',
//	            container: '#gv-cus-erp',
//	            timeout: 100,
//        });
//
//})
//
//// })
//
//",$this::POS_READY);


/** *js export if click then export 
    *@author adityia@lukison.com

**/
$this->registerJs("
$(document).on('click', '[data-toggle-delete-erp]', function(e){

  e.preventDefault();

  var keysSelect1 = $('#gv-cus-erp').yiiGridView('getSelectedRows');

  if(keysSelect1 == '')
  {
    alert('sorry your not selected item');
  }else{

  $.ajax({
           url: '/master/customers/delete-erp',
           //cache: true,
           type: 'POST',
           data:{keysSelect:keysSelect1},
           dataType: 'json',
           success: function(result) {
             if (result == 1){
                 $.pjax.reload('#gv-cus-erp');

             }
              else {
                alert('Item already exists ');
              }
            }
          });
        }

})

// })

",$this::POS_LOAD);


/** *js export if click then export 
    *@author adityia@lukison.com

**/
$this->registerJs("
$(document).on('click', '[data-toggle-export-erp]', function(e){

  e.preventDefault();

  var keysSelect = $('#gv-cus-erp').yiiGridView('getSelectedRows');
  if(keysSelect == '')
  {
    alert('sorry your not selected item')
  }else{

  $.ajax({
           url: '/export/export/export-data-erp',
           //cache: true,
           type: 'POST',
           data:{keysSelect:keysSelect},
           dataType: 'json',
           success: function(response) {
             if (response.status== true ){
                 $.pjax.reload('#gv-cus-erp');

             }
              else {
                alert('Item already exists ');
              }
            }
          });
        }

})

// })

",$this::POS_LOAD);


  /*
   * PROCESS EXCEPTION VIEW EDITING
   * @author wawan [aditiya@lukison.com]
   * @since 1.0
   */
  $this->registerJs("
  $(document).ready(function () {

    if(localStorage.getItem('sts')==null){
      //alert(sts);
      localStorage.setItem('sts','hidden');
    };
    
    var stt  = localStorage.getItem('sts');
    var viewaction = localStorage.getItem('view');
    var nilaiValue = localStorage.getItem('nilai');
    localStorage.setItem('sts','hidden');
   
    /*
     * FIRST SHOW MODAL
     * @author wawan [aditiya@lukison.com]
    */
    $(document).on('click','#modalButtonCustomers', function(ehead){ 
      
        //e.preventDefault();     
        localStorage.clear();
        localStorage.setItem('nilai',ehead.target.value);     
        localStorage.setItem('sts','show');
        $('#modal-view_cus-customer').modal('show')
        .find('#modalContentcustomers')
        .load(ehead.target.value);
    });
    
    
    /*
     * STATUS SHOW IF EVENT BUTTON SAVED
     * @author wawan [aditiya@lukison.com]
    */
    $(document).on('click','#saveBtn', function(e){ 
      localStorage.setItem('sts','show');
     
    }); 
  
    
    /*
     * STATUS HIDDEN IF EVENT MODAL HIDE
     * @author wawan [aditiya@lukison.com]
    */
    $('#modal-view_cus-customer').on('hidden.bs.modal', function () {
      localStorage.setItem('sts','hidden');
    });
    
    /*
     * CALL BACK SHOW MODAL
     * @author wawan [aditiya@lukison.com]
    */  
    setTimeout(function(){
      $('#modal-view_cus-customer').modal(stt)
      .find('#modalContentcustomers')
      .load(nilaiValue);
    }, 1000);  
  });
  ",$this::POS_READY);

// create customers via modal
$this->registerJs("
  $.fn.modal.Constructor.prototype.enforceFocus = function(){};

  $('#createcus').on('show.bs.modal', function (event) {
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
  'id' => 'createcus',
  'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">New Customer</h4></div>',
  'headerOptions'=>[
      'style'=> 'border-radius:5px; background-color: rgba(126, 189, 188, 0.9)',
  ],
]);
Modal::end();


// Export customers via modal
$this->registerJs("
 

  $('#export-mod').on('show.bs.modal', function (event) {
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
  'id' => 'export-mod',
  'header' => '<div style="float:left;margin-right:10px" class="fa fa-file-excel-o"></div><div><h4 class="modal-title">Print Customer</h4></div>',
  'headerOptions'=>[
      'style'=> 'border-radius:5px; background-color: rgba(126, 189, 188, 0.9)',
  ],
]);
Modal::end();


