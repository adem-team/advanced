<?php
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

use yii\widgets\Breadcrumbs;

/* TABLE CLASS DEVELOPE -> |DROPDOWN,PRIMARYKEY-> ATTRIBUTE */
use app\models\hrd\Dept;
/*	KARTIK WIDGET -> Penambahan componen dari yii2 dan nampak lebih cantik*/
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;

//use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
//AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/

$this->sideCorp = 'LG Widget';                                   /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'mdefault';                           /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Email');     /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;          /* belum di gunakan karena sudah ada list sidemenu, on plan next*/
	$docHelpArray= [
		  ['ID' => 0, 'DESCRIP' => 'Purchasing'],		  
		  ['ID' => 1, 'DESCRIP' => 'HRM'],
	];	
	$valHelp = ArrayHelper::map($docHelpArray, 'ID', 'DESCRIP');
?>
<div class="content" style="font-family: verdana, arial, sans-serif ;font-size: 9pt";>
	<div class="row">
		<div class="col-md-12">
			<h4 class="text-center"><b>LUKISONGROUP GUIDE</b></h4>
			<hr/>
		</div>
	</div>

	<div class="row">
		
				<?php $form = ActiveForm::begin();?>		
				<div class="col-xs-12 col-md-3">
					<?php echo $form->field($model, 'NAME')->widget(Select2::classname(), [
									'data' => $valHelp,									
									'options' => ['placeholder' => 'Select Helper ...'],
									'pluginOptions' => [
									
										'allowClear' => true
									],
									'options'=>[
										
									]
							])->label(false);
					?>	
					<hr/>					
				</div>
				<div class="col-xs-12 col-md-9">
					<?php //echo Html::submitButton('login',['class' => 'btn btn-primary']);?>
				</div>
				<?php ActiveForm::end();?>	
			
		
	</div>
	<div class="row">
		<div class="col-xs-12 col-md-12">			
			<?php include('puchasing.php');?>		
		</div>	
	</div>
</div>
