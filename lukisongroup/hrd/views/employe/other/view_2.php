<?php


use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\icons\Icon;
use kartik\widgets\Growl;

/* @var $this yii\web\View */
/* @var $model app\models\maxi\Maxiprodak */

$this->title = $model->EMP_ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maxiprodaks'), 'url' => ['prodak']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maxiprodak-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->EMP_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->EMP_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

	
    <?php
	
	/*
	echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'BRG_ID',
            'BRG_NM',
        ],
    ]);
*/


	//Bulider Standard
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_INLINE]);
	//echo Html::beginForm('', '', ['class'=>'form-horizontal']);
    echo Form::widget([
        'model'=>$model,
        'form'=>$form,
		//'formName'=>'kvform',
		//'columns'=>2,
        'attributes'=>$model->FormAttribs,
    ]);
	//echo Html::endForm();
    ActiveForm::end();
	
	//Bulider Standard
	echo Html::beginForm('', '', ['class'=>'form-horizontal']);
		/*echo Form::widget([
			'model'=>$model,
			'form'=>$form,
			//'formName'=>'kvform',
			//'columns'=>2,
			'attributes'=>$model->FormAttribs,
		]);*/
		echo Form::widget([
			//'model'=>$model,
			'formName'=>'kvform',
			'columns'=>2,
			'attributeDefaults'=>['type'=>Form::INPUT_TEXT,
				'labelOptions'=>['class'=>'col-md-4'],
				'inputContainer'=>['class'=>'col-md-7'],
				'container'=>['class'=>'form-group'],
			],
			'attributes'=>$model->FormAttribs,
		]);
		
	echo Html::endForm();
	
?>
	
	
	
	<?php
	/*	
	composer
	detail view
	form builder
	*/
	// mengunakan modal 
	//Modal::begin([
   // 'header' => '<h4 class="modal-title">Detail View Demo</h4>',
  //  'toggleButton' => ['label' => '<i class="glyphicon glyphicon-th-list"></i> Detail View in Modal', 'class' => 'btn btn-primary']
//]);
	
	
	//use kartik\builder\Form;
	//Bulider Standard
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_INLINE]);
    echo Form::widget([
        'model'=>$model,
        'form'=>$form,
		'columns'=>2,
        'attributes'=>$model->FormAttribs,
    ]);
    ActiveForm::end();
	
	//Bulder Grid
	 use kartik\builder\FormGrid;
    $form = ActiveForm::begin();
    echo FormGrid::widget([
        'model' => $model,
        'form' => $form,
        'autoGenerateColumns' => true,
        'rows' => [
            [
                'attributes' => [
                    'EMP_ID' => ['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter username...']],
                    'EMP_NM' => ['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter password...']],
                    //'rememberMe' => ['type'=>Form::INPUT_CHECKBOX],
                ],
            ],
            [
                'attributes' => [
                        'EMP_ID' => ['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter username...']],
                    'EMP_NM' => ['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter password...']],
             ]
            ]
        ]
    ]);
    ActiveForm::end();
	
	
	
	$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_INLINE]);
	echo Growl::widget([
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
	ActiveForm::end();
	
	
	 use kartik\widgets\FileInput;
	$form = ActiveForm::begin();
    echo FileInput::widget([
		'name' => 'attachment_49[]',
		'options'=>[
			'multiple'=>true
		],
		'pluginOptions' => [
			'initialPreview'=>[
				Html::img("http://placeimg.com/200/150/people/1.jpg", ['class'=>'file-preview-image', 'alt'=>'The Moon', 'title'=>'The Moon']),
				Html::img("http://placeimg.com/200/150/people/2.jpg",  ['class'=>'file-preview-image', 'alt'=>'The Earth', 'title'=>'The Earth']),
			],
			'initialPreviewConfig' => [
				'{caption: "People-1.jpg", width: "20px", url: "/site/file-delete", key: 1}',
				'{caption: "People-2.jpg", width: "20px", url: "/site/file-delete", key: 2}'
			],
			'initialCaption'=>"The Moon and the Earth",
			'overwriteInitial'=>false
		]
	]);
    ActiveForm::end();
	
	
	
	?>
</div>
