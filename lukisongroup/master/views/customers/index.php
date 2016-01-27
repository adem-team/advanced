<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\tabs\TabsX;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Kategoricus;
use yii\web\JsExpression;
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
use lukisongroup\assets\MapAsset;       /* CLASS ASSET CSS/JS/THEME Author: -wawan-*/
MapAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\KategoriSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = $this->title;
$this->sideCorp = 'Customers';                  /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Customers');    /* title pada header page */

?>

<div class="kategori-index">

    <h1><?= Html::encode($this->title) ?></h1>

</div>




<?php

// grid kota
$tabkota = \kartik\grid\GridView::widget([
'id'=>'gv-kota',
'dataProvider' => $dataproviderkota,
'filterModel' => $searchmodelkota,
'columns'=>[
       ['class'=>'kartik\grid\SerialColumn'],
            'PROVINCE',
            'TYPE',
            'CITY_NAME',
            'POSTAL_CODE',
     [ 'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}{update}',
                        'header'=>'Action',
                         'dropdown' => true,
                         'dropdownOptions'=>['class'=>'pull-right dropup'],
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return '<li>'. Html::a('<span class="glyphicon glyphicon-eye-open"></span>'.Yii::t('app', 'View'),
                                                                ['viewkota','id'=> $model->CITY_ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#view2",
                                                                'data-title'=> $model->PROVINCE,
                                                                ]).'<li>';
                                                            },

                             'update' =>function($url, $model, $key){
                                    return '<li>'. Html::a('<span class="glyphicon glyphicon-pencil"></span>'.Yii::t('app', 'Update'),
                                                                ['updatekota','id'=>$model->CITY_ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#form2",
                                                                'data-title'=> $model->PROVINCE,
                                                                ]).'</li>';
                                                            },

                                                  ],

                                            ],
                                   ],

    'panel'=>[

      'type' =>GridView::TYPE_SUCCESS,
			'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
						['modelClass' => 'Barangumum',]),'/master/customers/createkota',[
							'data-toggle'=>"modal",
								'data-target'=>"#form2",
                  'id'=>'modl',
									'class' => 'btn btn-success'
												]),

            ],
                'pjax'=>true,
                'pjaxSettings'=>[
                        'options'=>[
                                    'enablePushState'=>false,
                                    'id'=>'gv-kota',],
        'hover'=>true, //cursor select
        'responsive'=>true,
        'responsiveWrap'=>true,
        'bordered'=>true,
        'striped'=>'4px',
        'autoXlFormat'=>true,
        'export'=>[//export like view grid --ptr.nov-
            'fontAwesome'=>true,
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK
        ],

    ],


 ]);

// grid province

$tabprovince = \kartik\grid\GridView::widget([
  'id'=>'gv-prov',
  'dataProvider' => $dataproviderpro,
  'filterModel' => $searchmodelpro,
   'columns'=>[
       ['class'=>'kartik\grid\SerialColumn'],

             'PROVINCE',

     [ 'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}{update}',
                        'header'=>'Action',
                          'dropdown' => true,
                            'dropdownOptions'=>['class'=>'pull-right dropup'],
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return '<li>'.Html::a('<span class="glyphicon glyphicon-eye-open"></span>'.Yii::t('app', 'View'),
                                                                ['viewpro','id'=> $model->PROVINCE_ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#view3",
                                                                'data-title'=> $model->PROVINCE,
                                                                ]).'</li>';
                            },

                             'update' =>function($url, $model, $key){
                                    return '<li>'. Html::a('<span class="glyphicon glyphicon-pencil"></span>'.Yii::t('app', 'Update'),
                                                                ['updatepro','id'=>$model->PROVINCE_ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#form3",
                                                                'data-title'=> $model->PROVINCE,
                                                                ]).'</li>';
                                                      },

                                               ],
                                       ],
                              ],


    'panel'=>[

      'type' =>GridView::TYPE_SUCCESS,
			'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
						['modelClass' => 'Barangumum',]),'/master/customers/createprovnce',[
							'data-toggle'=>"modal",
								'data-target'=>"#form3",
                  'id'=>'modl22',
									'class' => 'btn btn-success'
												]),
           ],
           'pjax'=>true,
           'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'gv-prov',
        ],
        'hover'=>true, //cursor select
        'responsive'=>true,
        'responsiveWrap'=>true,
        'bordered'=>true,
        'striped'=>'4px',
        'autoXlFormat'=>true,
        'export'=>[//export like view grid --ptr.nov-
            'fontAwesome'=>true,
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK
        ],

    ],


    ]);

