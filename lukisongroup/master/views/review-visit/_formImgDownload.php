<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>$model->formName(),
				//'enableClientValidation' => true,
				'method' => 'post',
				'action' => ['/master/review-visit/download-image'],
		]);
	?>	
	<?=$form->field($model, 'pathDes')->fileInput(['value'=>'files1','id'=>'files1','directory'=>'directory','webkitdirectory'=>'webkitdirectory','multiple'=>''])->label('Path'); ?>
	<form><input type="button" value="Download Now" onClick="window.location.href='yourpage.html'"></form>	
	<div style="text-align: right;"">
		<?php echo Html::submitButton('Submit',['class' => 'btn btn-primary','onclick'=>'javascript:SavePath()']); ?>
	</div>

    
	<?php ActiveForm::end(); ?>	
<?php
 $this->registerJs("	
if (document.getElementById('files1').value==''){  
          var fileVal=document.getElementById('files1');
		  alert(fileVal.value);
};
     ",$this::POS_READY);

?>


