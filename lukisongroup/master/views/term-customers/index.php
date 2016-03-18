<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use lukisongroup\master\models\Termcustomers;
use lukisongroup\hrd\models\Corp;
use lukisongroup\master\models\Distributor;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\TermcustomersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_customers';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


function getPermissionEmp(){
  if (Yii::$app->getUserOpt->profile_user()){
    return Yii::$app->getUserOpt->profile_user()->emp;
  }else{
    return false;
  }
}
function getPermission(){
  if (Yii::$app->getUserOpt->Modul_akses('3')){
    return Yii::$app->getUserOpt->Modul_akses('3');
  }else{
    return false;
  }
}

function tombolCreate(){
  if(getPermission() && getPermission()->BTN_CREATE==1)
  {
    if(getPermission()->BTN_CREATE==1 && getPermissionEmp()->DEP_ID == 'ACT'){
      $title1 = Yii::t('app', 'Add Term');
      $options1 = [ 'id'=>'po-create',
              'data-toggle'=>"modal",
              'data-target'=>"#modal-create",
              'class' => 'btn btn-success',
      ];
      $icon1 = '<span class="fa fa-plus fa-lg"></span>';
      $url = Url::toRoute(['/master/term-customers/create-act']);
      $label1 = $icon1 .'' . $title1;
      $content = Html::a($label1,$url,$options1);
      return $content;
     }else{
      $title1 = Yii::t('app', 'Add Term');
      $options1 = [ 'id'=>'po-create',
      'data-toggle'=>"modal",
      'data-target'=>"#modal-create",
      'class' => 'btn btn-success',
      ];
      $icon1 = '<span class="fa fa-plus fa-lg"></span>';
      $label1 = $icon1 . ' ' . $title1;
      $url = Url::toRoute(['/master/term-customers/create']);
      $content = Html::a($label1,$url, $options1);
      return $content;
    };
  }else{
    $title1 = Yii::t('app', 'Add Term ');
    $options1 = [ 'id'=>'action-denied-id',
            'data-toggle'=>"modal",
            'data-target'=>"#confirm-permission-alert",
              'class' => 'btn btn-success',
    ];
    $icon1 = '<span class="fa fa-plus fa-lg"></span>';
    $label1 = $icon1 . ' ' . $title1;
    $content = Html::a($label1,'',$options1);
    return $content;
  }

}
// return  '<li>' . Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
//               ['/master/term-customers/view-term-cus','id'=>$model->ID_TERM],[
//               // 'data-toggle'=>"modal",
//               // 'data-target'=>"#modal-create",
//               'data-title'=> $model->ID_TERM,
//               ]). '</li>' . PHP_EOL;
function tombolview($url,$model)
{
  if( getPermissionEmp()->DEP_ID == 'ACT')
  {
    $title1 = Yii::t('app', 'view');
    $options1 = [ 'id'=>'term-view',
    ];
    $icon1 = '<span class="fa fa-plus fa-lg"></span>';
    $label = $icon1 . ' ' . $title1;
    $url = Url::toRoute(['/master/term-customers/view-act','id'=>$model->ID_TERM]);
    $options1['tabindex'] = '-1';
    return '<li>' . Html::a($label, $url, $options1) . '</li>' . PHP_EOL;
  }
  elseif (getPermissionEmp()->DEP_ID == 'GM'|| getPermissionEmp()->DEP_ID == 'DRC') {
    # code...
    $title1 = Yii::t('app', 'view');
    $options1 = [ 'id'=>'term-view',
    ];
    $icon1 = '<span class="fa fa-plus fa-lg"></span>';
    $label = $icon1 . ' ' . $title1;
    $url = Url::toRoute(['/master/term-customers/view-drc','id'=>$model->ID_TERM]);
    $options1['tabindex'] = '-1';
    return '<li>' . Html::a($label, $url, $options1) . '</li>' . PHP_EOL;
  }
  elseif(getPermission()->BTN_VIEW==1){
    $title1 = Yii::t('app', 'view');
    $options1 = [ 'id'=>'term-view',
    ];
    $icon1 = '<span class="fa fa-plus fa-lg"></span>';
    $label = $icon1 . ' ' . $title1;
    $url = Url::toRoute(['/master/term-customers/view-term-cus','id'=>$model->ID_TERM]);
    $options1['tabindex'] = '-1';
    return '<li>' . Html::a($label, $url, $options1) . '</li>' . PHP_EOL;
  }

}

