<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;;
use lukisongroup\master\models\Terminvest;
use lukisongroup\master\models\Termgeneral;
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Termcustomers;
use lukisongroup\master\models\Distributor;
use lukisongroup\hrd\models\Corp;
use lukisongroup\hrd\models\Jobgrade;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termcustomers */

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_customers';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;

function pihak($model){
  $title = Yii::t('app','');
  $options = [ 'id'=>'phk',
          'data-toggle'=>"modal",
          'data-target'=>"#pihak",
          'class'=>'btn btn-warning btn-xs',
          //'style'=>['width'=>'150px'],
          'title'=>'Set'
  ];
  $icon = '<span class="glyphicon glyphicon-open"></span>';
  $label = $icon . ' ' . $title;
  $url = Url::toRoute(['/master/term-customers/pihak','id'=>$model->ID_TERM]);
  $content = Html::a($label,$url, $options);
  return $content;
}

function periode($model){
  $title = Yii::t('app','');
  $options = [ 'id'=>'peirod',
          'data-toggle'=>"modal",
          'data-target'=>"#periode",
          'class'=>'btn btn-warning btn-xs',
          //'style'=>['width'=>'150px'],
          'title'=>'Set'
  ];
  $icon = '<span class="glyphicon glyphicon-open"></span>';
  $label = $icon . ' ' . $title;
  $url = Url::toRoute(['/master/term-customers/periode','id'=>$model->ID_TERM]);
  $content = Html::a($label,$url, $options);
  return $content;
}

function TOP($model){
  $title = Yii::t('app','');
  $options = [ 'id'=>'top',
          'data-toggle'=>"modal",
          'data-target'=>"#TOP",
          'class'=>'btn btn-warning btn-xs',
          //'style'=>['width'=>'150px'],
          'title'=>'Set'
  ];
  $icon = '<span class="glyphicon glyphicon-open"></span>';
  $label = $icon . ' ' . $title;
  $url = Url::toRoute(['/master/term-customers/top','id'=>$model->ID_TERM]);
  $content = Html::a($label,$url, $options);
  return $content;
}

function RABATE($model){
  $title = Yii::t('app','');
  $options = [ 'id'=>'rabate',
          'data-toggle'=>"modal",
          'data-target'=>"#RABATE",
          'class'=>'btn btn-warning btn-xs',
          //'style'=>['width'=>'150px'],
          'title'=>'Set'
  ];
  $icon = '<span class="glyphicon glyphicon-open"></span>';
  $label = $icon . ' ' . $title;
  $url = Url::toRoute(['/master/term-customers/rabate','id'=>$model->ID_TERM]);
  $content = Html::a($label,$url, $options);
  return $content;
}

function target($model){
  $title = Yii::t('app','');
  $options = [ 'id'=>'target-id',
          'data-toggle'=>"modal",
          'data-target'=>"#TARGET",
          'class'=>'btn btn-warning btn-xs',
          //'style'=>['width'=>'150px'],
          'title'=>'Set'
  ];
  $icon = '<span class="glyphicon glyphicon-open"></span>';
  $label = $icon . ' ' . $title;
  $url = Url::toRoute(['/master/term-customers/target','id'=>$model->ID_TERM]);
  $content = Html::a($label,$url, $options);
  return $content;
}

function growth($model){
  $title = Yii::t('app','');
  $options = [ 'id'=>'growth',
          'data-toggle'=>"modal",
          'data-target'=>"#Growth",
          'class'=>'btn btn-warning btn-xs',
          //'style'=>['width'=>'150px'],
          'title'=>'Set'
  ];
  $icon = '<span class="glyphicon glyphicon-open"></span>';
  $label = $icon . ' ' . $title;
  $url = Url::toRoute(['/master/term-customers/growth','id'=>$model->ID_TERM]);
  $content = Html::a($label,$url, $options);
  return $content;
}

function ttd($model){
  if($model->CUST_NM == '')
  {
    $title = Yii::t('app','-- -- --');
  }
  else {
    # code...
      $title = Yii::t('app',$model['CUST_NM']);
  }

  $options = [ 'id'=>'tdd-id',
          'data-toggle'=>"modal",
          'data-target'=>"#TTD1",
          'title'=>'Set'
  ];
  $url = Url::toRoute(['/master/term-customers/set-cus','id'=>$model->ID_TERM]);
  $content = Html::a($title,$url, $options);
  return $content;
}

