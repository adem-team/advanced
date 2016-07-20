
<?php
use yii\helpers\Url;
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\nav\NavX;
use crm\mastercrm\models\Customers;
use yii\helpers\ArrayHelper;
use mdm\admin\components\Helper;



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
  $url1 = Url::toRoute(['/mastercrm/customers-crm/index']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

 
function tombolCreate(){
  $title1 = Yii::t('app', 'Customers');
  $options1 = [ 'id'=>'modcus',
          'data-toggle'=>"modal",
          'data-target'=>"#createcus",
          'class' => 'btn btn-success btn-sm',
          // 'style' => 'text-align:left',
  ];
  $icon1 = '<i class="glyphicon glyphicon-plus"></i>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/mastercrm/customers-crm/createcustomers']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

  if(Helper::checkRoute('createcustomers')){
        $button_create = tombolCreate();
    }else{
        $button_create = "";
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
  $url1 = Url::toRoute(['/mastercrm/customers-crm/index-city']);
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
  $url1 = Url::toRoute(['/mastercrm/customers-crm/index-provinsi']);//,'kd'=>$kd]);
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
  $url1 = Url::toRoute(['/mastercrm/customers-crm/index-kategori']);//,'kd'=>$kd]);
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
  $url1 = Url::toRoute(['/mastercrm/customers-crm/map']);//,'kd'=>$kd]);
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
  $url1 = Url::toRoute(['/mastercrm/customers-crm/login-alias']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}


/*modal*/
Modal::begin([
    'id' => 'modal-view_cus-customer-crm',
    'header' => '<div style="float:left;margin-right:10px" class="fa fa-user"></div><div><h5 class="modal-title"><b>VIEW CUSTOMERS</b></h5></div>',
    'size' => Modal::SIZE_LARGE,
    'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
    ],
  ]);
  echo "<div id='modalContentcustomers-crm'></div>";
  Modal::end();

/*CUSTOMER DATA*/
$tabcustomersData = \kartik\grid\GridView::widget([
  'id'=>'gv-cus-crm',
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
  'filterRowOptions'=>[
  'style'=>'background-color:rgba(126, 189, 188, 0.9); align:center'],
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
        // if($model->CUST_GRP == $model->CUST_KD)
        // {

          return true;
        // }elseif(Yii::$app->getUserOptcrm->Profile_user()->POSITION_LOGIN == 6)
        // {
        //   return true;
        // }
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
            'allowClear' => true,
            'class'=>'pull-top dropup'
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
      'template' =>Helper::filterActionColumn('{viewcust}{create-map}'),
      'header'=>'Action',
      'dropdown' => true,
      'dropdownOptions'=>['class'=>'pull-right dropdown'],
      'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
      'buttons' => [
        'viewcust' =>function($url, $model, $key){
          return  Html::button(Yii::t('app', 'View'),
            ['value'=>url::to(['viewcust','id'=>$model->CUST_KD]),
            'id'=>'modalButtonCustomers-crm',
            'class'=>"btn btn-default btn-xs",      
            'style'=>['width'=>'120px', 'height'=>'25px','text-align'=>'center','border'=> 'none'],
          ]);
      },  
          'create-map' =>function($url, $model,$key){
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
    'before'=>$button_create.' '.

    // Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create  ',
    //         ['modelClass' => 'Customers',]),'/mastercrm/customers-crm/createcustomers',[
    //                           'data-toggle'=>"modal",
    //                           'id'=>'modcus',
    //                            'data-target'=>"#createcus",
    //                            'class' => 'btn btn-success btn-sm'
    //                           ]).' '.
			Html::a('<i class="fa fa-history "></i> '.Yii::t('app', 'Refresh',
            ['modelClass' => 'Customers1',]),'/mastercrm/customers-crm',[
							   'id'=>'refresh-cust',
                               'class' => 'btn btn-info btn-sm'
                              ]).' '.
			Html::a('<i class="fa fa-file-excel-o"></i> '.Yii::t('app', 'Export'),'/export/export/export-data',
								[
									'id'=>'get-export',
									//'data-pjax' => true,
									'class' => 'btn btn-info btn-sm'
								]
					).' '.  
      Html::a('<i class="fa fa-file-excel-o"></i> '.Yii::t('app', 'Export selected'),'',
                [
                    // 'data-toggle'=>"modal",
                    'id'=>'exportmodal',
                    'data-pjax' => true,
                     'data-toggle-export'=>'crm-customers-modal',
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
          )


  ],
  'pjax'=>true,
  'pjaxSettings'=>[
    'options'=>[
      'enablePushState'=>false,
      'id'=>'gv-cus-crm',
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
				['label' => '<span class="fa fa-user fa-md"></span>Customers', 'url' => '/mastercrm/customers-crm/index'],
				['label' => '<span class="fa fa-cogs fa-md"></span>Alias Customers', 'url' => '/mastercrm/customers-crm/login-alias','linkOptions'=>['id'=>'performance','data-toggle'=>'modal','data-target'=>'#formlogin']],
				'<li class="divider"></li>',
				['label' => 'Properties', 'items' => [
					['label' => '<span class="fa fa-flag fa-md"></span>Kota', 'url' => '/mastercrm/kota-customers-crm/index'],
					['label' => '<span class="fa fa-flag-o fa-md"></span>Province', 'url' => '/mastercrm/provinsi-customers-crm/index'],
					['label' => '<span class="fa fa-table fa-md"></span>Category', 'url' => '/mastercrm/kategori-customers-crm/index'],
					'<li class="divider"></li>',
					['label' => '<span class="fa fa-map-marker fa-md"></span>Customers Map', 'url' => '/mastercrm/customers-crm/crm-map'],
				]],
			]],

		]
	]);
?>
<div class="content">
  <div  class="row" style="padding-left:3px">
		<div class="col-sm-12 col-md-12 col-lg-12" >
		 <?php
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



<?php
/** *js export if click then export 
    *@author adityia@lukison.com

**/
$this->registerJs("
$(document).on('click', '[data-toggle-export]', function(e){

  e.preventDefault();

  var keysSelect = $('#gv-cus-crm').yiiGridView('getSelectedRows');
  if(keysSelect == '')
  {
    alert('sorry your not selected item')
  }else{

  $.ajax({
           url: '/export/export/export-data-crm',
           //cache: true,
           type: 'POST',
           data:{keysSelect:keysSelect},
           dataType: 'json',
           success: function(response) {
             if (response.status== true ){
                 $.pjax.reload('#gv-cus-crm');

             }
              else {
                alert('Item already exists ');
              }
            }
          });
        }

})

// })

",$this::POS_READY);


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
    $(document).on('click','#modalButtonCustomers-crm', function(ehead){ 
        $.fn.modal.Constructor.prototype.enforceFocus = function(){};
        //e.preventDefault();     
        localStorage.clear();
        localStorage.setItem('nilai',ehead.target.value);     
        localStorage.setItem('sts','show');
        $('#modal-view_cus-customer-crm').modal('show')
        .find('#modalContentcustomers-crm')
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
    $('#modal-view_cus-customer-crm').on('hidden.bs.modal', function () {
      localStorage.setItem('sts','hidden');
    });
    
    /*
     * CALL BACK SHOW MODAL
     * @author wawan [aditiya@lukison.com]
    */  
    setTimeout(function(){
      $('#modal-view_cus-customer-crm').modal(stt)
      .find('#modalContentcustomers-crm')
      .load(nilaiValue);
    }, 1000);  
  });
  ",$this::POS_READY);


 

  // create customers-crm via modal
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

 ?>
