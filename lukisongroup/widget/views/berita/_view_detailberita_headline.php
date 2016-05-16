<?php
use kartik\helpers\Html;
use yii\helpers\Url;
use dosamigos\gallery\Gallery;
use kartik\grid\GridView;



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
			   'class'=>'btn btn-danger btn-xs',
		];
		$icon = '<span class="glyphicon glyphicon-remove-sign">Close</span>';
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
		$options = [ 'id'=>'berita-reply-id',
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
				<!-- <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
			</div>
		</div><!-- /.box-header -->
		<div class="box-body">
			<!-- Conversations are loaded here -->
			<div class="direct-chat-messages">
				<!-- Message. Default to the left -->
				<?php
					echo $model->ISI;
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
			echo kembali().' '.$btnreply;
		?>
	</div>
	<div>
		<?php
			echo $btnclose;
		?>
	</div>
	<div class="piter-chat1-text">
		test
	</div>
</div>