// print_r(getPermissionEmp()->DEP_ID);
// die();

function review($url,$model)
{

  if( getPermissionEmp()->DEP_ID == 'ACT' && getPermission()->BTN_REVIEW==1 && $model->SIG3_NM == "none" || getPermissionEmp()->DEP_ID == 'ACT' && getPermission()->BTN_REVIEW==1 &&  $model->SIG2_NM == "none" || getPermissionEmp()->DEP_ID == 'ACT' && getPermission()->BTN_REVIEW==1 && $model->SIG2_NM == "none"  )
  {
    $title1 = Yii::t('app', 'Review');
    $options1 = [ 'id'=>'term-Review',
    ];
    $icon1 = '<span class="fa fa-plus fa-lg"></span>';
    $label = $icon1 . ' ' . $title1;
    $url = Url::toRoute(['/master/term-customers/review-act','id'=>$model->ID_TERM]);
    $options1['tabindex'] = '-1';
    return '<li>' . Html::a($label, $url, $options1) . '</li>' . PHP_EOL;
  }
  elseif (getPermissionEmp()->DEP_ID == 'GM' && getPermission()->BTN_REVIEW == 1 && $model->SIG3_NM == "none" || getPermissionEmp()->DEP_ID == 'DRC' && getPermission()->BTN_REVIEW==1  && $model->SIG3_NM == "none" ) {
    # code...
    $title1 = Yii::t('app', 'Review');
    $options1 = [ 'id'=>'term-Review',
    ];
    $icon1 = '<span class="fa fa-plus fa-lg"></span>';
    $label = $icon1 . ' ' . $title1;
    $url = Url::toRoute(['/master/term-customers/review-drc','id'=>$model->ID_TERM]);
    $options1['tabindex'] = '-1';
    return '<li>' . Html::a($label, $url, $options1) . '</li>' . PHP_EOL;
  }
  elseif(getPermission()->BTN_REVIEW == 1 && $model->SIG2_NM == "none"  || getPermission()->BTN_REVIEW == 1 && $model->SIG1_NM == "none" || getPermission()->BTN_REVIEW == 1 && $model->SIG3_NM == "none" ){
    $title1 = Yii::t('app', 'Review');
    $options1 = [ 'id'=>'term-Review',
    ];
    $icon1 = '<span class="fa fa-plus fa-lg"></span>';
    $label = $icon1 . ' ' . $title1;
    $url = Url::toRoute(['/master/term-customers/view','id'=>$model->ID_TERM]);
    // $options1['tabindex'] = '-1';
    return '<li>' . Html::a($label, $url, $options1) . '</li>' . PHP_EOL;
  }

}

