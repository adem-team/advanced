<?php
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use app\models\hrd\Dept;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;
//use scotthuangzl\googlechart\GoogleChart;
use lukisongroup\hrd\models\Employe;
use ho96\extplorer\Extplorer;






use lukisongroup\assets\AppAssetSig;  	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
AppAssetSig::register($this);
//use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
//AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/

$this->sideCorp = 'PT.Sarana Sinar Surya';                          /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'itprogrammer';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'SSS - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


?>
<div class="container" >
    <div class="row" style="padding-left: 5px; padding-right: 5px">
        <div class="col-sm-12 col-md-12 col-lg-12 ">
			<!-- EXAMPLE FORM IMPORT -->
			<?php $form = \yii\widgets\ActiveForm::begin([
				'options' => [
					'enctype'=> 'multipart/form-data',
				],
				'action' => ['import'],
			]) ?>
			<?= $form->field($modelImport,'fileImport')->fileInput() ?>
			<?= Html::submitButton('Import',['class'=>'btn btn-primary']) ?>
			<?php \yii\widgets\ActiveForm::end() ?>
			<!-- EXAMPLE FORM IMPORT -->

			<!-- EXAMPLE BUTTON EXPORT PHPEXCEL -->
			<?= Html::a('Export Excel', ['export-excel'], ['class'=>'btn btn-info']); ?>  

			<!-- EXAMPLE BUTTON EXPORT OPENTBS -->
			<?= Html::a('Export Word', ['export-word'], ['class'=>'btn btn-warning']); ?>  
			<?= Html::a('Export Excel', ['export-excel2'], ['class'=>'btn btn-info']); ?>  

			<!-- EXAMPLE BUTTON EXPORT MPDF -->
			<?= Html::a('Export PDF', ['export-pdf'], ['class'=>'btn btn-success']); ?>  
		</div>
	</div>
</div>

