<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use yii\widgets\DetailView;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $model lukisongroup\sistem\models\Absensi */
/* @var $form yii\widgets\ActiveForm */
?>


<?php
 // echo $gv= GridView::widget([
 //    'id'=>'gv-modul',
 //    'dataProvider' => $dataProviderEvent,
 //    'filterModel' => $searchModelEvent,
 //  	'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.3); align:center'],
 //
 //    'columns' => [
 //      [	//COL-2
 //        /* Attribute Serial No */
 //        'class'=>'kartik\grid\SerialColumn',
 //        'width'=>'10px',
 //        'header'=>'No.',
 //        'hAlign'=>'center',
 //        'headerOptions'=>[
 //          'style'=>[
 //            'text-align'=>'center',
 //            'width'=>'10px',
 //            'font-family'=>'tahoma',
 //            'font-size'=>'8pt',
 //            'background-color'=>'rgba(0, 95, 218, 0.3)',
 //          ]
 //        ],
 //        'contentOptions'=>[
 //          'style'=>[
 //            'text-align'=>'center',
 //            'width'=>'10px',
 //            'font-family'=>'tahoma',
 //            'font-size'=>'8pt',
 //          ]
 //        ],
 //        'pageSummaryOptions' => [
 //          'style'=>[
 //              'border-right'=>'0px',
 //          ]
 //        ]
 //      ],
 //      [  	//col-1
 //        //username
 //        'attribute' => 'MODUL_NM',
 //        'label'=>'Nama Modul',
 //        'hAlign'=>'left',
 //        'vAlign'=>'middle',
 //        'headerOptions'=>[
 //          'style'=>[
 //            'text-align'=>'center',
 //            'width'=>'200px',
 //            'font-family'=>'tahoma, arial, sans-serif',
 //            'font-size'=>'9pt',
 //            'background-color'=>'rgba(97, 211, 96, 0.3)',
 //          ]
 //        ],
 //        'contentOptions'=>[
 //          'style'=>[
 //            'text-align'=>'left',
 //            'width'=>'200px',
 //            'font-family'=>'tahoma, arial, sans-serif',
 //            'font-size'=>'9pt',
 //          ]
 //        ],
 //      ],
 //
 //    ],
 //    'pjax'=>true,
 //    'pjaxSettings'=>[
 //    'options'=>[
 //      'enablePushState'=>false,
 //      'id'=>'gv-modul',
 //       ],
 //    ],
 //    'panel' => [
 //          'heading'=>'<h3 class="panel-title">User List</h3>',
 //          'type'=>'warning',
 //          'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add User',
 //              ['modelClass' => 'Kategori',]),'/sistem/modul-permission/create',[
 //                'data-toggle'=>"modal",
 //                  'data-target'=>"#modal-create",
 //                    'class' => 'btn btn-success'
 //                          ]),
 //          'showFooter'=>false,
 //    ],
 //    'toolbar'=> [
 //      //'{items}',
 //    ],
 //    'hover'=>true, //cursor select
 //    'responsive'=>true,
 //    'responsiveWrap'=>true,
 //    'bordered'=>true,
 //    'striped'=>'4px',
 //    'autoXlFormat'=>true,
 //    'export' => false,
 //  ]);
 // echo $model->MODUL_ID;

	//echo "test";
	// echo DetailView::widget([
	// 	'id'=>'tes',
  //       'model' => $model,
  //       'attributes' => [
  //           'MODUL_NM',
	// 					'MODUL_NM',
  //           // 'TerminalID',
  //           // 'UserID',
  //           // 'FunctionKey',
  //           // 'Edited',
  //           // 'UserName',
  //           // 'FlagAbsence',
  //           // 'DateTime',
  //           // 'tgl',
  //           // 'waktu',
  //       ],
  //   ]);
?>
