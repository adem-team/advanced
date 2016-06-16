<table id="tblRo" class="table table-bordered" style="font-family: tahoma ;font-size: 8pt;">
  <tr>
  <th  class="col-md-1" style="text-align: center; height:20px">
    <div style="text-align:center;">
      <?php
        $placeTgl1=$poHeader->SIG1_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG1_TGL,'date') :'';
        echo '<b>Tangerang</b>,' . $placeTgl1;
      ?>
    </div>
  </th>
  <!-- Tanggal Pembuat RO!-->
  <th class="col-md-1" style="text-align: center; height:20px">
    <div style="text-align:center;">
      <?php
        $placeTgl2=$poHeader->SIG2_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG2_TGL,'date') :'';
        echo '<b>Tangerang</b>,' . $placeTgl2;
      ?>
    </div>
  </th>
  </th>
  <!-- Tanggal Pembuat RO!-->
  <th class="col-md-1" style="text-align: center; height:20px">
  <div style="text-align:center;">
    <?php
      $placeTgl4=$poHeader->SIG4_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG4_TGL,'date') :'';
      echo '<b>Tangerang</b>,' . $placeTgl4;
    ?>
  </div>
  </th>
  <!-- Tanggal PO Approved!-->
  <th class="col-md-1" style="text-align: center; height:20px">
    <div style="text-align:center;">
      <?php
        $placeTgl3=$poHeader->SIG3_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG3_TGL,'date') :'';
        echo '<b>Tangerang</b>,' . $placeTgl3;
      ?>
    </div>
  </th>

  </tr>

   <tr>
    <th  class="col-md-1" style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
      <div>
        <b><?php  echo 'Created'; ?></b>
      </div>
    </th>
    <th class="col-md-1"  style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
      <div>
        <b><?php  echo 'Checked'; ?></b>
      </div>
    </th>
    <th class="col-md-1"  style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
      <div>
        <b><?php  echo 'Checked'; ?></b>
      </div>
    </th>
    <th class="col-md-1" style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
      <div>
        <b><?php  echo 'Approved'; ?></b>
      </div>
    </th>
  </tr>
  <tr>
   <th style="text-align: center; vertical-align:middle;width:180; height:60px">
     <?php

       $ttd1 = $poHeader->SIG1_SVGBASE64!='' ?  '<img src="'.$poHeader->SIG1_SVGBASE64.'" height="60" width="150"></img>' : SignCreated($poHeader);
       echo $ttd1;

     ?>
   </th>
   <th style="text-align: center; vertical-align:middle;width:180">
     <?php
       $ttd2 = $poHeader->SIG2_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$poHeader->SIG2_SVGBASE64.'</img>' : SignChecked($poHeader);
       echo $ttd2
     ?>
   </th>
   <th style="text-align: center; vertical-align:middle;width:180">

     <?php
     /*  author : wawan ver 1.0
         * jika tidak ada permission maka untuk tanda tangan yang akan approve hilang
         * jika BTN_SIGN3 adalah 0 maka untuk tanda tangan yang akan approve hilang
         * if status po header equal 4 then  button name Reject
     */
     if(getPermission())
     {
       if(getPermission()->BTN_SIGN4 == 0)
       {
         $ttd4 = '';
         echo $ttd4;

       }else{
         $ttd4 = $poHeader->SIG4_SVGBASE64!='' ?  '<img src="'.$poHeader->SIG4_SVGBASE64.'" height="60" width="150"></img>' : SignChecked2($poHeader);
         echo $ttd4;
       }
     }else{
       $ttd4 = '';
       echo $ttd4;
     }

     ?>
   </th>
   <th style="text-align: center; vertical-align:middle;width:180">
     <?php
     /*  author : wawan ver 1.0
         * jika tidak ada permission maka untuk tanda tangan yang akan approve hilang
         * jika BTN_SIGN3 adalah 0 maka untuk tanda tangan yang akan approve hilang
         * if status po header equal 4 then  button name Reject
     */
     if(getPermission())
     {
       if(getPermission()->BTN_SIGN3 == 0)
       {
         $ttd3 = '';
         echo $ttd3;

       }else{
         $ttd3 = $poHeader->SIG3_SVGBASE64!='' ?  '<img src="'.$poHeader->SIG3_SVGBASE64.'" height="60" width="150"></img>' : SignApproved($poHeader);
         echo $ttd3;
       }
     }else{
       $ttd3 = '';
       echo $ttd3;
     }

     ?>
   </th>
  </tr>
  <tr>
   <th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
     <div>
       <?php
         $sigNm1=$poHeader->SIG1_NM!='none' ? '<b>'.$poHeader->SIG1_NM.'</b>' : 'none';
         echo $sigNm1;
       ?>
     </div>
   </th>
   <th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
     <div>
       <?php
         $sigNm2=$poHeader->SIG2_NM!='none' ? '<b>'.$poHeader->SIG2_NM.'</b>' : 'none';
         echo $sigNm2;
       ?>
     </div>
   </th>
   <th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
     <div>
       <?php
         $sigNm4=$poHeader->SIG4_NM!='none' ? '<b>'.$poHeader->SIG4_NM.'</b>' : 'none';
         echo $sigNm4;
       ?>
     </div>
   </th>
   <th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
     <div>
       <?php
         $sigNm3=$poHeader->SIG3_NM!='none' ? '<b>'.$poHeader->SIG3_NM.'</b>' : 'none';
         echo $sigNm3;
       ?>
     </div>
   </th>
  </tr>
  <tr>
   <th style="text-align: center; vertical-align:middle;height:20">
     <div>
       <b><?php  echo 'Purchaser'; ?></b>
     </div>
   </th>
   <th style="text-align: center; vertical-align:middle;height:20">
     <div>
       <b><?php  echo 'F & A'; ?></b>
     </div>
   </th>
   <th style="text-align: center; vertical-align:middle;height:20">
     <div>
       <b><?php  echo 'General Manager'; ?></b>
     </div>
   </th>
   <th style="text-align: center; vertical-align:middle;height:20">
     <div>
       <b><?php  echo 'Director'; ?></b>
     </div>
   </th>
 </tr>
</table>