?>


<!-- grid kategori customers -->
<?php


$tabcrud = \kartik\grid\GridView::widget([
    'id'=>'gv-kat',
    'dataProvider'=>$dataProviderkat,
    'filterModel'=>$searchModel1,
    'columns'=>[
        ['class'=>'kartik\grid\SerialColumn'],
            [
                  'attribute'=>'CUST_KTG_PARENT',
                  'width'=>'310px',
                  'value'=>function ($model, $key, $index, $widget) {
                   $kategori = Kategoricus::find()->where(['CUST_KTG'=>$model->CUST_KTG_PARENT])
                                                 ->one();

                    return $kategori->CUST_KTG_NM;
                },
                 'filterType'=>GridView::FILTER_SELECT2,
                 'filter'=>ArrayHelper::map(Kategoricus::find()->where('CUST_KTG_PARENT = 0')
                                                              ->asArray()
                                                              ->all(), 'CUST_KTG', 'CUST_KTG_NM'),
                 'filterWidgetOptions'=>[
                 'pluginOptions'=>['allowClear'=>true],
                            ],
                 'filterInputOptions'=>['placeholder'=>'Customers Group'],

                'group'=>true,
                  // 'subGroupOf'=>4
            ],

            [

                'attribute' =>'CUST_KTG_NM'

            ],


        [ 'class' => 'kartik\grid\ActionColumn',
          'template' => ' {edit} {view} {update}',
          'dropdown' => true,
          'dropdownOptions'=>['class'=>'pull-right dropup'],
           'header'=>'Action',
           'buttons' => [

                         'edit' =>function($url, $model, $key){
                                return  '<li>' .  Html::a('<span class="glyphicon glyphicon-plus"></span>'.Yii::t('app', 'Tambah'),['create','id'=> $model->CUST_KTG_PARENT],[
                                                            'data-toggle'=>"modal",
                                                            'data-target'=>"#formparent",
                                                            'data-title'=> $model->CUST_KTG_NM,
                                                            ]).'<li>';
                                                          },

                        'view' =>function($url, $model, $key){
                                return  '<li>' . Html::a('<span class="glyphicon glyphicon-eye-open"></span>'.Yii::t('app', 'View'),['view','id'=>$model->CUST_KTG],[
                                                            'data-toggle'=>"modal",
                                                            'data-target'=>"#viewparent",
                                                            'data-title'=> $model->CUST_KTG_PARENT,
                                                            ]).'</li>';
                                                          },

                         'update' =>function($url, $model, $key){
                                 return  '<li>'. Html::a('<span class="glyphicon glyphicon-pencil"></span>'.Yii::t('app', 'Update'),['update','id'=>$model->CUST_KTG],[
                                                            'data-toggle'=>"modal",
                                                            'data-target'=>"#formparent",
                                                            'data-title'=> $model->CUST_KTG_PARENT,
                                                            ]).'</li>';

                                                            },

                                              ],

                                         ],

                               ],

           'panel'=>[

                'type' =>GridView::TYPE_SUCCESS,
                'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create Parent ',
                        ['modelClass' => 'Kategoricus',]),'/master/customers/createparent',[
                                                            'data-toggle'=>"modal",
                                                            'data-target'=>"#formparent",
                                                            'class' => 'btn btn-success'
                                                            ])
                    ],

            'pjax'=>true,
            'pjaxSettings'=>[
                'options'=>[
                    'enablePushState'=>false,
                    'id'=>'gv-kat',
                ],
            ],
            'hover'=>true,
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



