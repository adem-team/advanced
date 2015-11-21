<?php


use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\icons\Icon;
use kartik\widgets\Growl;
use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $model app\models\maxi\Maxiprodak */

$this->title = $model->EMP_ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maxiprodaks'), 'url' => ['prodak']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maxiprodak-view">
<?php
	
	$form = ActiveForm::begin();
    $form2;
	//$form2;
    ActiveForm::end();
	
	$form1= FileInput::widget([
		//'name' => 'attachment_49[]',
		//'options'=>[
		//	'multiple'=>true
		//],
		'model' => $model,
        'attribute' => 'EMP_ID',
		'pluginOptions' => [
			'allowedFileExtensions'=>['jpg', 'gif', 'png', 'bmp'],
			 'showUpload' => true,	
			'initialPreview'=>[
				Html::img("http://192.168.56.101/advanced/lukisongroup/web/css/image/" .$model->EMP_IMG, ['class'=>'file-preview-image', 'alt'=>'The Moon', 'title'=>'The Moon']),
				//Html::img("http://placeimg.com/200/150/people/2.jpg",  ['class'=>'file-preview-image', 'alt'=>'The Earth', 'title'=>'The Earth']),
				//Html::img("http://placeimg.com/200/150/people/2.jpg",  ['class'=>'file-preview-image', 'alt'=>'The Earth', 'title'=>'The Earth']),
			],
			'initialPreviewConfig' => [
				'{caption: "People-1.jpg", width: "20px", url: "/site/file-delete", key: 1}',
				'{caption: "People-2.jpg", width: "20px", url: "/site/file-delete", key: 2}'
			],
			//'initialCaption'=>"The Moon and the Earth",
			'overwriteInitial'=>false
		]
	]);
	//$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_INLINE]);
	$form2= Growl::widget([
	'type' => Growl::TYPE_MINIMALIST,
	'title' => 'Kartik Visweswaran',
	'icon' => 'http://placeimg.com/200/150/people/2',
	'iconOptions' => ['class'=>'img-circle pull-left'],
	'body' => 'Momentum reduce child mortality effectiveness incubation empowerment connect.',
	'showSeparator' => false,
	'delay' => 700,
	'pluginOptions' => [
		'icon_type'=>'image',
		'showProgressbar' => false,
		'placement' => [
			'from' => 'top',
			'align' => 'right',
		],
	]
	]);
	//ActiveForm::end();
	
	?>
</div>