function ttd2($model){
  if($model->DIST_NM == '')
  {
    $title = Yii::t('app','-- -- --');
  }
  else {
    # code...
      $title = Yii::t('app',$model['DIST_NM']);
  }
  $options = [ 'id'=>'tdd-id2',
          'data-toggle'=>"modal",
          'data-target'=>"#TTD2",
          'title'=>'Set'
  ];
  $url = Url::toRoute(['/master/term-customers/set-dist','id'=>$model->ID_TERM]);
  $content = Html::a($title,$url, $options);
  return $content;
}

function ttd3($model){
  if($model->JOBGRADE_ID == '')
  {
    $title = Yii::t('app','-- -- --');
  }
  else {
    # code...
      $title = Yii::t('app',$model['PRINCIPAL_NM']);
  }

  $options = [ 'id'=>'tdd-id3',
          'data-toggle'=>"modal",
          'data-target'=>"#TTD3",
          'title'=>'Set'
  ];
  $url = Url::toRoute(['/master/term-customers/set-internal','id'=>$model->ID_TERM]);
  $content = Html::a($title,$url, $options);
  return $content;
}



// $data = Termcustomers::find()->where(['ID_TERM'=>$_GET['id']])->asArray()
//                                                              ->one();
// $baris = count($data['TARGET_VALUE']);
// if($baris == 0)
// {
//   function PrintPdf($model){
// 		$title = Yii::t('app', 'Print');
// 		$options = [ 'id'=>'confirm-permission-id',
// 					  'data-toggle'=>"modal",
// 					  'data-target'=>"#confirm-permission-alert",
// 					  'class'=>'btn btn-info btn-xs',
// 					  'style'=>['width'=>'100px','text-align'=>'center'],
// 					  'title'=>'Signature'
// 		];
// 		$icon = '<span class="glyphicon glyphicon-retweet" style="text-align:center"></span>';
// 		$label = $icon . ' ' . $title;
// 		$content = Html::button($label, $options);
// 		return $content;
// 	}
//
// }
// else{
  function PrintPdf($model){
      $title = Yii::t('app','Print');
      $options = [ 'id'=>'pdf-print-id',
              'class'=>'btn btn-default btn-xs',
              'title'=>'Print PDF'
      ];
      $icon = '<span class="fa fa-print fa-fw"></span>';
      $label = $icon . ' ' . $title;
      $url = Url::toRoute(['/master/term-customers/cetakpdf','id'=>$model->ID_TERM]);
      $content = Html::a($label,$url, $options);
      return $content;
  }


?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">

  <div  class="row">
	<!-- HEADER !-->
		<div class="col-md-12">
			<div class="col-md-1" style="float:left;">
				<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
			</div>
			<div class="col-md-9" style="padding-top:15px;">
				<h3 class="text-center"><b> <?= $model->NM_TERM ?> <?php echo date('Y')  ?> </b></h3>
			</div>
			<div class="col-md-12">
				<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
			</div>

		</div>

	</div>

  <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;">
      <div>
        <?php echo pihak($model); ?>
      </div>
      <dl>
        <?php
        $data = Customers::find()->where(['CUST_KD'=> $model->CUST_KD])
                                ->asArray()
                                ->one();
        $datadis = Distributor::find()->where(['KD_DISTRIBUTOR'=> $model->DIST_KD])
                                      ->asArray()
                                      ->one();
        $datacorp = Corp::find()->where(['CORP_ID'=> $model->PRINCIPAL_KD])
                                                                    ->asArray()
                                                                    ->one();

         ?>

        <dt><h6><u><b>Pihak :</b></u></h6></dt>

        <dd>:	<?= $data['CUST_NM'] ?></dd>


        <dd>:	<?= $datadis['NM_DISTRIBUTOR']?></dd>


        <dd>:	<?=$datacorp['CORP_NM']?></dd>
      </dl>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;">
      <div>
        <?php echo periode($model); ?>
      </div>
      <dl>

        <dt><h6><u><b>Period/Jangka Waktu :</b></u></h6></dt>
        <dt style="width:80px; float:left;"> Dari: </dt>
        <dd>:	<?=$model->PERIOD_START ?></dd>

        <dt style="width:80px; float:left;">Sampai:</dt>
        <dd>:	<?=$model->PERIOD_END?></dd>

      </dl>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;">
      <div>
        <?php echo TOP($model); ?>
      </div>
      <dl>
        <dt><h6><u><b>Term Of Payment : <?= $model->TOP ?></b></u></h6></dt>
      </dl>
    </div>
  </div>




<?php
$dataids = $_GET['id'];

