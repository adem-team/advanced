<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use lukisongroup\master\models\DraftPlan;
Use ptrnov\salesforce\Jadwal;


?>
<?php
      
/*
 * GRID draft_plan
 * @author wawan  [aditiya@lukison.com]
 * @since 1.2
*/

$actionClass='btn btn-info btn-xs';
$actionLabel='Update';
$attDinamik =[];
/*GRIDVIEW ARRAY FIELD HEAD*/
$headColomn=[
	['ID' =>0, 'ATTR' =>['FIELD'=>'username','SIZE' => '10px','label'=>'User Login','align'=>'left','warna'=>'73, 162, 182, 1','grp'=>false]],
    ['ID' =>1, 'ATTR' =>['FIELD'=>'salesNm','SIZE' => '20px','label'=>'Nama User','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
    ['ID' =>2, 'ATTR' =>['FIELD'=>'salesHp','SIZE' => '20px','label'=>'HP','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
    ['ID' =>3, 'ATTR' =>['FIELD'=>'status','SIZE' => '20px','label'=>'Status','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]], 	
];
$gvHeadColomnBT = ArrayHelper::map($headColomn, 'ID', 'ATTR');


$attDinamik[] =[
  'class'=>'kartik\grid\SerialColumn',
  //'contentOptions'=>['class'=>'kartik-sheet-style'],
  'width'=>'10px',
  'header'=>'No.',
  'headerOptions'=>[
    'style'=>[
      'text-align'=>'center',
      'width'=>'10px',
      'font-family'=>'verdana, arial, sans-serif',
      'font-size'=>'9pt',
      'background-color'=>'rgba(73, 162, 182, 1)',
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
];


/*GRIDVIEW ARRAY ROWS*/
foreach($gvHeadColomnBT as $key =>$value[]){
  if($value[$key]['FIELD'] == 'status')
  {
      # code...
  $attDinamik[]=[
    'attribute'=>$value[$key]['FIELD'],
    'label'=>$value[$key]['label'],
    'filterType'=>GridView::FILTER_SELECT2,
    'filter' => $Stt,
    'filterWidgetOptions'=>[
      'pluginOptions'=>['allowClear'=>true],
    ],
    'filterInputOptions'=>['placeholder'=>'Pilih'],
     'format' => 'raw',
    'value'=>function($model){
           if ($model->status == 10) {
            return Html::a('<i class="fa fa-check"></i> &nbsp;Active', '',['class'=>'btn btn-success btn-xs', 'title'=>'Active']);
          } else if ($model->status == 1) {
            return Html::a('<i class="fa fa-close"></i> &nbsp;Inactive', '',['class'=>'btn btn-danger btn-xs', 'title'=>'Inactive']);
          }
        },
    'hAlign'=>'right',
    'vAlign'=>'middle',
    'noWrap'=>true,
    'headerOptions'=>[
      'style'=>[
        'text-align'=>'center',
        'width'=>$value[$key]['SIZE'],
        'font-family'=>'tahoma, arial, sans-serif',
        'font-size'=>'8pt',
        'background-color'=>'rgba('.$value[$key]['warna'].')',
      ]
    ],
    'contentOptions'=>[
      'style'=>[
        'width'=>$value[$key]['SIZE'],
        'text-align'=>$value[$key]['align'],
        'font-family'=>'tahoma, arial, sans-serif',
        'font-size'=>'8pt',
      ]
    ],
    ];

    }else{
       

     $attDinamik[]=[
        'attribute'=>$value[$key]['FIELD'],
        'label'=>$value[$key]['label'],
        'filter'=>true,
        'hAlign'=>'right',
        'vAlign'=>'middle',
        'noWrap'=>true,
    'group'=>$value[$key]['grp'],
        'headerOptions'=>[
            'style'=>[
            'text-align'=>'center',
            'width'=>$value[$key]['SIZE'],
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
            'background-color'=>'rgba('.$value[$key]['warna'].')',
          ]
        ],
        'contentOptions'=>[
          'style'=>[
            'text-align'=>$value[$key]['align'],
      'width'=>$value[$key]['SIZE'],
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
          ]
        ],
      ];

    }
  };

   /*GRIDVIEW ARRAY ACTION*/
     $attDinamik[]=[
      'class'=>'kartik\grid\ActionColumn',
      'template' => '{edit}',
      'dropdown' => true,
      'dropdownOptions'=>['class'=>'pull-right dropup','style'=>['disable'=>true]],
      'dropdownButton'=>[
        'class' => $actionClass,
      ],
      'buttons' => [
        'edit' =>function($url, $model, $key){
            return  '<li>' .Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Edit'),
                          ['edit-user','id'=>$model->id],[
                            'data-toggle'=>"modal",
                            'data-target'=>"#modal-edit-user",
                          ]). '</li>' . PHP_EOL;
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
$gvGroupUser=GridView::widget([
   'id'=>'gv-group-user-id',
  'dataProvider' => $dataProviderUser,
  'filterModel' => $searchModelUser,
  'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
  'columns' => $attDinamik,
  'pjax'=>true,
  'pjaxSettings'=>[
    'options'=>[
      'enablePushState'=>false,
      'id'=>'gv-group-user-id',
    ],
  ],
  'panel' => [
       'heading'=>false,
        'type'=>'info',
       'before'=> Html::a('<i class="fa fa-tags"></i> '.Yii::t('app', 'Plan User',
                            ['modelClass' => 'DraftPlan',]),'/master/draft-plan/plan-user',[
                                'data-toggle'=>"modal",
                                    'data-target'=>"#modal-group-user",
                                        'class' => 'btn btn-warning'
                                                    ]).' '.
                  Html::a('<i class="fa fa-user-plus"></i> '.Yii::t('app', 'Add User',
                            ['modelClass' => 'DraftPlan',]),'/master/draft-plan/create-user',[
                                'data-toggle'=>"modal",
                                    'data-target'=>"#modal-create-user",
                                        'class' => 'btn btn-success'
                                                    ]),
        'showFooter'=>false,
  ],
  // 'export' =>['target' => GridView::TARGET_BLANK],
  // 'exportConfig' => [
    // GridView::PDF => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
    // GridView::EXCEL => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
  // ],
  'toolbar'=> [
        // '{export}',
    //'{items}',
  ],
  'hover'=>true, //cursor select
  'responsive'=>true,
  'responsiveWrap'=>true,
  'bordered'=>true,
  'striped'=>true,
]);
?>
<?=$gvGroupUser?>

<?php

	$this->registerJs("
         $.fn.modal.Constructor.prototype.enforceFocus = function(){};
         $('#modal-group-user').on('show.bs.modal', function (event) {
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
        'id' => 'modal-group-user',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-tags"></div><div><h4 class="modal-title">USER TO GROUP</h4></div>',
		 'size' => Modal::SIZE_SMALL,	
        'headerOptions'=>[
                'style'=> 'border-radius:5px; background-color: rgba(255, 189, 117, 1)',
        ],
    ]);
    Modal::end();

	$this->registerJs("
         $.fn.modal.Constructor.prototype.enforceFocus = function(){};
         $('#modal-create-user').on('show.bs.modal', function (event) {
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
        'id' => 'modal-create-user',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-search-plus"></div><div><h4 class="modal-title">ADD USER</h4></div>',
		'headerOptions'=>[
                'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
        ],
    ]);
    Modal::end();

    $this->registerJs("
         $.fn.modal.Constructor.prototype.enforceFocus = function(){};
         $('#modal-edit-user').on('show.bs.modal', function (event) {
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
        'id' => 'modal-edit-user',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-search-plus"></div><div><h4 class="modal-title">ADD USER</h4></div>',
    'headerOptions'=>[
                'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
        ],
    ]);
    Modal::end();

?>

