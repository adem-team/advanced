
<?php

use yii\helpers\Url;
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\nav\NavX;
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
				'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
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
						'id'=>'gv-kota',
			],
		],
		'summary'=>false,
		//'toolbar'=>false,
        'hover'=>true, //cursor select
        'responsive'=>true,
        'responsiveWrap'=>true,
        'bordered'=>true,
        'striped'=>'4px',
        'autoXlFormat'=>true,
        /* 'export'=>[//export like view grid --ptr.nov-
            'fontAwesome'=>true,
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK
        ], */

    


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
				echo $navmenu;
		  ?>
		  <!-- CUTI !-->
		</div>
		<div class="col-sm-12">
			<?php
				echo $tabkota;
			?>
		</div>
	</div>
</div>

<?php
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