// grid customers

 $tabcustomers = \kartik\grid\GridView::widget([
  'id'=>'gv-cus',
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel ,
   'columns'=>[
       ['class'=>'kartik\grid\SerialColumn'],

            'CUST_KD',
             [
                'class'=>'kartik\grid\EditableColumn',
                'attribute' => 'CUST_KD_ALIAS'
            ],

            'CUST_NM',
             [
                'label'=>'Customer Kategori',
                'attribute' =>'cus.CUST_KTG_NM',

            ],


            'TLP1',
             'JOIN_DATE',
             'EMAIL',
            [
                'format' => 'raw',
                'label'=> 'Status Customers',
                'value' => function ($model) {
                    if ($model->STATUS == 1) {
                        return '<i class="fa fa-check fa-lg ya" style="color:blue;" title="Aktif">aktif</i>';
                    } else if ($model->STATUS == 0) {
                        return '<i class="fa fa-times fa-lg no" style="color:red;" title="Tidak Aktif" >Tidak Aktif</i>';
                    }
                },
            ],


[ 'class' => 'kartik\grid\ActionColumn',
            'template' => '{view}{update}{delete}{edit}{alias}',
                'header'=>'Action',
                'dropdown' => true,
                'dropdownOptions'=>['class'=>'pull-right dropup'],
                  'buttons' => [
                        'view' =>function($url, $model, $key){
                                return'<li>'.  Html::a('<span class="glyphicon glyphicon-eye-open"></span> '.Yii::t('app', 'View'),
                                                            ['viewcust','id'=>$model->CUST_KD],[
                                                                // 'data-toggle'=>"modal",
                                                                // 'data-target'=>"#view3",
                                                              'data-title'=> $model->CUST_KD,
                                                              ]).'</li>';
                                                           },
                             'update' =>function($url, $model, $key){
                                    return '<li>'. Html::a('<span class="glyphicon glyphicon-user"></span>'.Yii::t('app', 'Update'),
                                                                ['updatecus','id'=>$model->CUST_KD],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#createcus",
                                                                'data-title'=> $model->CUST_KD,
                                                                ]).'</li>';
                                                             },


                              'delete' =>function($url, $model, $key){
                                    return '<li>'. Html::a('<i class="glyphicon glyphicon-trash"></i>'.Yii::t('app', 'Delete'),
                                                                ['deletecus','id'=>$model->CUST_KD],[
                                                                // 'data-toggle'=>"modal",
                                                                // 'data-target'=>"#form",
                                                                // 'data-title'=> $model->CUST_KD,
                                                                ]).'</li>';
                            },
							               'edit' =>function($url, $model,$key){
                                    return '<li>'. Html::a('<i class="glyphicon glyphicon-globe"></i>'.Yii::t('app', 'Create Map'),
                                                            ['create-map','id'=>$model->CUST_KD],
                                                             [ 'class'=>'btn btn-default',
															                                ]).'</li>';

                                                           },
                           'alias' =>function($url, $model, $key){
                                     return  '<li>'. Html::a('<span class="glyphicon glyphicon-pencil"></span>'.Yii::t('app', 'Create alias'),['create-alias-customers','id'=>$model->CUST_KD],[
                                                              'data-toggle'=>"modal",
                                                              'data-target'=>"#formalias",
                                                              'data-title'=> $model->CUST_KD,
                                                                 ]).'</li>';

                                                           },

                                                     ],

                                                ],

                                    ],



   'panel'=>[

  'type' =>GridView::TYPE_SUCCESS,

	 'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create  ',
                        ['modelClass' => 'Customers',]),'/master/customers/createcustomers',[
                                                            'data-toggle'=>"modal",
															                               'id'=>'modcus',
                                                             'data-target'=>"#createcus",
                                                             'class' => 'btn btn-success'
                                                            ])

        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'gv-cus',

        ],
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

    ],

    ]);




	/*Display MAP*/

          $map = '<div id ="map" style="width:100%;height:400px"></div>';

