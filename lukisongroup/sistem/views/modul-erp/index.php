<?php

use yii\helpers\Html;
use lukisongroup\sistem\models\Modulerp;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

$this->sideCorp = 'PT.Lukisongroup';                        /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'admin';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ERP Modul - Administrator');  /* title pada header page */
?>


<?php
/*
 * GRIDVIEW modul permission
 * @author wawan
   * @since 1.1
   */
echo $gvmdlpermission= GridView::widget([
    'id'=>'gv-perimisson-id',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
  	'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.3); align:center'],
    'columns' => [
      [	//COL-2
        /* Attribute Serial No */
        'class'=>'kartik\grid\SerialColumn',
        'width'=>'10px',
        'header'=>'No.',
        'hAlign'=>'center',
        'headerOptions'=>[
          'style'=>[
            'text-align'=>'center',
            'width'=>'10px',
            'font-family'=>'tahoma',
            'font-size'=>'8pt',
            'background-color'=>'rgba(0, 95, 218, 0.3)',
          ]
        ],
        'contentOptions'=>[
          'style'=>[
            'text-align'=>'center',
            'width'=>'10px',
            'font-family'=>'tahoma',
            'font-size'=>'8pt',
          ]
        ],
        'pageSummaryOptions' => [
          'style'=>[
              'border-right'=>'0px',
          ]
        ]
      ],
      [  	//col-1
        //MODUL_ID
        'attribute' => 'MODUL_ID',
        'label'=>'MODUL_ID',
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
      [  	//col-2
        //MODUL_NM
        'attribute' => 'MODUL_NM',
        'label'=>'Nama Modul',
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
      [  	//col-4
        //MODUL_DCRP
        'attribute' => 'MODUL_DCRP',
        'label'=>'Description',
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
      [	//col-5
        //STATUS
        'attribute' => 'MODUL_STS',
        // 'filter' => $valStt,
        'format' => 'raw',
        'hAlign'=>'center',
        'value'=>function($model){
           if ($model->MODUL_STS == 1) {
            return Html::a('<i class="fa fa-check"></i> &nbsp;Enable', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
          } else if ($model->MODUL_STS == 0) {
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
        'template' => '{edit}',
        'dropdownOptions'=>['class'=>'pull-right dropup'],
        'buttons' => [
            'edit' =>function($url, $model, $key){
                return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Change Password'),
                              ['/sistem/modul-permission/update-pass','id'=>$model->MODUL_ID],[
                              'data-toggle'=>"modal",
                              'data-target'=>"#modal-create",
                              'data-title'=>'',// $model->KD_BARANG,
                              ]). '</li>' . PHP_EOL;
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
    ],
    'pjax'=>true,
    'pjaxSettings'=>[
    'options'=>[
      'enablePushState'=>false,
      'id'=>'gv-custgrp-id',
       ],
    ],
    'panel' => [
          'heading'=>'<h3 class="panel-title">Modul List</h3>',
          'type'=>'warning',
          'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Modul',
              ['modelClass' => 'Kategori',]),'/sistem/modul-erp/create',[
                'data-toggle'=>"modal",
                  'data-target'=>"#modal-create",
                    'class' => 'btn btn-success'
                          ]),
          'showFooter'=>false,
    ],
    'toolbar'=> [
      //'{items}',
    ],
    'hover'=>true, //cursor select
    'responsive'=>true,
    'responsiveWrap'=>true,
    'bordered'=>true,
    'striped'=>'4px',
    'autoXlFormat'=>true,
    'export' => false,
  ]);

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
    'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Modul</h4></div>',
    'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
    ],
    ]);
    Modal::end();

  ?>
