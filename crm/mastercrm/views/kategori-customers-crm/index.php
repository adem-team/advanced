<?php
use yii\helpers\Url;
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Kategoricus;
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

?>





<div class="row">
<div class="col-sm-12">
  <?php

 $kategori = \kartik\grid\GridView::widget([
    'id'=>'gv-kat-crm',
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
                 'filter'=>ArrayHelper::map(Kategoricus::find()->where('CUST_KTG_PARENT = CUST_KTG')
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
		  'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
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
                        ['modelClass' => 'Kategoricus',]),'/mastercrm/kategori-customers-crm/createparent',[
                                                            'data-toggle'=>"modal",
                                                            'data-target'=>"#formparent",
                                                            'class' => 'btn btn-success'
                                                            ])
                    ],

            'pjax'=>true,
            'pjaxSettings'=>[
                'options'=>[
                    'enablePushState'=>false,
                    'id'=>'gv-kat-crm',
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


    ?>
      </div>
    </div>

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
        echo $kategori;
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