$gridColumns = [
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
          'background-color'=>'rgba(97, 211, 96, 0.3)',
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
      'attribute' => 'NM_TERM',
      'label'=>'Nama Perjanjian',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'200px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(97, 211, 96, 0.3)',
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
  'attribute'=>'SIG1_NM',
  'label'=>'Created By',
  'hAlign'=>'left',
  'vAlign'=>'middle',
  'value'=>function($model){
    /*
     * max String Disply
     * @author ptrnov <piter@lukison.com>
    */
    if (strlen($model->SIG1_NM) <=16){
      return substr($model->SIG1_NM, 0, 16);
    }else{
      return substr($model->SIG1_NM, 0, 14). '..';
    }
  },
  'headerOptions'=>[
    'style'=>[
      'text-align'=>'center',
      'width'=>'125px',
      'font-family'=>'verdana, arial, sans-serif',
      'font-size'=>'9pt',
      'background-color'=>'rgba(97, 211, 96, 0.3)',
    ]
  ],
  'contentOptions'=>[
    'style'=>[
      'text-align'=>'left',
      'width'=>'125px',
      'font-family'=>'tahoma, arial, sans-serif',
      'font-size'=>'9pt'
    ],

  ],
],
[
  'attribute'=>'SIG2_NM',
  'label'=>'Sumbition By',
  'hAlign'=>'left',
  'vAlign'=>'middle',
  'value'=>function($model){
    /*
     * max String Disply
     * @author ptrnov <piter@lukison.com>
    */
    if (strlen($model->SIG2_NM) <=16){
      return substr($model->SIG2_NM, 0, 16);
    }else{
      return substr($model->SIG2_NM, 0, 14). '..';
    }
  },
  'headerOptions'=>[
    'style'=>[
      'text-align'=>'center',
      'width'=>'125px',
      'font-family'=>'verdana, arial, sans-serif',
      'font-size'=>'9pt',
      'background-color'=>'rgba(97, 211, 96, 0.3)',
    ]
  ],
  'contentOptions'=>[
    'style'=>[
      'text-align'=>'left',
      'width'=>'125px',
      'font-family'=>'tahoma, arial, sans-serif',
      'font-size'=>'9pt',
    ]
  ],
],
[
  'attribute'=>'SIG3_NM',
  'label'=>'Approved By',
  'hAlign'=>'left',
  'vAlign'=>'middle',
  'value'=>function($model){
    /*
     * max String Disply
     * @author ptrnov <piter@lukison.com>
    */
    if (strlen($model->SIG3_NM) <=16){
      return substr($model->SIG3_NM, 0, 16);
    }else{
      return substr($model->SIG3_NM, 0, 14). '..';
    }
  },
  'headerOptions'=>[
    'style'=>[
      'text-align'=>'center',
      'width'=>'125px',
      'font-family'=>'verdana, arial, sans-serif',
      'font-size'=>'9pt',
      'background-color'=>'rgba(97, 211, 96, 0.3)',
    ]
  ],
  'contentOptions'=>[
    'style'=>[
      'text-align'=>'left',
      'width'=>'125px',
      'font-family'=>'tahoma, arial, sans-serif',
      'font-size'=>'9pt',
    ]
  ],
],
    [
      'attribute' => 'PERIOD_END',
      'label'=>'Tanggal Berakhir Perjanjian',
      'filterType'=> \kartik\grid\GridView::FILTER_DATE_RANGE,
      // 'filter' => $typeBrg,
      'filterWidgetOptions' =>([
        'attribute' =>'PERIOD_END',
        'presetDropdown'=>TRUE,
        'convertFormat'=>true,
        'pluginOptions'=>[
          'format'=>'Y-m-d',
          'separator' => ' TO ',
          'opens'=>'left'
        ],

      //'pluginEvents' => [
      //	"apply.daterangepicker" => "function() { aplicarDateRangeFilter('EMP_JOIN_DATE') }",
      //]
      ]),
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'150px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(97, 211, 96, 0.3)',
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
      'attribute' => 'PERIOD_START',
      'label'=>'Tanggal awal Perjanjian',
      'filterType'=> \kartik\grid\GridView::FILTER_DATE_RANGE,
      // 'filter' => $kat,
      'filterWidgetOptions' =>([
        'attribute' =>'PERIOD_START',
        'presetDropdown'=>TRUE,
        'convertFormat'=>true,
        'pluginOptions'=>[
          'format'=>'Y-m-d',
          'separator' => ' TO ',
          'opens'=>'left'
        ],

      //'pluginEvents' => [
      //	"apply.daterangepicker" => "function() { aplicarDateRangeFilter('EMP_JOIN_DATE') }",
      //]
      ]),
      // 'filterInputOptions'=>['placeholder'=>'Any author'],
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'150px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(97, 211, 96, 0.3)',
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
      'attribute' => 'STATUS',
      'filter' => $valStt,
      'format' => 'raw',
      'hAlign'=>'center',
      'value'=>function($model){
        if ($model->STATUS==100){
          return Html::a('<i class="glyphicon glyphicon-time"></i> Proccess', '#',['class'=>'btn btn-warning btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
        }elseif ($model->STATUS==101){
          return Html::a('<i class="glyphicon glyphicon-ok"></i> Checked', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
        }elseif ($model->STATUS==102){
          return Html::a('<i class="glyphicon glyphicon-ok"></i> Approved', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
        }else{
          return Html::a('<i class="glyphicon glyphicon-sign"></i> NEW', '#',['class'=>'btn btn-info btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
        };
      },
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'80px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(97, 211, 96, 0.3)',
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
      'class'=>'kartik\grid\ActionColumn',
      'dropdown' => true,
      'template' => '{review}{view}',
      'dropdownOptions'=>['class'=>'pull-right dropup'],
      'buttons' => [
        'review' => function ($url, $model) {
                return review($url, $model);
              },
          'view' =>function($url, $model, $key){
            return  tombolview($url, $model);
              // return  '<li>' . Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
              //               ['/master/term-customers/view-term-cus','id'=>$model->ID_TERM],[
              //               // 'data-toggle'=>"modal",
              //               // 'data-target'=>"#modal-create",
              //               'data-title'=> $model->ID_TERM,
              //               ]). '</li>' . PHP_EOL;
          },

              ],
              'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'150px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(97, 211, 96, 0.3)',
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

      ];
?>


<div class="container-full">
	<div style="padding-left:15px; padding-right:15px">
		<?= $grid = GridView::widget([
				'id'=>'gv-customers',
				'dataProvider'=> $dataProvider,
				'filterModel' => $searchModel,
				'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
				'columns' => $gridColumns,
				'pjax'=>true,
					'pjaxSettings'=>[
						'options'=>[
							'enablePushState'=>false,
							'id'=>'gv-customers',
						],
					 ],
				'toolbar' => [
					'{export}',
          // 'content'=> tombolCreate()

				],
				'panel' => [
					'heading'=>'<h3 class="panel-title">LIST PERJANJIAN</h3>',
					// 'type'=>'warning',
					'before'=>tombolCreate(),
					'showFooter'=>false,
				],

				'export' =>['target' => GridView::TARGET_BLANK],
				'exportConfig' => [
					GridView::PDF => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
					GridView::EXCEL => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
				],
			]);
		?>
	</div>
</div>
<?php
$this->registerJs("
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    $('#confirm-permission-alert').on('show.bs.modal', function (event) {
      //var button = $(event.relatedTarget)
      //var modal = $(this)
      //var title = button.data('title')
      //var href = button.attr('href')
      //modal.find('.modal-title').html(title)
      //modal.find('.modal-body').html('')
      /* $.post(href)
        .done(function( data ) {
          modal.find('.modal-body').html(data)
        }); */
      }),
",$this::POS_READY);
Modal::begin([
    'id' => 'confirm-permission-alert',
    'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/warning/denied.png',  ['class' => 'pnjg', 'style'=>'width:40px;height:40px;']).'</div><div style="margin-top:10px;"><h4><b>Permmission Confirm !</b></h4></div>',
    'size' => Modal::SIZE_SMALL,
    'headerOptions'=>[
      'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
    ]
  ]);
  echo "<div>You do not have permission for this module.
      <dl>
        <dt>Contact : itdept@lukison.com</dt>
      </dl>
    </div>";
Modal::end();

$this->registerJs("
   $.fn.modal.Constructor.prototype.enforceFocus = function(){};
   $('#modal-create').on('show.bs.modal', function (event) {
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
      'id' => 'modal-create',
  'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Perjanjian </h4></div>',
  'headerOptions'=>[
      'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
  ],
  ]);
  Modal::end();
