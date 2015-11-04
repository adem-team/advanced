<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use lukisongroup\models\hrd\Employe;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\icons\Icon;
use kartik\widgets\Growl;

$this->sideCorp = 'PT.Lukisongroup';                        /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'admin';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'LG - Administrator');         /* title pada header page */
?>
<div class="panel panel-default" style="margin-top: 0px">
     <div class="panel-body">
		<?php	
			$Emp_MDL = Employe::find()->where(['EMP_ID'=>$model->EMP_ID])->orderBy('EMP_NM')->one();
			if (count($Emp_MDL)==0){
				$Val_Emp='none';
			}else{
				$Val_Emp=$Emp_MDL->EMP_NM;
			}			
			$attribute = [
				[
					'attribute' =>'id',
					'options'=>[
						'readonly'=>true,
					],
				],	
				[
					'attribute' =>	'username',
					'options'=>[
						'readonly'=>true,
					],					
				],				
				[
					'attribute' =>	'auth_key',
					//'inputWidth'=>'40%'
				],	
				[ // Coorporation - Author: -ptr.nov-
					'label' =>'Employe Name',
					'attribute' =>'EMP_ID',
					'format'=>'raw',
					'value'=>Html::a($Val_Emp, '#', ['class'=>'kv-author-link']),
					'type'=>DetailView::INPUT_SELECT2, 
					'widgetOptions'=>[
						'data'=>ArrayHelper::map(Employe::find()->orderBy('EMP_NM')->asArray()->all(), 'EMP_ID','EMP_NM'),
						'options'=>['placeholder'=>'Select ...'],
						'pluginOptions'=>['allowClear'=>true],
					],
				],
						
			];
			echo DetailView::widget([
				'model' => $model,				
				'condensed'=>true,
				'hover'=>true,
				'mode'=>DetailView::MODE_VIEW,
				'panel'=>[
					'heading'=>$model->username . '| '.$model->EMP_ID,
					'type'=>DetailView::TYPE_INFO,
				],	
				'attributes'=>$attribute,
				'deleteOptions'=>[
					'url'=>['delete', 'id' => $model->id],
					'data'=>[
						'confirm'=>Yii::t('app', 'Apakah Anda yakin menghapus akun :' . $model->username .' ?'),
						'method'=>'post',
					],
				],
			]);			
		?>
	</div>
</div>

