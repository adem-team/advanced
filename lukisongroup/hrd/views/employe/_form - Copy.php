<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\maxi\Maxiprodak */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maxiprodak-form">

    <?php $form = ActiveForm::begin([
		'options' => [
			//'class'=>'form-horizontal',
			//'class'=>'form-vertical',
			//'entype'=>'multipart/form-data',
		],
	]); ?>

	<?php 
	/*	
		$form = ActiveForm::begin();			= ActiveForm
		$form = ActiveForm::begin([array]);		= ActiveForm array=properties
		$form = ActiveForm::begin([				= Contoh ActiveForm with properties
		'options' => [
			//'class'=>'form-horizontal',
			//'class'=>'form-vertical',
			//'entype'=>'multipart/form-data',
		],
		
		
	*/
	?>
	
    <?php 
		/*
			== Author ptr.nov ==
			$form->field($model, 'BRG_ID')		= format field model   
			->textInput(['maxlength' => 10]) 	=Jumlah karakter yang bisa di input
			->label('MASUKIN')					= Label field input
			->hint('Please enter your ID/Name')				= Description text hint
		*/
		//Mengunakan Echo
			echo $form->field($model, 'BRG_ID');
			echo $form->field($model, 'BRG_ID')->textInput(['maxlength' => 10])->label('Label Name ')->hint('Please enter your Field');
			echo $form->field($model, 'BRG_NM')->textInput(['maxlength' => 100]);
			echo $form->field($model, 'BRG_NM')->textInput(['maxlength' => 100,'disabled'=>true])->label('Disable');
			echo $form->field($model, 'BRG_NM')->textInput(['maxlength' => 100,'disabled'=>false])->label('Enable');
		
		//TextArea
			echo $form->field($model, 'BRG_ID')->textarea()->label('Test Area');
			echo $form->field($model, 'BRG_ID')->textarea(array('rows'=>'2','cols'=>'1'))->label('Test Area Array');
		
		//Passowrd
			echo $form->field($model, 'BRG_ID')->input('password')->label('Password1');
			echo $form->field($model, 'BRG_ID')->passwordInput()->label('Password2');
		
		//Email
			echo $form->field($model, 'BRG_ID')->input('email')->label('Email');
		
		//File Upload
			echo $form->field($model, 'BRG_ID')->fileInput()->label('Upload File');
			echo $form->field($model, 'BRG_ID[]')->fileInput(['multiple'=>'multiple'])->label('Upload Multiple File ');
		
		//Check Box Button
			echo $form->field($model, 'BRG_ID')->checkbox(); //default
			echo $form->field($model, 'BRG_ID')->checkbox()->label('Check Box'); //with label and field label
			echo $form->field($model, 'BRG_ID')->checkbox(array('label'=>''))->label('Gender'); // not filed label
			//Check Box Button Label Option, Disabled, Style
			echo $form->field($model, 'BRG_ID')->checkbox(array(
																'label'=>'',
															'labelOptions' =>array('style'=>'padding:5px;'),
															'disabled'=>true															
															))->label('Gender');
		
		//Check Box List / Cheklist
			echo $form->field($model, 'BRG_ID[]')->checkboxlist(['1'=>'item 1','2'=>'item 2','3'=>'item 3',]); //default
		
		//Radio Button/ Option
			echo $form->field($model, 'BRG_ID')->radio(); //default
			echo $form->field($model, 'BRG_ID')->radio()->label('Radio'); //with label and field label
			echo $form->field($model, 'BRG_ID')->radio(array('label'=>''))->label('Gender'); // not filed label
		//Radio Button Label Option, Disabled, Style
			echo $form->field($model, 'BRG_ID')->radio(array(
															'label'=>'',
															'labelOptions' =>array('style'=>'padding:5px;'),
															'disabled'=>true															
															))->label('Gender');
		//Radio List
			echo $form->field($model, 'BRG_ID')->radioList(array('1'=>'satu','2'=>'dua'))->label('Radio Array'); 
			echo $form->field($model, 'BRG_ID')->radioList(['1'=>'satu','2'=>'dua'])->label('Radio Array'); 
		
		//List Box prompt Select
			echo $form->field($model, 'BRG_ID')->listBox(array('1'=>'1','2'=>'2',3=>3,4=>4),array('prompt'=>'select'))->label('Combo/List box');
		//List Box Size
			echo $form->field($model, 'BRG_ID')->listBox(array('1'=>'1','2'=>'2',3=>3,4=>4),array('prompt'=>'select','size'=>3))->label('Combo/List box');
		//List Box Disabled and Style
			echo $form->field($model, 'BRG_ID')->listBox(array('1'=>'1','2'=>'2',3=>3,4=>4),array('disabled'=>true,'style'=>'background:gray;color:#fff'))->label('Combo/List box');
		//List Box Style
			echo $form->field($model, 'BRG_ID')->listBox(array('1'=>'1','2'=>'2',3=>3,4=>4),array('style'=>'background:gray;color:#fff'))->label('Combo/List box');
			
		//Drop Down
			echo $form->field($model, 'BRG_ID')->dropDownList(['a'=>'Item A','b'=>'Item B','c'=>'Item C',])->label('Drop Down/Combo');
			//array variable
			$datalist=array('a'=>'Item A','b'=>'Item B','c'=>'Item C','d'=>'Item D');
			echo $form->field($model, 'BRG_ID')->dropDownList($datalist,['promp'=>'choose...',])->label('Drop Down List var/Combo');
		//Submit
		echo Html::submitButton('submit',['class'=>'btn btn-primary']);
		
		
	
		
		
		
		
		
		
		
		
		
		
		
		
		
	?>
	<?= $form->field($model, 'BRG_ID')->textInput(['maxlength' => 10])->label('?=  ')->hint('Cara PHP') ?>
	<?= $form->field($model, 'BRG_NM')->textInput(['maxlength' => 100]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php

echo DetailView::widget([
        'model' => $model,
		'mode'=>DetailView::MODE_VIEW,
        'attributes' => [
            'BRG_ID',
            'BRG_NM',
        ],
    ]);


?>
</div>

