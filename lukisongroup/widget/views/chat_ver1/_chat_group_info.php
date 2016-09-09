<?php
use kartik\helpers\Html;
use yii\helpers\Url;

function add(){
		$title = Yii::t('app','');
		$options = [ 'id'=>'berita-reply-id',
			 'class'=>'btn-xs',
			 'title'=>'Back',
		];
		$icon = '<span class="fa fa-rotate-left fa-xs"> New</span>';
		$label = $icon . ' ' . $title;
		//$label = 'Reply';
		$url = Url::toRoute('/widget/chat');
		$content = Html::a($label,$url, $options);
		return $content;
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
		$url = Url::toRoute('/widget/chat');
		$content = Html::a($label,$url, $options);
		return $content;
	}

?>
<div class="box box-warning box-footer">
	<?php
		echo kembali().' '.add();
	?>
</div>