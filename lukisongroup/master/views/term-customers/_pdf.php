
<?php
use yii\helpers\Html;

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
              <td> <?= $data->PERIOD_START ?> - <?= $data->PERIOD_END  ?>

      </tr>
       <tr>
           <td> Term of Payment</td>
           <td> <?= $data->TOP  ?></td>

      </tr>
      <tr>
          <td> Trade Investment</td>
          <td>                  </td>

     </tr>
     <tr>
         <td> Conditional Rabate </td>
         <td>                  </td>

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


  </diV>