?>

<?php
  echo  $grid = GridView::widget([
      'id'=>'gv-term-general',
      'dataProvider'=> $dataProvider1,
      'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline;'],
      'columns' =>
        [
           [
             'class'=>'kartik\grid\SerialColumn',
             'contentOptions'=>['class'=>'kartik-sheet-style'],
             'width'=>'10px',
             'header'=>'No.',
             'headerOptions'=>[
               'style'=>[
                 'text-align'=>'center',
                 'width'=>'100px',
                 'font-family'=>'verdana, arial, sans-serif',
                 'font-size'=>'9pt',
                 'background-color'=>'rgba(97, 211, 96, 0.3)',
               ]
             ],
             'contentOptions'=>[
               'style'=>[
                 'text-align'=>'center',
                 'width'=>'100px',
                 'font-family'=>'tahoma, arial, sans-serif',
                 'font-size'=>'9pt',
               ]
             ],
           ],

           [
             'attribute' => 'INVES_TYPE',
             'label'=>'Type Investasi',
             'hAlign'=>'left',
             'vAlign'=>'middle',
             'headerOptions'=>[
               'style'=>[
                 'text-align'=>'center',
                 'font-family'=>'tahoma, arial, sans-serif',
                 'font-size'=>'9pt',
                 'background-color'=>'rgba(97, 211, 96, 0.3)',
               ]
             ],
             'contentOptions'=>[
               'style'=>[
                 'text-align'=>'left',
                 'width'=>'100px',
                 'font-family'=>'tahoma, arial, sans-serif',
                 'font-size'=>'9pt',
               ]
             ],
             'pageSummaryOptions' => [
               'style'=>[
                   'border-left'=>'0px',
                   'border-right'=>'0px',
               ]
             ],
             'pageSummary'=>function ($summary, $data, $widget){
                     return '<div> Total :</div>';
                   },
             'pageSummaryOptions' => [
               'style'=>[
                   'font-family'=>'tahoma',
                   'font-size'=>'8pt',
                   'text-align'=>'center',
                   'border-left'=>'0px',
                   'border-right'=>'0px',
               ]
             ],
           ],
           [
             'attribute' => 'BUDGET_VALUE',
             'label'=>'Value',
             'hAlign'=>'left',
             'vAlign'=>'middle',
             'headerOptions'=>[
               'style'=>[
                 'text-align'=>'center',
                 'width'=>'100px',
                 'font-family'=>'tahoma, arial, sans-serif',
                 'font-size'=>'9pt',
                 'background-color'=>'rgba(97, 211, 96, 0.3)',
               ]
             ],
             'contentOptions'=>[
               'style'=>[
                 'text-align'=>'left',
                 'width'=>'100px',
                 'font-family'=>'tahoma, arial, sans-serif',
                 'font-size'=>'9pt',
               ]
             ],
             	'pageSummaryFunc'=>GridView::F_SUM,
             'format'=>['decimal', 2],
             	'pageSummary'=>true,
             'pageSummaryOptions' => [
               'style'=>[
                   'font-family'=>'tahoma',
                   'font-size'=>'8pt',
                   'text-align'=>'left',
                   'border-left'=>'0px',
               ]
             ],


           ],
            [
              'attribute' => 'budget.TARGET_VALUE',
              'label'=>'%',
              'hAlign'=>'left',
              'vAlign'=>'middle',
              'value' => function($model) {
                        if($model->budget->TARGET_VALUE == '')
                        {
                             return  $model->budget->TARGET_VALUE = 0.00;
                        }
                        else {
                          # code...
                           return $model->BUDGET_VALUE / $model->budget->TARGET_VALUE * 100;
                        }
                        ;},
              'headerOptions'=>[
                'style'=>[
                  'text-align'=>'center',
                  'width'=>'100px',
                  'font-family'=>'tahoma, arial, sans-serif',
                  'font-size'=>'9pt',
                  'background-color'=>'rgba(97, 211, 96, 0.3)',
                ]
              ],
              'contentOptions'=>[
                'style'=>[
                  'text-align'=>'left',
                  'width'=>'100px',
                  'font-family'=>'tahoma, arial, sans-serif',
                  'font-size'=>'9pt',
                ]
              ],
              'pageSummaryFunc'=>GridView::F_SUM,
            'format'=>['decimal', 2],
              'pageSummary'=>true,
            'pageSummaryOptions' => [
              'style'=>[
                  'font-family'=>'tahoma',
                  'font-size'=>'8pt',
                  'text-align'=>'left',
                  'border-left'=>'0px',
              ]
               ],
            ],
           [
             'attribute' => 'PERIODE_END',
             'label'=>'Periode',
             'hAlign'=>'left',
             'vAlign'=>'middle',
             'value' => function($model) { return $model->PERIODE_START . "-" . $model->PERIODE_END;},
             'headerOptions'=>[
               'style'=>[
                 'text-align'=>'center',
                 'width'=>'100px',
                 'font-family'=>'tahoma, arial, sans-serif',
                 'font-size'=>'9pt',
                 'background-color'=>'rgba(97, 211, 96, 0.3)',
               ]
             ],
             'contentOptions'=>[
               'style'=>[
                 'text-align'=>'left',
                 'width'=>'100px',
                 'font-family'=>'tahoma, arial, sans-serif',
                 'font-size'=>'9pt',
               ]
             ],
           ],
         ],
      'showPageSummary' => true,
      'pjax'=>true,
        'pjaxSettings'=>[
          'options'=>[
            'enablePushState'=>false,
            'id'=>'gv-term-general',
          ],
         ],
      'toolbar' => [
        '',
      ],
      'panel' => [
        'heading'=>'<h3 class="panel-title">Type Investasi</h3>',
        'type'=>'primary',
        'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Investasi ',
            ['modelClass' => 'Termcustomers',]),['/master/term-customers/create-budget','id'=>$dataids],[
              'data-toggle'=>"modal",
                'data-target'=>"#modal-create",
                'data-title'=>'type Investasi',
                  'class' => 'btn btn-info'
                        ]),
        'showFooter'=>true,

      ],

      'export' =>false,
    ]);
    ?>
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;">
        <div>
          <?php echo RABATE($model); ?>
        </div>
        <dl>
          <dt><h6><u><b>Conditional Rabate : <?= $model->RABATE_CNDT ?></b></u></h6></dt>
        </dl>
      </div>
    </div>

    <div class="row">
    <div class="col-xs-5 col-sm-5 col-md-5" style="font-family: tahoma ;font-size: 9pt;">
      <div>
        <?php echo target($model); ?>
      </div
        <dl>

          <dt style="width:80px; float:left;"><h6><u><b>Target :</b></u></h6></dt>
          <dd>:Rp.<?=$model->TARGET_VALUE?></dd>
            <dd>:	<?=$model->TARGET_TEXT ?> Rupiah</dd>

        </dl>
    </div>
  </div>

    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;">
        <div>
          <?php echo Growth($model); ?>
        </div>
        <dl>
          <dt><h6><u><b>Growth : <?= $model->GROWTH ?> %</b></u></h6></dt>
        </dl>
      </div>
    </div>


    <?php

    echo  $grid = GridView::widget([
        'id'=>'gv-term',
        'dataProvider'=> $dataProvider,
        'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline;'],
        // 'filterModel' => $searchModel1,
        // 'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
        'columns' =>
          [
             [
               'class'=>'kartik\grid\SerialColumn',
               'contentOptions'=>['class'=>'kartik-sheet-style'],
               'width'=>'10px',
               'header'=>'No.',
               'headerOptions'=>[
                 'style'=>[
                   'text-align'=>'center',
                   'width'=>'100px',
                   'font-family'=>'verdana, arial, sans-serif',
                   'font-size'=>'9pt',
                   'background-color'=>'rgba(97, 211, 96, 0.3)',
                 ]
               ],
               'contentOptions'=>[
                 'style'=>[
                   'text-align'=>'center',
                   'width'=>'100px',
                   'font-family'=>'tahoma, arial, sans-serif',
                   'font-size'=>'9pt',
                 ]
               ],
             ],

             [
               'attribute' => 'general.SUBJECT',
               'label'=>'General Term',
               'hAlign'=>'left',
               'vAlign'=>'middle',
               'headerOptions'=>[
                 'style'=>[
                   'text-align'=>'center',
                   'font-family'=>'tahoma, arial, sans-serif',
                   'font-size'=>'9pt',
                   'background-color'=>'rgba(97, 211, 96, 0.3)',
                 ]
               ],
               'contentOptions'=>[
                 'style'=>[
                   'text-align'=>'left',
                   'width'=>'100px',
                   'font-family'=>'tahoma, arial, sans-serif',
                   'font-size'=>'9pt',
                 ]
               ],
             ],
             [
               'attribute' => 'general.ISI_TERM',
               'label'=>'Isi Peraturan',
               'hAlign'=>'left',
               'vAlign'=>'middle',
               'headerOptions'=>[
                 'style'=>[
                   'text-align'=>'center',
                   'font-family'=>'tahoma, arial, sans-serif',
                   'font-size'=>'9pt',
                   'background-color'=>'rgba(97, 211, 96, 0.3)',
                 ]
               ],
               'contentOptions'=>[
                 'style'=>[
                   'text-align'=>'left',
                   'width'=>'100px',
                   'font-family'=>'tahoma, arial, sans-serif',
                   'font-size'=>'9pt',
                 ]
               ],
             ],

           ],
        'showPageSummary' => false,
        'pjax'=>true,
          'pjaxSettings'=>[
            'options'=>[
              'enablePushState'=>false,
              'id'=>'gv-term-general',
            ],
           ],
        'toolbar' => [
          '',
        ],
        'panel' => [
          'heading'=>'<h3 class="panel-title">General Term</h3>',
          'type'=>'primary',
          'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Term ',
              ['modelClass' => 'Termcustomers',]),['/master/term-customers/create-general','id'=>$dataids],[
                'data-toggle'=>"modal",
                  'data-target'=>"#modal-create",
                    'class' => 'btn btn-info'
                          ]),
          'showFooter'=>true,

        ],

        'export' =>false,
      ]);

 ?>
 <div style="text-align:right;float:right"">
    <?php echo PrintPdf($model); ?>
  </div>

 <div  class="col-md-12">
   <div  class="row" >
     <div class="col-md-6">
       <table id="tblterm" class="table table-bordered" style="font-family: tahoma ;font-size: 8pt;">
         <!-- Tanggal!-->
          <tr>
           <th  class="col-md-1" style="text-align: center; height:20px">
             <div style="text-align:center;">
               <?php
                 $placeTgl1= date('Y-m-d');
                 echo  $placeTgl1;
               ?>
             </div>

           </th>
           <!-- Tanggal Pembuat RO!-->
           <th class="col-md-1" style="text-align: center; height:20px">
             <div style="text-align:center;">
               <?php
                 $placeTgl2 = date('Y-m-d');
                 echo $placeTgl2;
               ?>
             </div>

           </th>
           <!-- Tanggal PO Approved!-->
           <th class="col-md-1" style="text-align: center; height:20px">
             <div style="text-align:center;">
               <?php
                 $placeTgl3= date('Y-m-d');
                 echo  $placeTgl3;
               ?>
             </div>
           </th>

         </tr>
         <!-- Department|Jbatan !-->
          <tr>
           <th  class="col-md-1" style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
             <div>
               <b><?php  echo $data['CUST_NM'] ; ?></b>
             </div>
           </th>
           <th class="col-md-1"  style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
             <div>
               <b><?php  echo $datadis['NM_DISTRIBUTOR']; ?></b>
             </div>
           </th>
           <th class="col-md-1" style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
             <div>
               <b><?php  echo $datacorp['CORP_NM']; ?></b>
             </div>
           </th>
         </tr>
         <!-- Signature !-->
          <tr>
           <th class="col-md-1" style="text-align: center; vertical-align:middle; height:40px">

           </th>
           <th class="col-md-1" style="text-align: center; vertical-align:middle">

           </th>
           <th  class="col-md-1" style="text-align: center; vertical-align:middle">

           </th>
         </tr>
         <!--Nama !-->
          <tr>
           <th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
             <div>

             </div>
           </th>
           <th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
             <div>

             </div>
           </th>
           <th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
             <div>

             </div>
           </th>
         </tr>
         <!-- Department|Jbatan !-->
          <tr>
           <th style="text-align: center; vertical-align:middle;height:20">
             <div>
               <b><?php  echo 'Nama:  '.ttd($model) ?></b>
               <?php
               $barisjabatancus = count($model->JABATAN_CUS);
               if($barisjabatancus == 0)
               {
               ?>
               <br><b><?php  echo 'Jabatan:  ---' ?></b>
               <?php
              }
              else{
               ?>
               <br><b><?php  echo 'Jabatan:  '.$model->JABATAN_CUS ?></b>
               <?php
             }
               ?>
             </div>
           </th>
           <th style="text-align: center; vertical-align:middle;height:20">
             <div>
               <b><?php  echo 'Nama:   '.ttd2($model) ?></b>
               <?php
               $barisjabatandis = count($model->JABATAN_DIST);
               if($barisjabatandis == 0)
               {
               ?>
               <br><b><?php  echo 'Jabatan:  ---' ?></b>
               <?php
              }
              else{
               ?>
               <br><b><?php  echo 'Jabatan:  '.$model->JABATAN_DIST ?></b>
               <?php
             }
               ?>
             </div>
           </th>
           <th style="text-align: center; vertical-align:middle;height:20">
             <div>
                  <b><?php  echo 'Nama:   '.ttd3($model) ?></b>
               <?php
               $barisjabataninternal = count($model->JOBGRADE_ID);
               if($barisjabataninternal == 0)
               {
               ?>

               <br><b><?php  echo 'Jabatan:  ---' ?></b>
               <?php
              }
              else{
                $datainternal = Jobgrade::find()->where(['JOBGRADE_ID'=>$model->JOBGRADE_ID])->asArray()
                                                                                              ->one();
               ?>
                <br><b><?php  echo 'Jabatan:  '.$datainternal['JOBGRADE_NM'] ?></b>

               <?php
             }
               ?>
             </div>
           </th>
         </tr>
       </table>
     </div>
