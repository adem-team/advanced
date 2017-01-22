<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;


/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Notulen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notulen-form">

    <?php $form = ActiveForm::begin([
        'id'=>$model->formName(),
        // 'enableClientValidation' => true,
    ]); ?>

    <?= $form->field($model, 'SCHEDULE')->widget(CKEditor::className(), [
        'options' => ['rows' => 100],
        //'preset' => 'basic'
		'preset' =>'custom', 		
		'clientOptions' => [
			//'extraPlugins' => 'pbckcode',
			'toolbarGroups' => [
				//['name' => 'editing', 'groups' => ['tools', 'about']],
				['name' => 'editing', 'groups' => ['tools']],
				//['name' => 'document', 'groups' => ['mode', 'document', 'doctools']],
				['name' => 'document', 'groups' => ['document', 'doctools']],		
				
				['name' => 'insert'],
				'/',
				['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
				['name' => 'colors'],
				//['name' => 'links'],
				['name' => 'others'],
				//['name' => 'clipboard', 'groups' => ['mode', 'undo', 'selection', 'clipboard', 'doctools']],
				['name' => 'clipboard', 'groups' => ['undo', 'selection', 'clipboard', 'doctools']],
				['name' => 'paragraph', 'groups' => ['templates', 'list', 'indent', 'align']],
			] 
		]
    ])->label('Description') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
