<?php
/* extensions */
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use yii\widgets\Pjax;


?>


<?php
/*
 * GRID BERITA ACARA
 * @author ptrnov  [piter@lukison.com]
 * @since 1.2
*/
$actionClass='btn btn-info btn-xs';
$attDinamik =[];
/*GRIDVIEW ARRAY FIELD HEAD*/
$headColomnBT=[
  ['ID' =>0, 'ATTR' =>['FIELD'=>'KD_BERITA','SIZE' => '40px','label'=>'KD_BERITA','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>1, 'ATTR' =>['FIELD'=>'JUDUL','SIZE' => '100px','label'=>'SUBJECT','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>2, 'ATTR' =>['FIELD'=>'KD_CORP','SIZE' => '10px','label'=>'CORP','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>3, 'ATTR' =>['FIELD'=>'KD_DEP','SIZE' => '10px','label'=>'DEPT','align'=>'left','warna'=>'97, 211, 96, 0.3']],
];
$gvHeadColomnBT = ArrayHelper::map($headColomnBT, 'ID', 'ATTR');

/*GRIDVIEW ARRAY ACTION*/
$attDinamik[]=[
  'class'=>'kartik\grid\ActionColumn',
  'dropdown' => true,
  'template' => '{view}',
  'dropdownOptions'=>['class'=>'pull-left dropdown','style'=>['disable'=>true]],
  'dropdownButton'=>[
    'class' => $actionClass,
    //'caret'=>'<span class="caret"></span>',
  ],
  'buttons' => [
    'view' =>function($url, $model, $key){
        return  '<li>' .Html::a('<span class="fa fa-random fa-dm"></span>'.Yii::t('app', 'view'),
                      ['/widget/berita/detail-berita','KD_BERITA'=>$model->KD_BERITA],[
                      'id'=>'berita-acara-view-id',
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
/*GRIDVIEW ARRAY ROWS*/
foreach($gvHeadColomnBT as $key =>$value[]){
  $attDinamik[]=[
    'attribute'=>$value[$key]['FIELD'],
    'label'=>$value[$key]['label'],
    'filter'=>true,
    'hAlign'=>'right',
    'vAlign'=>'middle',
    //'mergeHeader'=>true,
    'noWrap'=>true,
    'headerOptions'=>[
        'style'=>[
        'text-align'=>'center',
        'width'=>$value[$key]['FIELD'],
        'font-family'=>'tahoma, arial, sans-serif',
        'font-size'=>'8pt',
        //'background-color'=>'rgba(97, 211, 96, 0.3)',
        'background-color'=>'rgba('.$value[$key]['warna'].')',
      ]
    ],
    'contentOptions'=>[
      'style'=>[
        'text-align'=>$value[$key]['align'],
        'font-family'=>'tahoma, arial, sans-serif',
        'font-size'=>'8pt',
      ]
    ],
          'width'=>'12px',
  ];
};

/*SHOW GRID VIEW LIST*/
echo GridView::widget([
  'id'=>'berita-acara-id-outbox',
  'dataProvider' => $dataProviderOutbox,
  'filterModel' => $searchModelOutbox,
  'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
  'columns' => $attDinamik,
  'pjax'=>true,
  'pjaxSettings'=>[
    'options'=>[
      'enablePushState'=>false,
      'id'=>'berita-acara-id-outbox',
    ],
  ],
  'panel' => [
        'heading'=>'<h3 class="panel-title">LIST BERITA ACARA </h3>',
        'type'=>'warning',
        'showFooter'=>false,
  ],
  'panel' => [
        'heading'=>'<h3 class="panel-title">LIST BERITA ACARA </h3>',
        'type'=>'warning',
        'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add ',
            ['modelClass' => 'Kategori',]),'/widget/berita/create',[
              'data-toggle'=>"modal",
                'data-target'=>"#modal-create",
                  'class' => 'btn btn-success btn-xs'
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
  'striped'=>true,
]);
 ?>


 <?php
 /*
  * JS CREATED
  * @author wawan
  * @since 1.0
 */
 $this->registerJs("
 		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
 		$('#modal-create').on('show.bs.modal', function (event) {
 			var button = $(event.relatedTarget)
 			var modal = $(this)
 			var title = button.data('title')
 			var href = button.attr('href')
 			modal.find('.modal-title').html(title)
 			modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
 			$.post(href)
 				.done(function( data ) {
 					modal.find('.modal-body').html(data)
 				});
 			}),
 ",$this::POS_READY);
 Modal::begin([
 		'id' => 'modal-create',
 		//'header' => '<h4 class="modal-title">Signature Authorize</h4>',
 		'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Berita Acara</b></h4></div>',
 		//'size' => 'modal-xs'
 	// 	'size' => Modal::SIZE_SMALL,
 		'headerOptions'=>[
 			'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
 		]
 	]);
 Modal::end();

 ?>
