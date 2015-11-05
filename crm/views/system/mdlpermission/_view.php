<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use lukisongroup\models\system\user\Userlogin;
use lukisongroup\models\system\erpmodul\Modulerp;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\icons\Icon;

$this->sideCorp = 'PT.Lukisongroup';                        /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'admin';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ERP - Administrator');        /* title pada header page */
$username=Userlogin::find()->where(['id'=>$model->USER_ID])->one();
$vUser=$username->username;
$MODUL_NM=Modulerp::find()->where(['MODUL_ID'=>$model->MODUL_ID])->one();
$vModul=$MODUL_NM->MODUL_NM;
?>
 
    <?php 
		$attribute = [
			'ID',
				[
					// Coorporation - Author: -ptr.nov-
					'label'=>'UserName',
					'attribute' =>'USER_ID',
					'format'=>'raw',
					'value'=>Html::a($vUser),						
					'type'=>DetailView::INPUT_SELECT2, 
					'widgetOptions'=>[
						'data'=> ArrayHelper::map(Userlogin::find()->asArray()->all(), 'id','username'),
						'options'=>['placeholder'=>'Select ...'],
						'pluginOptions'=>['allowClear'=>true],
						],
				],
				[
					// Coorporation - Author: -ptr.nov-
					'label'=>'MODUL ERP',
					'attribute' =>'MODUL_ID',
					'format'=>'raw',
					'value'=>Html::a($vModul),						
					'type'=>DetailView::INPUT_SELECT2, 
					'widgetOptions'=>[
						'data'=> ArrayHelper::map(Modulerp::find()->asArray()->all(), 'MODUL_ID','MODUL_NM'),
						'options'=>['placeholder'=>'Select ...'],
						'pluginOptions'=>['allowClear'=>true],
						],
				],
				'STATUS',
				'CREATE',
				'EDIT',
				'TOMBOL1',
				'TOMBOL2',
				'TOMBOL3',
				'TOMBOL4',
				'TOMBOL5',
				'TOMBOL6',
				'TOMBOL7',
				'TOMBOL8',
				'TOMBOL9',
				'TOMBOL10',	
		];
?>
</div class="body-content">
	<div class="col-sm-3"> </div> 
		<div class="col-sm-5">  
			<?php
				$form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]);
					$grd1= DetailView::widget([
								'model' => $model,
								'condensed'=>true,
								'hover'=>true,
								'mode'=>DetailView::MODE_VIEW,
								'panel'=>[
									'heading'=>'Permissio Request Order',
									'type'=>DetailView::TYPE_INFO,
								],	
								'attributes' => $attribute
							]);
							
					Modal::begin([
						
						'id' => 'ro_permission_view',
					]);
						echo $grd1; // refer the demo page for widget settings
					Modal::end();
				ActiveForm::end();
			?>
		</div>
	</div>
</div>
