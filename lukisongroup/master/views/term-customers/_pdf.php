
<?php
use yii\helpers\Html;
use kartik\grid\GridView;

?>

<div class="container-fluid" style="font-family: tahoma ;font-size: 8pt;">
  <div style="width:240px; float:left;">
    <?php echo Html::img('@web/img_setting/kop/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
  </div>
  <div style="padding-top:40px;">
    <h4 class="text-left"><b><?php echo ucwords($data->NM_TERM ) ?> </b></h4>
  </div>

  <hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
  <hr style="height:1px;margin-top: 1px; margin-bottom: 10px;">

  <!-- BORDER PAGE!-->
	<table class="table table-bordered">
		<tr>
			<td style="width:30%; padding-left:20px; padding-top:5px; padding-bottom:5px"> Pihak/partilies</td>
			<td style="width:70%; padding-left:20px; padding-top:5px; padding-bottom:5px">
				<br>1. <?= $datacus['CUST_NM'] ?>
				<br>2. <?= $datadis['NM_DISTRIBUTOR']?>
				<br>3. <?= $datacorp['CORP_NM']?>
			</td>
		</tr>
        <tr>
			<td style="width:30%; padding-left:20px; padding-top:5px; padding-bottom:5px"> Period/Jangka waktu</td>
			<td style="width:30%; padding-left:20px; padding-top:5px; padding-bottom:5px"> <?= $data->PERIOD_START ?> - <?= $data->PERIOD_END  ?></td>
		</tr>
		<tr>
			<td style="width:30%; padding-left:20px; padding-top:5px; padding-bottom:5px"> Term of Payment</td>
			<td style="width:30%; padding-left:20px; padding-top:5px; padding-bottom:15px"> <?= $data->TOP  ?></td>
		</tr>
		<tr>
			<td style="width:30%; padding-left:20px; padding-top:5px; padding-bottom:5px; vertical-align:top"> Trade Investment</td>
			<td style="width:30%; padding-left:20px; padding-top:15px; padding-bottom:15px;padding-right:15px">
				<div>
					<?php
					echo $grid = GridView::widget([
						  'id'=>'gv-term-general',
						  'dataProvider'=> $dataProvider,
						  'columns' =>[
							   [
									'class'=>'kartik\grid\SerialColumn',
									'contentOptions'=>['class'=>'kartik-sheet-style'],
									'width'=>'10px',
									'header'=>'No.',
									'headerOptions'=>[
										'style'=>[
										 'text-align'=>'center',
										 'width'=>'5%',
										 'font-family'=>'verdana, arial, sans-serif',
										 'font-size'=>'9pt',
										 'background-color'=>'rgba(97, 211, 96, 0.3)',
										]
									],
									'contentOptions'=>[
										'style'=>[
										 'text-align'=>'center',
										 'width'=>'5%',
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
											 'width'=>'20%',
											 'font-family'=>'tahoma, arial, sans-serif',
											 'font-size'=>'9pt',
											 'background-color'=>'rgba(97, 211, 96, 0.3)',
										]
									],
									'contentOptions'=>[
										'style'=>[
											 'text-align'=>'left',
											 'width'=>'20%',
											 'font-family'=>'tahoma, arial, sans-serif',
											 'font-size'=>'9pt',
										]
									],
							   ],
							   [
									'attribute' => 'PERIODE_END',
									'label'=>'Periode',
									'hAlign'=>'left',
									'vAlign'=>'middle',
									'value' => function($model) { 
										$prde=$model->PERIODE_START!='0000-00-00'? $model->PERIODE_START . " - " . $model->PERIODE_END:"";
										//return $model->PERIODE_START . " - " . $model->PERIODE_END;
										return $prde;
									},
									'headerOptions'=>[
										'style'=>[
											 'text-align'=>'center',
											 'width'=>'21%',
											 'font-family'=>'tahoma, arial, sans-serif',
											 'font-size'=>'9pt',
											 'background-color'=>'rgba(97, 211, 96, 0.3)',
										]
									],
									'contentOptions'=>[
										'style'=>[
											 'text-align'=>'left',
											 'width'=>'21%',
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
										   'text-align'=>'right',
										   'border-left'=>'0px',
										   //'border-right'=>'0px',
										]
									],
							   ],
							   [	//BUDGET_PLAN
									//coll
									'attribute' => 'BUDGET_PLAN',
									'label'=>'Budget Plan',
									'hAlign'=>'left',
									'vAlign'=>'middle',
									'headerOptions'=>[
										'style'=>[
											 'text-align'=>'center',
											 'width'=>'20%',
											 'font-family'=>'tahoma, arial, sans-serif',
											 'font-size'=>'9pt',
											 'background-color'=>'rgba(97, 211, 96, 0.3)',
										]
									],
									'contentOptions'=>[
										'style'=>[
											 'text-align'=>'right',
											 'width'=>'20%',
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
										   'text-align'=>'right',
										   'border-left'=>'0px',
										]
									],
							   ],
							   [	//BUDGET_PLAN PERCENT
									//coll
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
											 return $model['BUDGET_PLAN'] / $model['TARGET_VALUE'] * 100;
											}
									},
									'headerOptions'=>[
										'style'=>[
										 'text-align'=>'center',
										 'width'=>'7%',
										 'font-family'=>'tahoma, arial, sans-serif',
										 'font-size'=>'9pt',
										 'background-color'=>'rgba(97, 211, 96, 0.3)',
										]
									],
									'contentOptions'=>[
										'style'=>[
											 'text-align'=>'right',
											 'width'=>'7%',
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
											 'text-align'=>'right',
											 'border-left'=>'0px',
										]
									],
								],
								[	//BUDGET_ACTUAL
									//coll
									'attribute' => 'BUDGET_ACTUAL',
									'label'=>'Budget Actual',
									'hAlign'=>'left',
									'vAlign'=>'middle',
									'headerOptions'=>[
										'style'=>[
											 'text-align'=>'center',
											 'width'=>'20%',
											 'font-family'=>'tahoma, arial, sans-serif',
											 'font-size'=>'9pt',
											 'background-color'=>'rgba(97, 211, 96, 0.3)',
										]
									],
									'contentOptions'=>[
										'style'=>[
											 'text-align'=>'right',
											 'width'=>'20%',
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
										   'text-align'=>'right',
										   'border-left'=>'0px',
										]
									],
							   ],
							   [	//BUDGET_ACTUAL PERCENT
									//coll
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
											 return $model['BUDGET_ACTUAL'] / $model['TARGET_VALUE'] * 100;
											}
									},
									'headerOptions'=>[
										'style'=>[
										 'text-align'=>'center',
										 'width'=>'7%',
										 'font-family'=>'tahoma, arial, sans-serif',
										 'font-size'=>'9pt',
										 'background-color'=>'rgba(97, 211, 96, 0.3)',
										]
									],
									'contentOptions'=>[
										'style'=>[
											 'text-align'=>'right',
											 'width'=>'7%',
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
											 'text-align'=>'right',
											 'border-left'=>'0px',
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

						]);
					?>
					</div>
					<div>
							  <p style="border:0px;">Planing Running Rate base on percentage
							  <br>Total Trade Investment    : RP. <?= $data->TARGET_VALUE ?>
							  <?php
							  if( $datasum['BUDGET_PLAN'] == '' || $data->TARGET_VALUE == '')
							  {
								$percentage = 0.00;
							  }
							  else {
								# code...
								$percentage = ($datasum['BUDGET_PLAN'] / $data->TARGET_VALUE)*100;

							  }
								$bulat = round($percentage);

							   ?>
							  <!-- <br>Investment Percentage   :   $bulat ?>%</p> -->
							  <br>

							  <p style="border:0px;">Actually Running Rate base on percentage
							  <br>Total Trade Investment    : RP. <?= $data->TARGET_VALUE ?>
							  <?php
							  if( $datasum['BUDGET_ACTUAL'] == '' || $data->TARGET_VALUE == '')
							  {
								$percentage = 0.00;
							  }
							  else {
								# code...
								$percentage = ($datasum['BUDGET_ACTUAL'] / $data->TARGET_VALUE)*100;
							  }
								$bulat = round($percentage);

							   ?>
							  <br>Investment Percentage   :   <?= $bulat ?>%</p>
							  <br>
						</div>
				</td>
		</tr>
		<tr>
			 <td style="width:30%; padding-left:20px; padding-top:5px; padding-bottom:5px"> Conditional Rabate </td>
			 <td style="width:30%; padding-left:20px; padding-top:5px; padding-bottom:5px"><?= $data->RABATE_CNDT ?></td>

		</tr>
		<tr>
			<td style="width:30%; padding-left:20px; padding-top:5px; padding-bottom:5px">Purchase Target/Target Pembelian</td>
			<td style="width:30%; padding-left:20px; padding-top:10px; padding-bottom:5px"><h4 style="text-align: center;"><?php echo 'Rp. '.$data->TARGET_VALUE ?></h4>
					  <h5 style="text-align: center;"> <br><?= $data->TARGET_TEXT ?> Rupiah</h5>
			</td>
		</tr>
		<tr>
			<td style="width:30%; padding-left:20px; padding-top:5px; padding-bottom:5px"> Growth </td>
			<td style="width:30%; padding-left:20px; padding-top:5px; padding-bottom:5px"> <?= $data->GROWTH ?> % </td>
		</tr>
	</table>


  <!-- Signature !-->
  <div  class="col-md-12">
    <div  class="row" >
      <div class="col-md-6">
        <table id="tbl" class="table table-bordered" style="font-family: tahoma ;font-size: 8pt;">
          <!-- Tanggal!-->
           <tr>
            <!-- Tanggal Pembuat RO!-->
            <th  class="col-md-1" style="text-align: center; height:20px">
              <div style="text-align:center;">
                <?php
                  $placeTgl1=$data->SIG1_TGL!=0 ? Yii::$app->ambilKonvesi->convert($data->SIG1_TGL,'date') :'';
                  echo '<b>Tangerang</b>,' . $placeTgl1;
                ?>
              </div>

            </th>
            <!-- Tanggal Pembuat RO!-->
            <th class="col-md-1" style="text-align: center; height:20px">
              <div style="text-align:center;">
                <?php
                  $placeTgl2=$data->SIG2_TGL!=0 ? Yii::$app->ambilKonvesi->convert($data->SIG2_TGL,'date') :'';
                  echo '<b>Tangerang</b>,' . $placeTgl2;
                ?>
              </div>

            </th>
            <!-- Tanggal PO Approved!-->
            <th class="col-md-1" style="text-align: center; height:20px">
              <div style="text-align:center;">
                <?php
                  $placeTgl3=$data->SIG3_TGL!=0 ? Yii::$app->ambilKonvesi->convert($data->SIG3_TGL,'date') :'';
                  echo '<b>Tangerang</b>,' . $placeTgl3;
                ?>
              </div>
            </th>

          </tr>
          <!-- Department|Jbatan !-->
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
            <th class="col-md-1" style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
              <div>
                <b><?php  echo 'Approved'; ?></b>
              </div>
            </th>
          </tr>
          <!-- Signature !-->
           <tr>
            <th class="col-md-1" style="text-align: center; vertical-align:middle; height:40px">
              <?php
              $ttd1 =  $data->SIG1_SVGBASE64 !='' ? '<img style="width:80; height:40px" src='.$data->SIG1_SVGBASE64.'></img>':'';
                ?>
                <?= $ttd1 ?>;

            </th>
            <th class="col-md-1" style="text-align: center; vertical-align:middle">
              <?php
                $ttd2 =  $data->SIG2_SVGBASE64 !='' ? '<img style="width:80; height:40px" src='.$data->SIG2_SVGBASE64.'></img>':'';
                echo $ttd2;
              ?>
            </th>
            <th  class="col-md-1" style="text-align: center; vertical-align:middle">
              <?php
                  $ttd3 = $data->SIG3_SVGBASE64 !='' ? '<img style="width:80; height:40px" src='.$data->SIG3_SVGBASE64.'></img>':'';
                  echo $ttd3;
              ?>
            </th>
          </tr>
          <!--Nama !-->
           <tr>
            <th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
              <div>
                <?php
                  $sigNm1=$data->SIG1_NM!='none' ? '<b>'.$data->SIG1_NM.'</b>' : 'none';
                  echo $sigNm1;
                ?>
              </div>
            </th>
            <th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
              <div>
                <?php
                  $sigNm2=$data->SIG2_NM!='none' ? '<b>'.$data->SIG2_NM.'</b>' : 'none';
                  echo $sigNm2;
                ?>
              </div>
            </th>
            <th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
              <div>
                <?php
                  $sigNm3=$data->SIG3_NM!='none' ? '<b>'.$data->SIG3_NM.'</b>' : 'none';
                  echo $sigNm3;
                ?>
              </div>
            </th>
          </tr>
          <!-- Department|Jbatan !-->
           <tr>
            <th style="text-align: center; vertical-align:middle;height:20">
              <div>
                <b><?php  echo 'Marketing & Sales'; ?></b>
              </div>
            </th>
            <th style="text-align: center; vertical-align:middle;height:20">
              <div>
                <b><?php  echo 'F & A'; ?></b>
              </div>
            </th>
            <th style="text-align: center; vertical-align:middle;height:20">
              <div>
                <b><?php  echo 'Director'; ?></b>
              </div>
            </th>
          </tr>
        </table>
      </div>
    </div>
  </div>
