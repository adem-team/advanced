<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use lukisongroup\master\models\Schedulegroup;
use lukisongroup\sistem\models\Mdlpermission;
/*
 * GRIDVIEW modul permission
 * @author wawan
   * @since 1.1
   */
$gvmdlpermission= GridView::widget([
    'id'=>'gv-perimisson-id',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
    'rowOptions'   => function ($model, $key, $index, $grid) {
       return ['id' => $model->id,'onclick' => '$.pjax.reload({
            url: "'.Url::to(['/sistem/modul-permission/index']).'?MdlpermissionSearch[USER_ID]="+this.id,
            container: "#gv-custgrp-list",
            timeout: 10,
        });'];
      //  return ['data-id' => $model->USER_ID];
   },
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
        //username
        'attribute' => 'username',
        'label'=>'Nama user',
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
      [	//col-3
        //STATUS
        'attribute' => 'MODUL_STS',
        // 'filter' => $valStt,
        'format' => 'raw',
        'hAlign'=>'center',
        'value'=>function($model){
           if ($model->status == 10) {
            return Html::a('<i class="fa fa-check"></i> &nbsp;Enable', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
          } else if ($model->status == 1) {
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
        'template' => '{view}{edit}',
        'dropdownOptions'=>['class'=>'pull-right dropup'],
        'buttons' => [
            // 'view' =>function($url, $model, $key){
            //     return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
            //                   ['/master/schedule-group/view','id'=>$model->ID],[
            //                   'data-toggle'=>"modal",
            //                   'data-target'=>"#modal-view",
            //                   'data-title'=> '',//$model->KD_BARANG,
            //                   ]). '</li>' . PHP_EOL;
            // },
            // 'edit' =>function($url, $model, $key){
            //     return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Update'),
            //                   ['/master/schedule-group/update','id'=>$model->ID],[
            //                   'data-toggle'=>"modal",
            //                   'data-target'=>"#modal-create",
            //                   'data-title'=>'',// $model->KD_BARANG,
            //                   ]). '</li>' . PHP_EOL;
            // },
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
          'heading'=>'<h3 class="panel-title">User List</h3>',
          'type'=>'warning',
          'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add User',
              ['modelClass' => 'Kategori',]),'/sistem/modul-permission/create',[
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

/*
 * GRIDVIEW Modul Permission
 * @author wawan
   * @since 1.1
   */
  $gvCustGroupList= GridView::widget([
  'id'=>'gv-custgrp-list',
  'dataProvider' => $dataProviderpermision,
  'filterModel' => $searchModelpermision,
  'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
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
      // MODUL_ID
      'attribute' =>'modul.MODUL_NM',
      'format' => 'html',
      'label'=>'Modul_Name',
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
        'group'=>true,
    ],
    [  	//col-2
      //USER_ID
      'attribute' => 'USER_ID',
      'label'=>'User ID',
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
        'group'=>true,
    ],
    [  	//col-3
      //BTN_CREATE
      'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'BTN_CREATE',
      'label'=>'BTN CREATE',
      'editableOptions' => [
               'header' => 'Update Permission',
               'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
               'size'=>'sm',
               'options' => [
                 ]
             ],
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
      //BTN_EDIT
      'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'BTN_EDIT',
      'label'=>'BTN EDIT',
      'editableOptions' => [
               'header' => 'Update Permission',
               'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
               'size'=>'sm',
               'options' => [
                 ]
             ],
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
    [  	//col-5
      //BTN_DELETE
      'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'BTN_DELETE',
      'label'=>'BTN DELETE',
      'editableOptions' => [
               'header' => 'Update Permission',
               'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
               'size'=>'sm',
               'options' => [
                 ]
             ],
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
    [  	//col-6
      //BTN_view
      'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'BTN_VIEW',
      'label'=>'BTN VIEW',
      'editableOptions' => [
               'header' => 'Update Permission',
               'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
               'size'=>'sm',
               'options' => [
                 ]
             ],
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
    [  	//col-6
      //BTN_REVIEW
      'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'BTN_REVIEW',
      'label'=>'BTN REVIEW',
      'editableOptions' => [
               'header' => 'Update Permission',
               'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
               'size'=>'sm',
               'options' => [
                 ]
             ],
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
    [  	//col-7
      //BTN_PROCESS1
      'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'BTN_PROCESS1',
      'label'=>'BTN PROCESS1',
      'editableOptions' => [
               'header' => 'Update Permission',
               'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
               'size'=>'sm',
               'options' => [
                 ]
             ],
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
    [  	//col-8
      //BTN_PROCESS2
      'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'BTN_PROCESS2',
      'label'=>'BTN PROCESS2',
      'editableOptions' => [
               'header' => 'Update Permission',
               'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
               'size'=>'sm',
               'options' => [
                 ]
             ],
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
    [  	//col-9
      //BTN_PROCESS3
      'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'BTN_PROCESS3',
      'label'=>'BTN PROCESS3',
      'editableOptions' => [
               'header' => 'Update Permission',
               'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
               'size'=>'sm',
               'options' => [
                 ]
             ],
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
    [  	//col-9
      //BTN_PROCESS4
      'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'BTN_PROCESS4',
      'label'=>'BTN PROCESS4',
      'editableOptions' => [
               'header' => 'Update Permission',
               'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
               'size'=>'sm',
               'options' => [
                 ]
             ],
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
    [  	//col-10
      //BTN_PROCESS5
      'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'BTN_PROCESS5',
      'label'=>'BTN PROCESS5',
      'editableOptions' => [
               'header' => 'Update Permission',
               'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
               'size'=>'sm',
               'options' => [
                 ]
             ],
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
    [  	//col-11
      //BTN_SIGN1
      'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'BTN_SIGN1',
      'label'=>'BTN SIGN1',
      'editableOptions' => [
               'header' => 'Update Permission',
               'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
               'size'=>'sm',
               'options' => [
                 ]
             ],
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
    [  	//col-12
      //BTN_SIGN2
      'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'BTN_SIGN2',
      'label'=>'BTN SIGN2',
      'editableOptions' => [
               'header' => 'Update Permission',
               'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
               'size'=>'sm',
               'options' => [
                 ]
             ],
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
    [  	//col-13
      //BTN_SIGN3
      'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'BTN_SIGN3',
      'label'=>'BTN SIGN3',
      'editableOptions' => [
               'header' => 'Update Permission',
               'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
               'size'=>'sm',
               'options' => [
                 ]
             ],
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
    [  	//col-14
      //BTN_SIGN4
      'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'BTN_SIGN4',
      'label'=>'BTN SIGN4',
      'editableOptions' => [
               'header' => 'Update Permission',
               'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
               'size'=>'sm',
               'options' => [
                 ]
             ],
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
    [  	//col-15
      //BTN_SIGN5
      'class'=>'kartik\grid\EditableColumn',
      'attribute' => 'BTN_SIGN5',
      'label'=>'BTN SIGN5',
      'editableOptions' => [
               'header' => 'Update Permission',
               'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
               'size'=>'sm',
               'options' => [
                 ]
             ],
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
    [	//col-16
      //STATUS
      'attribute' => 'STATUS',
      // 'filter' => $valStt,
      'format' => 'raw',
      'hAlign'=>'center',
      'value'=>function($model){
         if ($model->STATUS == 1) {
          return Html::a('<i class="fa fa-check"></i> &nbsp;Enable', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
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
      'template' => '{view}{edit}',
      'dropdownOptions'=>['class'=>'pull-right dropup'],
      'buttons' => [
        //  'view' =>function($url, $model, $key){
        //       return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
        //                     ['/master/schedule-group/view-group','id'=>$model->CUST_KD],[
        //                     'data-toggle'=>"modal",
        //                     'data-target'=>"#modal-view",
        //                     'data-title'=> '',//$model->KD_BARANG,
        //                     ]). '</li>' . PHP_EOL;
          // },
          // 'edit' =>function($url, $model, $key){
          //     return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Update'),
          //                   ['/master/schedule-group/update-group','id'=>$model->CUST_KD],[
          //                   'data-toggle'=>"modal",
          //                   'data-target'=>"#modal-create",
          //                   'data-title'=>'',// $model->KD_BARANG,
          //                   ]). '</li>' . PHP_EOL;
          // },
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
    'id'=>'gv-custgrp-list',
     ],
  ],
  'panel' => [
        'heading'=>'<h3 class="panel-title">LIST CUSTOMER GROUP</h3>',
        'type'=>'warning',
        // 'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Customer ',
        // 		['modelClass' => 'Kategori',]),'/master/barang/create',[
        // 			'data-toggle'=>"modal",
        // 				'data-target'=>"#modal-create",
        // 					'class' => 'btn btn-success'
        // 								]),

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



?>

<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
  <div  class="row" style="margin-top:15px">
    <!-- GROUP LOCALTION !-->
    <div class="col-md-4">
      <?php
        echo $gvmdlpermission;
      ?>
    </div>
    <!-- GROUP CUSTOMER LIST !-->
    <div class="col-md-8">

      <?php
        echo $gvCustGroupList;
      ?>
    </div>
  </div>

  </div>
<?php
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
  	'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">User</h4></div>',
  	'headerOptions'=>[
  			'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
  	],
  	]);
  	Modal::end();

    ?>
