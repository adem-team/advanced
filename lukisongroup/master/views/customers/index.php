
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

$parent = ArrayHelper::map(Customers::find()->where('STATUS<>3 and CUST_KD=CUST_GRP')->all(), 'CUST_KD', 'CUST_NM');

function tombolCustomers(){
  $title1 = Yii::t('app', 'Customers');
  $options1 = [ 'id'=>'setting',
          //'data-toggle'=>"modal",
          // 'data-target'=>"#",
          //'class' => 'btn btn-default',
          'style' => 'text-align:left',
  ];
  $icon1 = '<span class="fa fa-cogs fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-index']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * New|Change|Reset| Password Login
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolKota(){
  $title1 = Yii::t('app', 'Kota');
  $options1 = [ 'id'=>'password',
          // 'data-toggle'=>"modal",
          // 'data-target'=>"#profile-passwrd",
          //'class' => 'btn btn-default',
         // 'style' => 'text-align:left',
  ];
  $icon1 = '<span class="fa fa-shield fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-index-city']);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * Create Signature
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolProvince(){
  $title1 = Yii::t('app', 'Province');
  $options1 = [ 'id'=>'signature',
          //'data-toggle'=>"modal",
          // 'data-target'=>"#profile-signature",
          //'class' => 'btn btn-default',
  ];
  $icon1 = '<span class="fa fa-pencil-square-o fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-index-provinsi']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * Persinalia Employee
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolKategori(){
  $title1 = Yii::t('app', 'Kategori Customers');
  $options1 = [ 'id'=>'personalia',
          //'data-toggle'=>"modal",
          // 'data-target'=>"#profile-personalia",
          // 'class' => 'btn btn-primary',
  ];
  $icon1 = '<span class="fa fa-group fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-index-kategori']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * Performance Employee
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolMap(){
  $title1 = Yii::t('app', 'Map');
  $options1 = [ 'id'=>'performance',
          //'data-toggle'=>"modal",
          // 'data-target'=>"#profile-performance",
          // 'class' => 'btn btn-danger',
  ];
  $icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-map']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

function tombolLoginalias(){
  $title1 = Yii::t('app', 'Alias List');
  $options1 = [ 'id'=>'performance',
                  'data-toggle'=>"modal",
                  'data-target'=>"#formlogin",
  ];
  $icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/login-alias']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}
// $datacus = Customers::find()->where('CUST_GRP = CUST_KD')->asArray()->all();
//   $parent = ArrayHelper::map($datacus,'CUST_KD', 'CUST_NM');
// print_r($parent);
// die();

/*CUSTOMER DATA*/
$tabcustomersData = \kartik\grid\GridView::widget([
  'id'=>'gv-cus',
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
      'attribute' => 'CUST_KD',
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
      'label'=>'PIC',
      'attribute' =>'PIC',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'130px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'130px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
    ],
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
      'template' => '{view}{update}{edit}{alias}{update2}{type}',
      'header'=>'Action',
      'dropdown' => true,
      'dropdownOptions'=>['class'=>'pull-right dropdown'],
      'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
      'buttons' => [
        'view' =>function($url, $model, $key){
            return'<li>'.  Html::a('<span class="glyphicon glyphicon-eye-open"></span> '.Yii::t('app', 'View'),
                          ['viewcust','id'=>$model->CUST_KD],[
                            'data-toggle'=>"modal",
                            'data-target'=>"#view3",
                            'data-title'=> $model->CUST_KD,
                            ]).'</li>';
            },
        'update' =>function($url, $model, $key){
            return '<li>'. Html::a('<span class="glyphicon glyphicon-user"></span>'.Yii::t('app', 'Update Alamat'),
                          ['updatecus','id'=>$model->CUST_KD],[
                          'data-toggle'=>"modal",
                          'data-target'=>"#createcus",
                          'data-title'=> $model->CUST_KD,
                          ]).'</li>';
            },
          'type' =>function($url, $model, $key){
                return '<li>'. Html::a('<span class="glyphicon glyphicon-user"></span>'.Yii::t('app', 'Update Kategori'),
                              ['updatekat','id'=>$model->CUST_KD],[
                              'data-toggle'=>"modal",
                              'data-target'=>"#createcus",
                              'data-title'=> $model->CUST_KD,
                              ]).'</li>';
                },
            'update2' =>function($url, $model, $key){
                return '<li>'. Html::a('<span class="glyphicon glyphicon-user"></span>'.Yii::t('app', 'Update Detail'),
                              ['update-cust','id'=>$model->CUST_KD],[
                              'data-toggle'=>"modal",
                              'data-target'=>"#createcus",
                              'data-title'=> $model->CUST_KD,
                              ]).'</li>';
                },
                'edit' =>function($url, $model,$key){
                  return '<li>'. Html::a('<i class="glyphicon glyphicon-globe"></i>'.Yii::t('app', 'Create Map'),
                                ['create-map','id'=>$model->CUST_KD],
                                 [

                                ]).'</li>';

                   },
          // 'edit' =>function($url, $model,$key){
          //   return '<li>'. Html::a('<i class="glyphicon glyphicon-globe"></i>'.Yii::t('app', 'Create Map'),
          //                 [''],
          //                  [ 'id'=>'approved',
          //                     'data-pjax' => true,
          //                       // 'data'=>['idc'=>$model->ID],
          //                        'data-target'=>'mod',
          //                        'data-toggle-approved'=>$model->CUST_KD,
          //                 ]).'</li>';
          //
          //    },
          'alias' =>function($url, $model, $key){
            return  '<li>'. Html::a('<span class="glyphicon glyphicon-pencil"></span>'.Yii::t('app', 'Set alias'),['create-alias-customers','id'=>$model->CUST_KD],[
                            'data-toggle'=>"modal",
                            'data-target'=>"#formalias",
                            'data-title'=> $model->CUST_KD,
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
			Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Refresh',
            ['modelClass' => 'Customers1',]),'/master/customers',[
							   'id'=>'refresh-cust',
                               'class' => 'btn btn-info btn-sm'
                              ]).' '.
			Html::a('<i class="fa fa-clone"></i> '.Yii::t('app', 'Export'),'/master/customers/export_data',
								[
									//'id'=>'export-data',
									//'data-pjax' => true,
									'class' => 'btn btn-info btn-sm'
								]
					),	

  ],
  'pjax'=>true,
  'pjaxSettings'=>[
    'options'=>[
      'enablePushState'=>false,
      'id'=>'gv-cus-data',
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
					['label' => '<span class="fa fa-flag fa-md"></span>Kota', 'url' => '/master/customers/esm-index-city'],
					['label' => '<span class="fa fa-flag-o fa-md"></span>Province', 'url' => '/master/customers/esm-index-provinsi'],
					['label' => '<span class="fa fa-table fa-md"></span>Category', 'url' => '/master/customers/esm-index-kategori'],
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
		  <!-- CUTI !-->
		  <?php
		  $test='<div class="btn-group pull-left" >'.
				'<button type="button" class="btn btn-info">MENU</button>'.
				'<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">'.
				  '<span class="caret"></span>'.
				  '<span class="sr-only">Toggle Dropdown</span>'.
				'</button>'.
				  '<ul class="dropdown-menu" role="menu">'.
				  '<li>'. tombolCustomers() .'</li>'.
				  '<li>'.  tombolKota().'</li>'.
				  '<li>'.  tombolProvince() .'</li>'.
				  '<li>'.  tombolKategori() .'</li>'.
				  '<li>'.  tombolMap() .'</li>'.
				  '<li>'.  tombolLoginalias() .'</li>'.			  
				  '</ul>'.
				'</div>';
				//echo  $test;
				echo $navmenu;
		  ?>
		  <!-- CUTI !-->
		</div>
		<div class="col-sm-12">
			<?php
				echo $tabcustomersData;
			?>
		</div>
	</div>
</div>

<!-- div class="modal fade" id="myModal" role="dialog"> -->
    <!-- <div class="modal-dialog">

      <!-- Modal content-->
      <!-- <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <div class="row">
                        <div id="map-canvas" class=""></div>
                    </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div> -->

    <!-- </div>
  </div> -->




<?php

// $this->registerJs("
// $(document).on('click', '[data-toggle-approved]', function(e){
//   e.preventDefault();
//   var idx = $(this).data('toggle-approved');
//   $('#myModal').modal('show');
//
// });
//
// ",$this::POS_READY);



/* Login alias*/
$this->registerJs("
  $.fn.modal.Constructor.prototype.enforceFocus = function(){};
  $('#formlogin').on('show.bs.modal', function (event) {
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
      'id' => 'formlogin',
      'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Login Autorize</b></h4></div>',
    'size' => Modal::SIZE_SMALL,
    'headerOptions'=>[
      'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
    ]
  ]);
  Modal::end();

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




// view customers via modal
$this->registerJs("
$.fn.modal.Constructor.prototype.enforceFocus = function(){};

$('#view3').on('show.bs.modal', function (event) {
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
'id' => 'view3',
'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">New Customer</h4></div>',
'headerOptions'=>[
    'style'=> 'border-radius:5px; background-color: rgba(126, 189, 188, 0.9)',
],
]);
Modal::end();

// JS Alias Code customers
$this->registerJs("
  $.fn.modal.Constructor.prototype.enforceFocus = function(){};
  $('#formalias').on('show.bs.modal', function (event) {
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
  'id' => 'formalias',
  'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Alias Customer</h4></div>',
  'headerOptions'=>[
      'style'=> 'border-radius:5px; background-color: rgba(126, 189, 188, 0.9)',
  ],
]);
Modal::end();




 ?>