<?php
     $this->registerJs("
        $.fn.modal.Constructor.prototype.enforceFocus = function(){};
        $('#pihak').on('show.bs.modal', function (event) {
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
        'id' => 'pihak',
       'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title"> Pihak Terkait</h4></div>',
       'headerOptions'=>[
           'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
       ],
       ]);
       Modal::end();
       $this->registerJs("
          $.fn.modal.Constructor.prototype.enforceFocus = function(){};
          $('#RABATE').on('show.bs.modal', function (event) {
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
          'id' => 'RABATE',
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title"> Rabate Conditional</h4></div>',
         'headerOptions'=>[
             'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
         ],
         ]);
         Modal::end();
         $this->registerJs("
            $.fn.modal.Constructor.prototype.enforceFocus = function(){};
            $('#Growth').on('show.bs.modal', function (event) {
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
            'id' => 'Growth',
           'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title"> Growth</h4></div>',
           'headerOptions'=>[
               'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
           ],
           ]);
           Modal::end();

       $this->registerJs("
          $.fn.modal.Constructor.prototype.enforceFocus = function(){};
          $('#periode').on('show.bs.modal', function (event) {
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
          'id' => 'periode',
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Jangka Waktu</h4></div>',
         'headerOptions'=>[
             'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
         ],
         ]);
         Modal::end();

         $this->registerJs("
            $.fn.modal.Constructor.prototype.enforceFocus = function(){};
            $('#TOP').on('show.bs.modal', function (event) {
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
            'id' => 'TOP',
           'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Term Of Payment</h4></div>',
           'headerOptions'=>[
               'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
           ],
           ]);
           Modal::end();

           $this->registerJs("
              $.fn.modal.Constructor.prototype.enforceFocus = function(){};
              $('#TARGET').on('show.bs.modal', function (event) {
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
              'id' => 'TARGET',
             'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Target</h4></div>',
             'headerOptions'=>[
                 'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
             ],
             ]);
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
               'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Term</h4></div>',
               'headerOptions'=>[
                   'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
               ],
               ]);
               Modal::end();

               $this->registerJs("
                  $.fn.modal.Constructor.prototype.enforceFocus = function(){};
                  $('#modal-general').on('show.bs.modal', function (event) {
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
                  'id' => 'modal-general',
                 'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">General Term</h4></div>',
                 'headerOptions'=>[
                     'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
                 ],
                 ]);
                 Modal::end();

                 $this->registerJs("
                    $.fn.modal.Constructor.prototype.enforceFocus = function(){};
                    $('#TTD1').on('show.bs.modal', function (event) {
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
                    'id' => 'TTD1',
                   'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Sku</h4></div>',
                   'headerOptions'=>[
                       'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
                   ],
                   ]);
                   Modal::end();
                   $this->registerJs("
                      $.fn.modal.Constructor.prototype.enforceFocus = function(){};
                      $('#TTD2').on('show.bs.modal', function (event) {
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
                      'id' => 'TTD2',
                     'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Sku</h4></div>',
                     'headerOptions'=>[
                         'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
                     ],
                     ]);
                     Modal::end();
                     $this->registerJs("
                        $.fn.modal.Constructor.prototype.enforceFocus = function(){};
                        $('#TTD3').on('show.bs.modal', function (event) {
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
                        'id' => 'TTD3',
                       'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Sku</h4></div>',
                       'headerOptions'=>[
                           'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
                       ],
                       ]);
                       Modal::end();
