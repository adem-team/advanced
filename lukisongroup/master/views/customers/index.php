
<?php
use yii\helpers\Url;
use kartik\helpers\Html;
use kartik\grid\GridView;


function tombolCustomers(){
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
function tombolKota(){
  $title1 = Yii::t('app', 'Kota');
  $options1 = [ 'id'=>'password',
          // 'data-toggle'=>"modal",
          'data-target'=>"#profile-passwrd",
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
          'data-target'=>"#profile-signature",
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
          'data-target'=>"#profile-personalia",
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
          'data-target'=>"#profile-performance",
          // 'class' => 'btn btn-danger',
  ];
  $icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-map']);//,'kd'=>$kd]);
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

        //  Yii::$app->controller->renderPartial('button',[
            //'model_CustPrn'=>$model_CustPrn,
            //'count_CustPrn'=>$count_CustPrn
        // ]);

      ?>
      <!-- CUTI !-->
      <div class="btn-group pull-left">
        <button type="button" class="btn btn-info">MENU</button>
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
          <ul class="dropdown-menu" role="menu">
          <li><?php echo tombolCustomers(); ?></li>
          <li><?php echo tombolKota();?></li>
          <li><?php echo tombolProvince(); ?></li>
          <li><?php echo tombolKategori(); ?></li>
          <li><?php echo tombolMap(); ?></li>
          <li class="divider"></li>
            <!-- <ul>as</ul> -->
          <!-- <li> tombolLogoff();?></li> -->
          </ul>
      </div>
      <!-- CUTI !-->

  </div>
</div>

<div class="row">
<div class="col-sm-12">
<?php
/*CUSTOMER DATA*/
echo $tabcustomersData = \kartik\grid\GridView::widget([
  'id'=>'gv-cus-data',
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
  'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.9); align:center'],
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
          'font-size'=>'9pt',
        ]
      ],
    ],
    [
      'attribute' => 'CUST_KD',
      'label'=>'Customer.Id',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'120px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'120px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
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
          'font-size'=>'9pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'250px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
        ]
      ],
    ],
    [
      'attribute' => 'cus.CUST_KTG_NM',
      'filter' => $dropType,
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'150px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'150px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
        ]
      ],
    ],
    [
      'attribute' =>'custype.CUST_KTG_NM',
      'filter' => $dropKtg,
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'200px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'200px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
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
          'width'=>'200px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'200px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
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
          'font-size'=>'9pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'80px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
        ]
      ],
    ],
    [
      'class' => 'kartik\grid\ActionColumn',
      'template' => '{view}{update}{delete}{edit}{alias}{login}',
      'header'=>'Action',
      'dropdown' => true,
      'dropdownOptions'=>['class'=>'pull-right dropup'],
      'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
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
                          ['class'=>'btn btn-default',]).'</li>';

             },
          'alias' =>function($url, $model, $key){
            return  '<li>'. Html::a('<span class="glyphicon glyphicon-pencil"></span>'.Yii::t('app', 'Create alias'),['create-alias-customers','id'=>$model->CUST_KD],[
                            'data-toggle'=>"modal",
                            'data-target'=>"#formalias",
                            'data-title'=> $model->CUST_KD,
                             ]).'</li>';
            },
        'login' =>function($url, $model, $key){
              return  '<li>'. Html::a('<span class="glyphicon glyphicon-pencil"></span>'.Yii::t('app', 'Login'),
                          ['login-alias'],[
                            'data-toggle'=>"modal",
                            'data-target'=>"#formlogin",
                            'data-title'=> $model->CUST_KD,
                          ]).'</li>';
                        },

      ],
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'150px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'150px',
          'height'=>'10px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
        ]
      ],
    ],
  ],
  'panel'=>[
    'type' =>GridView::TYPE_SUCCESS,
  ],
  'pjax'=>true,
  'pjaxSettings'=>[
    'options'=>[
      'enablePushState'=>false,
      'id'=>'gv-cus-data',
    ],
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
  ]);



 ?>

</div>

</div>
