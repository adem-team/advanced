<?php
/* extensions */
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use yii\widgets\Pjax;

/* namespace models */
use lukisongroup\widget\models\BeritaNotify;



?>


<?php
/*
 * GRID BERITA ACARA
 * @author ptrnov  [piter@lukison.com]
 * @since 1.2
*/

$actionClass='btn btn-info btn-xs';
$actionLabel='Update';
$attDinamik =[];
/*GRIDVIEW ARRAY FIELD HEAD*/
$headColomnBT=[
  ['ID' =>0, 'ATTR' =>['FIELD'=>'KD_BERITA','SIZE' => '10px','label'=>'KD_BERITA','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>1, 'ATTR' =>['FIELD'=>'JUDUL','SIZE' => '10px','label'=>'SUBJECT','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>2, 'ATTR' =>['FIELD'=>'KD_CORP','SIZE' => '10px','label'=>'CORP','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>3, 'ATTR' =>['FIELD'=>'KD_DEP','SIZE' => '10px','label'=>'DEPT','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>4, 'ATTR' =>['FIELD'=>'STATUS','SIZE' => '10px','label'=>'Status Berita','align'=>'left','warna'=>'97, 211, 96, 0.3']],
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
  ],
  'buttons' => [
    'view' =>function($url, $model, $key){
        return  '<li>' .Html::a('<span class="fa fa-random fa-dm"></span>'.Yii::t('app', 'View'),
                      ['/widget/berita/detail-berita','KD_BERITA'=>$model->KD_BERITA],[
                      'id'=>'inbox-berita-id',
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
  if($value[$key]['FIELD'] == 'STATUS')
  {
    $attDinamik[]=[
      'attribute'=>$value[$key]['FIELD'],
      'label'=>$value[$key]['label'],
      'filter'=>true,
      'format' => 'raw',
      'value'=>function($model){
        $id = Yii::$app->user->identity->EMP_ID; // componen
        $notif = BeritaNotify::find()->where(['KD_BERITA'=>$model->KD_BERITA,'ID_USER'=>$id])->one();
         if ($notif->TYPE == 1) {
          return Html::a('<i class="fa fa-check"></i> &nbsp;Unread', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
        } else if ($notif->TYPE == 0) {
          return Html::a('<i class="fa fa-close"></i> &nbsp;Read', '',['class'=>'btn btn-danger btn-xs', 'title'=>'Deactive']);
        }
      },
      'hAlign'=>'right',
      'vAlign'=>'middle',
      'noWrap'=>true,
      'headerOptions'=>[
          'style'=>[
          'text-align'=>'center',
          'width'=>$value[$key]['FIELD'],
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
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
  }else {
    # code...
    $attDinamik[]=[
      'attribute'=>$value[$key]['FIELD'],
      'label'=>$value[$key]['label'],
      'filter'=>true,
      'hAlign'=>'right',
      'vAlign'=>'middle',
      'noWrap'=>true,
      'headerOptions'=>[
          'style'=>[
          'text-align'=>'center',
          'width'=>$value[$key]['FIELD'],
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
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
  }

};

/*SHOW GRID VIEW LIST*/
echo GridView::widget([
  'id'=>'berita-acara-id',
  'dataProvider' => $dataProviderInbox,
  'filterModel' => $searchModelInbox,
  'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
  'columns' => $attDinamik,
  'pjax'=>true,
  'pjaxSettings'=>[
    'options'=>[
      'enablePushState'=>false,
      'id'=>'berita-acara-id',
    ],
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
