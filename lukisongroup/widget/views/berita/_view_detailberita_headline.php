<?php
use kartik\helpers\Html;
use yii\helpers\Url;
use dosamigos\gallery\Gallery;
use kartik\grid\GridView;



$explode = explode('-', $model->JUDUL);

	//print_r($dataProviderImageHeader);
	//print_r($dataProviderImageHeader->getModels());
	/*
	 * @author : wawan
     * @since 1.0
	*/
	function berita_reply($model){
		$title = Yii::t('app','');
		$options = [ 'id'=>'berita-reply-id',
			 'data-toggle'=>"modal",
			 'data-target'=>"#berita-reply-id-join",
			 'class'=>'btn-xs',
			 'title'=>'Reply',
		];
		$icon = '<span class="fa fa-reply-all fa-xs"> Reply</span>';
		$label = $icon . ' ' . $title;
		//$label = 'Reply';
		$url = Url::toRoute(['/widget/berita/join-comment','KD_BERITA'=>$model->KD_BERITA]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	if($model->STATUS == 0){
		$btnreply = "";
	}else{
		$btnreply = berita_reply($model);
	}

	function Add_close($model){
		$title = Yii::t('app','');
		$options = [ 'id'=>'berita-isi-id-close',
			   'data-pjax' => true,
			   'data-toggle-close'=>$model->KD_BERITA,
			   'class'=>'btn-xs',
		];
		$icon = '<span class="glyphicon glyphicon-remove-sign"style="color:red">Close</span>';
		$label = $icon . ' ' . $title;
		$content = Html::a($label,'', $options);
		return $content;
	}
	if($model->CREATED_BY != $id ){
		$btnclose = "";
	}else{
		$btnclose = Add_close($model);
	}

	function kembali(){
		$title = Yii::t('app','');
		$options = [ 'id'=>'berita-back-id',
			 'class'=>'btn-xs',
			 'title'=>'Back',
		];
		$icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
		$label = $icon . ' ' . $title;
		//$label = 'Reply';
		$url = Url::toRoute('/widget/berita');
		$content = Html::a($label,$url, $options);
		return $content;
	}


	function kembali_visit(){
		$title = Yii::t('app','');
		$options = [ 'id'=>'berita-back-id-issue',
			 'class'=>'btn-xs',
			 'title'=>'Back',
		];
		$icon = '<span class="fa fa-rotate-left fa-xs"> Back issue</span>';
		$label = $icon . ' ' . $title;
		//$label = 'Reply';
		$url = Url::toRoute('/master/review-visit');
		$content = Html::a($label,$url, $options);
		return $content;
	}

	/*
	 * Tombol Edit keterangan
	*/
	function tombolEditketerangan($model){
		$title = Yii::t('app', '');
		$options = ['id'=>'edit-keterangan',
					'data-toggle'=>"modal",
					'data-target'=>"#keterangan",
					'class'=>'btn btn-info btn-xs',
		];
		$icon = '<span class="glyphicon glyphicon-save"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/widget/berita/set-keterangan','id'=>$model->KD_BERITA]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

  /* button print next print-berita-acara */
  $print = Html::a('<i class="fa fa-print fa-fw fa-xs"></i> Print', ['print-berita-acara','kd_berita'=>$model->KD_BERITA], ['target' => '_blank', 'class' => 'btn btn-success btn-xs','style'=>['width'=>'90px']]);



	/*Image Header*/
	// $headerImage=GridView::widget([
	// 	'id'=>'img-header',
  //       'dataProvider' => $dataProviderImageHeader,
	// 	//'filterModel' => $searchModelImage,
  //       'columns' => $aryFieldHeaderX,
	// 	'pjax'=>true,
  //       'pjaxSettings'=>[
  //           'options'=>[
  //               'enablePushState'=>false,
  //               'id'=>'img-header',
  //              ],
  //       ],
	// 	'summary'=>false,
	// 	'toolbar'=>false,
	// 	'panel'=>false,
	// 	'hover'=>true, //cursor select
	// 	'responsive'=>true,
	// 	'responsiveWrap'=>true,
	// 	'bordered'=>false,
	// 	'striped'=>false,
  //   ]);



 ?>
<head>
	<style type="text/css">
		.blueimp-gallery > .slides > .slide > .text-content {
			overflow: auto;
			margin: 60px auto;
			padding: 0 60px;
			max-width: 920px;
			text-align: left;
		}
		.piter-chat1-text:after {
		  border-width: 5px;
		  margin-top: -5px;
		}
		.piter-chat1-text:before {
		  border-width: 6px;
		  margin-top: -6px;
		}
	</style>
</head>
<div class='' style="margin-top:40px;font-family: tahoma ;font-size: 10pt;">
	<!-- HEADER JUDUL/ISI/ATTACH ptr.nov-->
	<div class="box box-success direct-chat direct-chat-success">
		 <!-- box-header -->
		<div class="box-header with-border">
			<h3 class="box-title"><?=$model->JUDUL?></h3>
			<div class="box-tools pull-right">
				<!--<span data-toggle="tooltip" title="3 New Messages" class="badge bg-green">3</span>-->
				<button class="btn btn-box-tool" data-toggle="tooltip" title="show/hide" data-widget="collapse"><i class="fa fa-minus"></i></button>
				<button class="btn btn-box-tool" data-toggle="tooltip" title="Attach" data-widget="chat-pane-toggle"><i class="fa fa-picture-o"></i></button>
				<!-- <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
			</div>
		</div><!-- /.box-header -->
		<div class="box-body">
			<!-- Conversations are loaded here -->
			<div class="direct-chat-messages">
        <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"  style="margin-left:0;">
        <dl>
          <dt style="width:150px; float:left;">No</dt>
          <dd style="color:rgba(87, 163, 247, 1)">:<b> <?= $model->KD_BERITA ?></b></dd>

          <dt style="width:150px; float:left;">Tanggal</dt>
          <dd>: <?php echo  $tanggal =substr($model->CREATED_ATCREATED_BY,0,10);?></dd>
        </dl>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"  style="margin-right:0;">
        <dl>
          <dt style="width:150px; float:left;">Kode Ref</dt>
          <dd style="color:rgba(87, 163, 247, 1)">:<b> <?php  echo $kd_ref = count($model->KD_REF) != 0? $model->KD_REF.' -'.$explode[1]: "xxx-xxx-xx" ;?></b></dd>

          <dt style="width:150px; float:left;">Jam</dt>
          <dd>: <?php echo $jam ?></dd>
        </dl>
        </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <dl>
              <dt style="width:150px; float:left;">Peristiwa/Kejadian</dt>
              <dd style="color:rgba(87, 163, 247, 1)">:<b> <?php echo $peristiwa = $model->ISI != ""? $model->ISI : "--------------" ?></b></dd>
            </dl>

        </div>
      </div>

      

      <div class="row">
        <div class="col-sm-12">
          <dl>
            <dt style="width:150px; float:left;">Keterangan</dt>
            <dd style="color:rgba(87, 163, 247, 1)">:<b> <?php echo $keterangan =  $model->DATA_ALL!= ""?$model->DATA_ALL:"-------------"; ?></b><?= tombolEditketerangan($model)?></dd>
          </dl>

      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <dl>
          <dt style="float:left;">Tangerang,<?php echo $date = date("d M Y",strtotime($model->CREATED_ATCREATED_BY)); ?></dt><br>
          <dt style="float:left;">Dibuat Oleh,</dt>
        </dl>
        <dl>
          <?php
            $ttd1 = $ttd!='' ?  '<img style="width:80; height:40px" src='.$ttd.'></img>' :"";
            echo $ttd1;
          ?>
        </dl>
        <dl>
          <?php
            echo $emp_nm
           ?>
        </dl>

    </div>
  </div>
				<!-- Message. Default to the left -->
				<!-- <div> -->
				<!-- </div> -->


				<?php
					// echo $model->ISI;
				?>
				<!-- Message to the right -->
			</div><!--/.direct-chat-messages-->
			<!-- Contacts are loaded here -->
			<div class="direct-chat-contacts">
				<ul class="contacts-list">
					<li>
						<?php

							//echo $headerImage;
							echo $itemHeaderAttach;
						?>
					</li><!-- End Contact Item -->
				</ul><!-- /.contatcts-list -->
			</div><!-- /.direct-chat-pane -->
		</div><!-- /.box-body -->
			<div>
			<?php
							//echo $itemHeaderAttach;
			?>
			</div>
			<div>
				<?php
							//echo $itemDetailAttach;

						// echo Html::panel(
							// [
								// 'id'=>'ad',
								//'heading' => '<div>Attach</div>',
								// 'body'=>$itemHeaderAttach,
							// ],
							// Html::TYPE_INFO
						// );
					?>
			</div>
	</div><!--/.direct-chat -->

	<!-- REPLAY DETAIL ptr.nov-->
	<div>
    <?php
			echo kembali().' '.kembali_visit().' '.$btnreply.''.$btnclose.''.$print;
		?>
	</div>
	<div>
		<?php
			// echo $btnclose;
		?>
	</div>
	<div class="piter-chat1-text">
	</div>
</div>



