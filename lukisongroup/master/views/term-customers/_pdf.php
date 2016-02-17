
<?php
use yii\helpers\Html;
use kartik\grid\GridView;

?>

<?php


 ?>

<div class="container-fluid" style="font-family: tahoma ;font-size: 8pt;">
  <div style="width:240px; float:left;">
    <?php echo Html::img('@web/img_setting/kop/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
  </div>
  <div style="padding-top:40px;">

    <h4 class="text-left"><b><?= $data->NM_TERM ?> </b></h4>
  </div>
  <hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
  <hr style="height:1px;margin-top: 1px; margin-bottom: 10px;">
  <table class="table table-bordered">
      <tr>

          <td> Pihak/partilies</td>
          <td> <br>1. <?= $datacus['CUST_NM'] ?>
               <br>2. <?= $datadis['NM_DISTRIBUTOR']?>
               <br>3. <?= $datacorp['CORP_NM']?>
          </td>

        </tr>

        <tr>
              <td> Period/Jangka waktu</td>
              <td> <?= $data->PERIOD_START ?> - <?= $data->PERIOD_END  ?></td>

      </tr>
       <tr>
           <td> Term of Payment</td>
           <td> <?= $data->TOP  ?></td>

      </tr>
      <tr>
          <td> Trade Investment</td>
          <td> <?= $grid = GridView::widget([
              'id'=>'gv-term-general',
              'dataProvider'=> $dataProvider,
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
                         'width'=>'80px',
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
                     'label'=>'%',
                     'hAlign'=>'left',
                     'vAlign'=>'middle',
                     'value' => function($model) {
                                if($model['TARGET_VALUE'] == '')
                                {
                                   return $model['TARGET_VALUE'] = 0.00;
                                }
                                else {
                                  # code...
                                 return $model['BUDGET_VALUE'] / $model['TARGET_VALUE'] * 100;
                                }
                            ;},
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
                     'value' => function($model) { return $model['PERIODE_START'] . "-" . $model['PERIODE_END'] ;},
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
                ],

                'panel' => [
                  'footer'=>false,
                  'heading'=>false,
                ],
                'toolbar'=> [
                  //'{items}',
                ],
                'showPageSummary' => true,
                'showFooter'=>false,
                'hover'=>true, //cursor select
                'responsive'=>true,
                'responsiveWrap'=>true,
                'bordered'=>false,
                'striped'=>'0px',
                'autoXlFormat'=>true,
                'export' => false,

            ])?>
                  <p style="border:0px;">Running Rate base on percentage
                  <br>Total Trade Investment    : RP. <?= $data->TARGET_VALUE ?>
                  <?php
                  if( $datasum['BUDGET_VALUE'] == '')
                  {
                    $percentage = 0.00;
                  }
                  else {
                    # code...
                    $percentage = ($datasum['BUDGET_VALUE'] / $data->TARGET_VALUE)*100;

                  }
                    $bulat = round($percentage);

                   ?>
                  <br>Investment Percentage   :   <?= $bulat ?>%</p>
          </td>

     </tr>
     <tr>
         <td> Conditional Rabate </td>
         <td>                  </td>

    </tr>
    <tr>
        <td> Purchase Target/Target
            <br>Pembelian
        </td>
        <td>      <h3 style="text-align: center;"><?= $data->TARGET_VALUE ?></h3>
                  <h3 style="text-align: center;"> <br><?= $data->TARGET_TEXT ?> Rupiah</h3>

        </td>

   </tr>
    <tr>
        <td> Growth </td>
        <td> <?= $data->GROWTH ?></td>

   </tr>
   <tr>
       <td> General Terms/Aturan
            <br><?= $term['SUBJECT'] ?>
       </td>
       <td> <?= $term['ISI_TERM'] ?></td>

  </tr>

</table>

<p> This Trading Term is executed in 3(three) originals each suffciently affixed with duty stamps and shall has the same legal force to the Partiles.
   Trading Term ini dibuat dala rangkap 3 (tiga),dan ditandatangani oleh Para Pihak,bermaterai cukup dan masing-masing mempunyai kekuatan hukum yang sama bagi Para Pihak </p>

     <table id="tbl" class="table table-bordered" style="font-family: tahoma ;font-size: 8pt;">
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
             <b><?php  echo $datacus['CUST_NM'] ; ?></b>
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
             <b><?php  echo 'NAMA:  '.$data['CUST_NM']; ?></b>
            <br><b><?php  echo 'Jabatan:  '.$data['JABATAN_CUS'] ?></b>
           </div>
         </th>
         <th style="text-align: center; vertical-align:middle;height:20">
           <div>
               <b><?php  echo 'NAMA:  '.$data['DIST_NM']; ?></b>
               <br><b><?php  echo 'Jabatan:  '.$data['JABATAN_DIST'] ?></b>
           </div>
         </th>
         <th style="text-align: center; vertical-align:middle;height:20">
           <div>
             <b><?php  echo 'NAMA:  '.$data['PRINCIPAL_NM']; ?></b>
              <br><b><?php  echo 'Jabatan:  '.$datainternal['JOBGRADE_NM'] ?></b>
           </div>
         </th>
       </tr>
     </table>


  </diV>
