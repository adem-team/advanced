
<?php

use kartik\helpers\Html;
use yii\helpers\Url;
use dosamigos\gallery\Gallery;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\bootstrap\Modal;
use lukisongroup\widget\models\NotulenModul;

use lukisongroup\hrd\models\Employe;
use yii\helpers\ArrayHelper;

// $this->registerCss($this->render('letter.css'));

// $this->registerCss($this->render('accordion.css'));

// $this->registerJs($this->render('set_person.js'),$this::POS_READY);





 

	// function SIGN_2($acara)
	// {
	// 	$data = Employe::find()->where(['EMP_ID'=>$detail_notulen->SIG2_ID])->one();
	// 	return $data->SIGSVGBASE64;
	// }

	// function SIGN_1($acara)
	// {
	// 	$data = Employe::find()->where(['EMP_ID'=>$detail_notulen->SIG1_ID])->one();
	// 	return $data->SIGSVGBASE64;
	// }

	
	function SIGNATURE_pdf2($id_sig)
	{
		// $data = Employe::find()->where(['EMP_ID'=>$acara[0]->SIG2_ID])->one();
		// return $data->SIGSVGBASE64;

		 $data = (new \yii\db\Query())
				      ->select(['SIGSVGBASE64'])
		              ->from('dbm002.a0001')
					  ->where(['EMP_ID'=>$id_sig])
					  ->one();
		 return $data['SIGSVGBASE64'];

	};


#tanggal
$tanggal = $header_notulen->start != '' ? Yii::$app->formatter->format($header_notulen->start, 'date'): Yii::t('app','xxxx-xx-xx');

#time
if($detail_notulen->TIME_START != '' && $detail_notulen->TIME_END != '' )
      {
         $time = $detail_notulen->TIME_START.' - '.$detail_notulen->TIME_END;
      }elseif($detail_notulen->TIME_END != '' && $detail_notulen->TIME_START == '' ){
         $time ='xx:xx'.' - '.$acara[0]->TIME_END;
      }elseif($detail_notulen->TIME_START != '' && $detail_notulen->TIME_END == '')
      {
         $time =$detail_notulen->TIME_START.' - '.'xx:xx';
       }else{
           $time ='xx:xx'.' - '.'xx:xx';
       }

 #Tempat
 $Tempat = $header_notulen->ROOM != '' ? $model->ROOM : Yii::t('app','---------------');

 #Materi Rapat
 $Materi = $header_notulen->title != '' ? $header_notulen->title : Yii::t('app','---------------');

 # Susunan Acara
 $Susunan_acra = $detail_notulen->SCHEDULE != '' ? $detail_notulen->SCHEDULE : Yii::t('app','---------------');

 #Hasil Rapat
 $Hasil_rapat = $detail_notulen->RESULT_SCHEDULE != '' ? $detail_notulen->RESULT_SCHEDULE : Yii::t('app','---------------');


?>
<div id='body-notulen'>
<!--<div class="fold">-->
	<!-- Tema  -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="row" style="margin-top:10px;margin-left:1px;margin-right:10px;">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<?php echo Html::img('http://lukisongroup.com/img_setting/kop/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-center">
				<!-- <h5 class="text-left"><b>FORM PERMINTAAN BARANG & JASA</b></h5> !-->
				<h4 class="text-center" style="padding-top:30px"><b>NOTULEN RAPAT</b></h4>
			</div>			
			
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">			
				<div style="padding-top:0px;">
					<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
					<hr style="height:1px;margin-top: 1px; margin-bottom: 10px;">
				</div>
			</div>
		</div>
	</div>
	<!-- header -->
	<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
		<div class="row" style="margin-left:1px;padding-top:10px">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  style="margin-left:0;">
				<dl>
				<!-- tanggal -->
				  <dt style="width:150px; float:left;">Tanggal</dt> 
				  <dd style="">: <?=Yii::$app->formatter->format($header_notulen->start, 'date') ?></dd>
				  <!-- waktu -->
				  <dt style="width:150px; float:left;">Waktu</dt>
				  <dd style="">: <?=Yii::$app->formatter->format($header_notulen->start, 'time')." - ".Yii::$app->formatter->format($header_notulen->end, 'time')?>
				  </dd>
					<!-- tempat -->
						<dt style="width:150px; float:left;">Tempat</dt>
						<dd style="">: <?= $header_notulen->ROOM ?></dd>
						<!-- materi rapat -->
						<dt style="width:150px; float:left;">Materi Rapat</dt>
						<dd>: <?=$Materi ?></dd>
				</dl>
				
			</div>
		</div>
		<div class="row" style="margin-left:1px;padding-top:10px">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  style="margin-left:0;">
		<?php print_r($detail_notulen->SCHEDULE)?>
			</div>
		</div>
	</div>
	
	<div  class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
			<div  class="row" style="margin-top:50px;margin-left:50px;margin-bottom:50px">
				<dl>
					<dt>Notulis,</dt>
					</dl>
					  <dl>
					  <?php
						  $ttd2 = $detail_notulen->SIGN_STT2!= 0 ? '<img style="width:80 ; height:40px;" src='.SIGNATURE_pdf2($detail_notulen->SIG2_ID).'></img>' :'No Signature';
						  //$ttd2 = $detail_notulen->SIGN_STT2!= 0 ?  '<img style="width:80 ; height:40px;" src='.SIGN_pdf2($detail_notulen->SIG2_ID).'></img>' :'No Signature';
					
						  echo $ttd2;
					  ?>
				</dl>
				<dl>
					  <?php
							$name2 = $detail_notulen->SIG2_NM != '' ? $detail_notulen->SIG2_NM : 'none' ;
							echo $name2;
					   ?>
				</dl>
			</div>
		</div>
	</div>





