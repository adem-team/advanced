<?php
use kartik\helpers\Html;
use yii\helpers\Url;

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
 ?>
<div class='box-footer box-comments' style="margin-top:10px;font-family: tahoma ;font-size: 10pt;">
	<?php
		echo $model->ISI; 
	?>
</div>
<div class='box box-primary box-footer ' style="margin-top:10px;font-family: tahoma ;font-size: 10pt;">
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
</div>
