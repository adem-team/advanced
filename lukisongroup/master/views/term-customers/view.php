<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;;
use lukisongroup\master\models\Terminvest;
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Distributor;
use lukisongroup\hrd\models\Corp;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termcustomers */

function pihakSearch($model){
  $title = Yii::t('app','');
  $options = [ 'id'=>'select-spl-id',
          'data-toggle'=>"modal",
          'data-target'=>"#search-spl",
          'class'=>'btn btn-warning btn-xs',
          //'style'=>['width'=>'150px'],
          'title'=>'Set Supplier'
  ];
  $icon = '<span class="glyphicon glyphicon-open"></span>';
  $label = $icon . ' ' . $title;
  $url = Url::toRoute(['/purchasing/purchase-order/supplier-view','id'=>$model->ID_TERM]);
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
        <?php echo pihakSearch($model); ?>
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
        <?php echo pihakSearch($model); ?>
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
        <?php echo pihakSearch($model); ?>
      </div>
      <dl>

        <dt><h6><u><b>Term Of Payment : <?= $model->TOP ?></b></u></h6></dt>


      </dl>
    </div>
  </div>

  <div class="row">
  <div class="col-xs-5 col-sm-5 col-md-5" style="font-family: tahoma ;font-size: 9pt;">
    <div>
      <?php echo pihakSearch($model); ?>
    </div
      <dl>

        <dt style="width:80px; float:left;"><h6><u><b>Target :</b></u></h6></dt>
        <dd>:	<?=$model->TARGET_TEXT ?></dd>
        <dd>:	<?=$model->TARGET_VALUE?></dd>

      </dl>
  </div>
</div>
<?php

$gvterm = GridView::widget([
  'id'=>'gv-term',
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
  'columns' => [
    [/* Attribute KD RO */
      'attribute'=>'SUBJECT',
      'label'=>'Aturan',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      //'mergeHeader'=>true,
      'format' => 'raw',
      'headerOptions'=>[
        //'class'=>'kartik-sheet-style'
        'style'=>[
          'text-align'=>'center',
          'width'=>'150px',
          'font-family'=>'tahoma',
          'font-size'=>'8pt',
          'background-color'=>'rgba(0, 95, 218, 0.3)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'width'=>'150px',
          'font-family'=>'tahoma',
          'font-size'=>'8pt',
        ]
      ],
      'pageSummaryOptions' => [
        'style'=>[
            'border-left'=>'0px',
            'border-right'=>'0px',
        ]
      ]
    ],

    [
      'class'=>'kartik\grid\EditableColumn',
      'attribute'=>'ISI_TERM',
      'label'=>'ISI Perjanjian',
      'vAlign'=>'middle',
      'hAlign'=>'center',
      // 'mergeHeader'=>true,
      'headerOptions'=>[
        'style'=>[
          // 'text-align'=>'center',
          // 'width'=>'20px',
          'font-family'=>'tahoma',
          'font-size'=>'8pt',
          'background-color'=>'rgba(0, 95, 218, 0.3)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
            // 'text-align'=>'right',
            'width'=>'10px',
            'font-family'=>'tahoma',
            'font-size'=>'8pt',
            'border-right'=>'0px',
        ]
      ],
      'pageSummaryOptions' => [
        'style'=>[
            'border-left'=>'0px',
            'border-right'=>'0px',
        ]
      ],
      'editableOptions' => [
        'header' => 'Isi Perjanjian',
        'inputType' => \kartik\editable\Editable::INPUT_TEXTAREA,
        'size' => 'sm',
         'options' => ['class'=>'form-control', 'rows'=>6, 'placeholder'=>'Enter notes...']
            // 'text-align'=>'center',
      ],
    ],

  ],
  'pjax'=>true,
  'pjaxSettings'=>[
   'options'=>[
    'enablePushState'=>false,
    'id'=>'gv-term',
     ],
    'refreshGrid' => true,
    'neverTimeout'=>true,
  ],
  'panel' => [
    //'footer'=>false,
    'heading'=>false,
  ],
  /* 'toolbar'=> [
    //'{items}',
  ],  */
  'hover'=>true, //cursor select
  'responsive'=>true,
  'responsiveWrap'=>true,
  'bordered'=>true,
  'striped'=>'4px',
  'autoXlFormat'=>true,
  'export' => false,
]);

echo $gvterm;

 ?>

 <div  class="col-md-12">
   <div  class="row" >
     <div class="col-md-6">
       <table id="tblRo" class="table table-bordered" style="font-family: tahoma ;font-size: 8pt;">
         <!-- Tanggal!-->
          <tr>
           <!-- Tanggal Pembuat RO!-->
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
             <?php
              //  $ttd1 = $poHeader->SIG1_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$poHeader->SIG1_SVGBASE64.'></img>' :'';
              //  echo $ttd1;
             ?>
           </th>
           <th class="col-md-1" style="text-align: center; vertical-align:middle">
             <?php
              //  $ttd2 = $poHeader->SIG2_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$poHeader->SIG2_SVGBASE64.'></img>' :'';
              //  echo $ttd2;
             ?>
           </th>
           <th  class="col-md-1" style="text-align: center; vertical-align:middle">
             <?php
              //  $ttd3 = $poHeader->SIG3_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$poHeader->SIG3_SVGBASE64.'></img>' :'';
               //if ($poHeader->STATUS==101 OR $poHeader->STATUS==10){
                //  echo $ttd3;
               //}
             ?>
           </th>
         </tr>
         <!--Nama !-->
          <tr>
           <th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
             <div>
               <?php
                //  $sigNm1=$poHeader->SIG1_NM!='none' ? '<b>'.$poHeader->SIG1_NM.'</b>' : 'none';
                //  echo $sigNm1;
               ?>
             </div>
           </th>
           <th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
             <div>
               <?php
                //  $sigNm2=$poHeader->SIG2_NM!='none' ? '<b>'.$poHeader->SIG2_NM.'</b>' : 'none';
                //  echo $sigNm2;
               ?>
             </div>
           </th>
           <th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
             <div>
               <?php
                //  $sigNm3=$poHeader->SIG3_NM!='none' ? '<b>'.$poHeader->SIG3_NM.'</b>' : 'none';
                //  echo $sigNm3;
               ?>
             </div>
           </th>
         </tr>
         <!-- Department|Jbatan !-->
          <tr>
           <th style="text-align: center; vertical-align:middle;height:20">
             <div>
               <b><?php  echo 'Pihak 1'; ?></b>
             </div>
           </th>
           <th style="text-align: center; vertical-align:middle;height:20">
             <div>
               <b><?php  echo 'Pihak 2'; ?></b>
             </div>
           </th>
           <th style="text-align: center; vertical-align:middle;height:20">
             <div>
               <b><?php  echo 'Pihak 3'; ?></b>
             </div>
           </th>
         </tr>
       </table>
     </div>
