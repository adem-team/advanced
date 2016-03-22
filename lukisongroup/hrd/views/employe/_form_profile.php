<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use kartik\markdown\MarkdownEditor;

?>

<div class="barang-form">
	<div class="row">
		<?php $form = ActiveForm::begin([
				'type' => ActiveForm::TYPE_HORIZONTAL,
				'method' => 'post',
				'action' => ['/hrd/employe/edit-profile','id'=>$model->EMP_ID],
				'id'=>'form-employe',
				'enableClientValidation' => true,
			]);
		?>
			<?php // $form->field($model, 'cabID')->hiddenInput(['value'=>1,'maxlength' => true])->label(false) ?>

			<div class="col-lg-8 pull-right">

					<?php
						echo $form->field($model, 'vCorpID')->textInput([
						'value'=>$model['corpOne']['CORP_NM'],
						'maxlength' => true,
						'readonly'=>true,
						'style'=>[
							//'width'=>'50%'
						],
					])->label('Corp');
					?>

					<?php
						echo $form->field($model, 'vKarId')->textInput([
								'value'=>$model->EMP_ID,
								'maxlength' => true,
								'readonly'=>true,
								'style'=>[
									//'width'=>'50%',
									//'float'=>'left'
								],
							])->label('Emp.Id');
					?>

				<?php

					echo $form->field($model, 'vKarNm')->textInput([
								'value'=>$model->EMP_NM,
								'maxlength' => true,
								'readonly'=>true,
								'style'=>[
									//'width'=>'30%',
									//'float'=>'right',
									//'padding-top'=>'0px'
								],
							])->label('Name');
				?>
			</div>
			<div class="col-lg-4">
				<?php
					echo Html::img(Yii::getAlias('@web').'/upload/hrd/Employee/'.$model->EMP_IMG, ['width'=>'130','height'=>'130', 'align'=>'right'])
				?>
			</div>
			<div class="col-lg-12">
				<?php



				/* echo $form->field($model, 'vCabID')->dropDownList($aryCbgID,[
					'id'=>'emp-cab',
					'prompt'=>$model->cabOne['CAB_NM'],
				])->label('Cabang'); */




     echo $form->field($model, 'EMP_KTP')->textInput(['maxlength' => true,'style'=>[
              					'width'=>'100%'
              				],])->label('Nomer KTP');



  echo $form->field($model, 'EMP_ZIP')->textInput(['maxlength' => true,'style'=>[
                            'width'=>'100%'
                          ],])->label('Emp ZIP');
                          echo $form->field($model, 'EMP_TGL_LAHIR')->widget(DatePicker::classname(), [
                              'options' => ['placeholder' => 'Enter Join date ...'],
                              'pluginEvents'=>[
                                'show' => "function(e) {show}",
                              ],
                              'pluginOptions' => [
                                  'autoclose'=>true
                              ]
                          ])->label('Birth Date');

 echo $form->field($model, 'EMP_GENDER')->radioList(['Male' => 'Male', 'Female' => 'Female'], ['separator' => '', 'tabindex' => 3]);

echo $form->field($model, 'EMP_EMAIL')->textInput(['maxlength' => true,'style'=>[
                                    'width'=>'100%'
                                  ],])->label('Email');

echo $form->field($model, 'EMP_ALAMAT')->textArea(['maxlength' => true,'style'=>[
                                                      'width'=>'100%'
                                                    ],])->label('Alamat');

			?>
			</div>
	<div  class="col-lg-12" style="text-align: right;">
			<?php echo Html::submitButton('Update',['class' => 'btn btn-primary']); ?>
		</div>

    <?php ActiveForm::end(); ?>
	</div>
</div>
