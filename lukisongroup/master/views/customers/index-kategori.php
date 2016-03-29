<?php
use yii\helpers\Url;
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Kategoricus;


function tombolSetting(){
  $title1 = Yii::t('app', 'Customers');
  $options1 = [ 'id'=>'setting',
          //'data-toggle'=>"modal",
          'data-target'=>"#profile-setting",
          //'class' => 'btn btn-default',
          'style' => 'text-align:left',
  ];
  $icon1 = '<span class="fa fa-cogs fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/index']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * New|Change|Reset| Password Login
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolPasswordUtama(){
  $title1 = Yii::t('app', 'Kota');
  $options1 = [ 'id'=>'password',
          'data-toggle'=>"modal",
          'data-target'=>"#profile-password",
          //'class' => 'btn btn-default',
         // 'style' => 'text-align:left',
  ];
  $icon1 = '<span class="fa fa-shield fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/sistem/user-profile/password-utama-view']);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * Create Signature
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolSignature(){
  $title1 = Yii::t('app', 'Province');
  $options1 = [ 'id'=>'signature',
          //'data-toggle'=>"modal",
          'data-target'=>"#profile-signature",
          //'class' => 'btn btn-default',
  ];
  $icon1 = '<span class="fa fa-pencil-square-o fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/sistem/user-profile/signature']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * Persinalia Employee
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolPersonalia(){
  $title1 = Yii::t('app', 'Kategori Customers');
  $options1 = [ 'id'=>'personalia',
          //'data-toggle'=>"modal",
          'data-target'=>"#profile-personalia",
          'class' => 'btn btn-primary',
  ];
  $icon1 = '<span class="fa fa-group fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/sistem/personalia']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * Performance Employee
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolPerformance(){
  $title1 = Yii::t('app', 'Map');
  $options1 = [ 'id'=>'performance',
          //'data-toggle'=>"modal",
          'data-target'=>"#profile-performance",
          // 'class' => 'btn btn-danger',
  ];
  $icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/sistem/performance']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}
/**
   * Logoff
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolLogoff(){
  $title1 = Yii::t('app', 'Logout');
  $options1 = [ 'id'=>'logout',
          //'data-toggle'=>"modal",
          'data-target'=>"#profile-logout",
          //'class' => 'btn btn-default',
  ];
  $icon1 = '<span class="fa fa-power-off fa-lg"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/sistem/user-profile/logoff']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

?>




<div class="col-sm-8 col-md-8 col-lg-8" >
  <div  class="row" style="margin-left:5px;">
      <!-- IJIN !-->
      <?php
        echo Yii::$app->controller->renderPartial('button',[
            //'model_CustPrn'=>$model_CustPrn,
            //'count_CustPrn'=>$count_CustPrn
        ]);
      ?>
      <!-- CUTI !-->
      <div class="btn-group pull-left">
        <button type="button" class="btn btn-info">MENU</button>
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
          <ul class="dropdown-menu" role="menu">
          <li><?php echo tombolSetting(); ?></li>
          <li><?php echo tombolPasswordUtama();?></li>
          <li><?php echo tombolSignature(); ?></li>
          <li><?php //echo tombolPersonalia(); ?></li>
          <li><?php echo tombolPerformance(); ?></li>
          <li class="divider"></li>
            <!-- <ul>as</ul> -->
          <!-- <li> tombolLogoff();?></li> -->
          </ul>
      </div>
      <!-- CUTI !-->
      <div class="btn-group pull-left">
        <button type="button" class="btn btn-info">KEHADIRAN</button>
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
          <ul class="dropdown-menu" role="menu">
          <li><?php  tombolSetting(); ?></li>
          <li><?php echo tombolPasswordUtama();?></li>
          <li><?php echo tombolSignature(); ?></li>
          <li><?php //echo tombolPersonalia(); ?></li>
          <!-- <li> echo tombolPerformance(); ?></li> -->
          <li class="divider"></li>
          <li><?php echo tombolLogoff();?></li>
          </ul>
      </div>
  </div>
</div>

<div class="row">
<div class="col-sm-12">
  <?php

echo $tabcrud = \kartik\grid\GridView::widget([
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


    ?>
      </div>
    </div>
