<?php
use yii\helpers\Url;
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\nav\NavX;

/*namespace models*/
use lukisongroup\master\models\Kategoricus;

$this->params['breadcrumbs'][] = $this->title;
$this->sideCorp = 'Customers';                 				 /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = $sideMenu_control;//'umum_datamaster';   	 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Customers');   	 			 /* title pada header page */


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


$actionClass='btn btn-info btn-xs';
$actionLabel='Update';
$attDinamik =[];
/*GRIDVIEW ARRAY FIELD HEAD*/
$headColomnBT=[
  ['ID' =>0, 'ATTR' =>['FIELD'=>'CUST_KTG_PARENT','SIZE' => '10px','label'=>'Customer Kategori Parent','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_KTG_NM','SIZE' => '10px','label'=>'Customers Kategori','align'=>'left','warna'=>'97, 211, 96, 0.3']],
];
$gvHeadColomnBT = ArrayHelper::map($headColomnBT, 'ID', 'ATTR');



/*GRIDVIEW ARRAY ROWS*/
foreach($gvHeadColomnBT as $key =>$value[]){
 
  if($value[$key]['FIELD'] == 'CUST_KTG_PARENT'){
      $attDinamik[]=[
        'attribute'=>$value[$key]['FIELD'],
        'label'=>$value[$key]['label'],
       'value'=>function ($model, $key, $index, $widget) {
              $kategori = Kategoricus::find()
                          ->where(['CUST_KTG'=>$model->CUST_KTG_PARENT])
                          ->one();

              return $kategori->CUST_KTG_NM;},
              'filterType'=>GridView::FILTER_SELECT2,
              'filter'=>ArrayHelper::map(Kategoricus::find()
                                        ->where('CUST_KTG_PARENT = CUST_KTG')
                                        ->asArray()
                                        ->all(), 'CUST_KTG', 'CUST_KTG_NM'),
              'filterWidgetOptions'=>[
              'pluginOptions'=>['allowClear'=>true],
                            ],
              'filterInputOptions'=>['placeholder'=>'Customers Group'],

               'group'=>true,
                 
        'hAlign'=>'right',
        'vAlign'=>'middle',
        'noWrap'=>true,
        'headerOptions'=>[
            'style'=>[
            'text-align'=>'center',
            'width'=>$value[$key]['FIELD'],
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
            'background-color'=>'rgba('.$value[$key]['warna'].')',
          ]
        ],
        'contentOptions'=>[
          'style'=>[
            'text-align'=>$value[$key]['align'],
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
          ]
        ],
              'width'=>'12px',
      ];

    }else{
      # code...
      $attDinamik[]=[
        'attribute'=>$value[$key]['FIELD'],
        'label'=>$value[$key]['label'],
        'filter'=>true,
        'hAlign'=>'right',
        'vAlign'=>'middle',
        'noWrap'=>true,
        'headerOptions'=>[
            'style'=>[
            'text-align'=>'center',
            'width'=>$value[$key]['FIELD'],
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
            'background-color'=>'rgba('.$value[$key]['warna'].')',
          ]
        ],
        'contentOptions'=>[
          'style'=>[
            'text-align'=>$value[$key]['align'],
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
          ]
        ],
              'width'=>'12px',
      ];

    }

};

/*GRIDVIEW ARRAY ACTION*/
$attDinamik[]=[
  'class'=>'kartik\grid\ActionColumn',
  'dropdown' => true,
  'template' => '{edit} {view} {update}',
  'dropdownOptions'=>['class'=>'pull-left dropup','style'=>['disable'=>true]],
  'dropdownButton'=>[
    'class' => $actionClass,
  ],
  'buttons' => [ 'edit' =>function($url, $model, $key){
    return  '<li>' .  Html::a('<span class="glyphicon glyphicon-plus"></span>'.Yii::t('app', 'Tambah'),['create','id'=> $model->CUST_KTG_PARENT],['data-toggle'=>"modal",'data-target'=>"#formparent",
                            'data-title'=> $model->CUST_KTG_NM,
                                ]).'<li>';},
                  'view' =>function($url, $model, $key){
                    return  '<li>' . Html::a('<span class="glyphicon glyphicon-eye-open"></span>'.Yii::t('app', 'View'),['view','id'=>$model->CUST_KTG],['data-toggle'=>"modal", 'data-target'=>"#viewparent",'data-title'=> $model->CUST_KTG_PARENT, ]).'</li>'; },

                         'update' =>function($url, $model, $key){
                                 return  '<li>'. Html::a('<span class="glyphicon glyphicon-pencil"></span>'.Yii::t('app', 'Update'),['update-kate','id'=>$model->CUST_KTG],[
                                                            'data-toggle'=>"modal",
                                                            'data-target'=>"#formparent",
                                                            'data-title'=> $model->CUST_KTG_PARENT,
                                                            ]).'</li>';

                                                            },

                                              ],

                                         
  'headerOptions'=>[
    'style'=>[
      'text-align'=>'center',
      'width'=>'10px',
      'font-family'=>'tahoma, arial, sans-serif',
      'font-size'=>'9pt',
      'background-color'=>'rgba(97, 211, 96, 0.3)',
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
];


/*SHOW GRID VIEW LIST*/
 $tabcrud =  GridView::widget([
  'id'=>'gv-kat',
  'dataProvider' => $dataProviderkat,
  'filterModel' => $searchModel1,
  'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
  'columns' => $attDinamik,
  'pjax'=>true,
  'pjaxSettings'=>[
    'options'=>[
      'enablePushState'=>false,
      'id'=>'gv-kat',
    ],
  ],
   'panel'=>[

                'type' =>GridView::TYPE_SUCCESS,
                'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create Parent ',
                        ['modelClass' => 'Kategoricus',]),'/master/customers-kategori/createparent',[
                                                            'data-toggle'=>"modal",
                                                            'data-target'=>"#formparent",
                                                            'class' => 'btn btn-success btn-xs'
                                                            ])
                    ],
  'toolbar'=> [
    //'{items}',
  ],
  'hover'=>true, //cursor select
  'responsive'=>true,
  'responsiveWrap'=>true,
  'bordered'=>true,
  'striped'=>true,
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
		  <!-- CUTI !-->
		  <?php
				echo $navmenu;
		  ?>
		  <!-- CUTI !-->
		</div>
		<div class="col-sm-12">
			<?php
				echo $tabcrud;
			?>
		</div>
	</div>
</div>
<?php

    // create and update kategori customers via modal
      $this->registerJs("
      $.fn.modal.Constructor.prototype.enforceFocus = function(){};
          $('#formparent').on('show.bs.modal', function (event) {
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
  			'id' => 'formparent',
  			'header' => '<h4 class="modal-title">LukisonGroup</h4>',
  				]);
  	Modal::end();

    // view kategori customers via modal
    $this->registerJs("
          $('#viewparent').on('show.bs.modal', function (event) {
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
              'id' => 'viewparent',
              'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                  ]);
      Modal::end();

     ?>