/*All Tab*/
    $items=[
		[
			'label'=>'<i class="glyphicon glyphicon-user"></i> New Customers ','content'=> $tabcustomers, //   $tabcustomers,


		],

		[
			'label'=>'<i class="glyphicon glyphicon-map-marker"></i> MAP','content'=> $map, //$tab_profile,
             'active'=>true,
		],
        [
			'label'=>'<i class="glyphicon glyphicon-folder-open"></i> DATA',//'content'=>$tabparent,//$tab_profile,
		],
			[
			'label'=>'<i class="glyphicon glyphicon-user"></i> Kategori Customers','content'=>$tabcrud,


		],

			[
			'label'=>'<i class="glyphicon glyphicon-globe"></i> Province ','content'=> $tabprovince//$tab_profile,
		],
				[
			'label'=>'<i class="glyphicon glyphicon-globe"></i> KOTA',
            'content'=>$tabkota,//$tab_profile,

		],
    ];



	echo TabsX::widget([
		'id'=>'tab1',
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		//'height'=>'tab-height-xs',
		'bordered'=>true,
		'encodeLabels'=>false,
		//'align'=>TabsX::ALIGN_LEFT,

	]);

	?>



			<?php

// create and update via modal province

$this->registerJs("
     $.fn.modal.Constructor.prototype.enforceFocus = function(){};
        $('#form3').on('show.bs.modal', function (event) {
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
            'id' => 'form3',
            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                ]);
    Modal::end();


/*view via modal province */
$this->registerJs("

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
                'header' => '<h4 class="modal-title">LukisonGroup</h4>',
            ]);
Modal::end();



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

// alias
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


// create kota and update via modal
$this->registerJs("
    $.fn.modal.Constructor.prototype.enforceFocus = function(){};
        $('#form2').on('show.bs.modal', function (event) {
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
         'id' => 'form2',
         'header' => '<h4 class="modal-title">LukisonGroup</h4>',
             ]);
Modal::end();

// view kota via modal
$this->registerJs("
         $('#view2').on('show.bs.modal', function (event) {
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
                'id' => 'view2',
                'header' => '<h4 class="modal-title">LukisonGroup</h4>',
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
		'header' => '<h4 class="modal-title">New Customer</h4>',
	]);
	Modal::end();


/*js mapping */

$this->registerJs("
/*nampilin MAP*/
 var map = new google.maps.Map(document.getElementById('map'),
      {
        zoom: 12,
        center: new google.maps.LatLng(-6.229191531958687,106.65994325550469),
        mapTypeId: google.maps.MapTypeId.ROADMAP

    });

    var public_markers = [];
    var infowindow = new google.maps.InfoWindow();

/*data json*/
 $.getJSON('/master/customers/map', function(json) {

    for (var i in public_markers)
    {
        public_markers[i].setMap(null);
    }

    $.each(json, function (i, point) {
        // alert(point.MAP_LAT);

//set the icon
//     if(point.CUST_NM == 'asep')
//         {
//             icon = 'http://labs.google.com/ridefinder/images/mm_20_red.png';
//         }

            var marker = new google.maps.Marker({
            // icon: icon,
            position: new google.maps.LatLng(point.MAP_LAT, point.MAP_LNG),
            animation:google.maps.Animation.BOUNCE,
            map: map,
             icon : 'http://labs.google.com/ridefinder/images/mm_20_red.png'
        });

         public_markers[i] = marker;

         google.maps.event.addListener(public_markers[i], 'mouseover', function () {
             infowindow.setContent('<h1>' + point.ALAMAT + '</h1>' + '<p>' + point.CUST_NM + '</p>');
             infowindow.open(map, public_markers[i]);
         });


    });


 });

    // console.trace();

     ",$this::POS_READY);
