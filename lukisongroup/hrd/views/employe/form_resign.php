<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\DatePicker;

?>

<div class="barang-form">
	<div class="row">
		<?php $form = ActiveForm::begin([
				'type' => ActiveForm::TYPE_HORIZONTAL,
				'method' => 'post',
				'action' => ['/hrd/employe/resign','id'=>$model->EMP_ID],
				// 'id'=>'form-employe',
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


            echo $form->field($model, 'EMP_STS')->dropDownList($emp_sts,['prompt'=>'Select...'])->label('Status Karyawan');

            echo $form->field($model, 'EMP_RESIGN_DATE')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter Resign date ...'],
                'pluginEvents'=>[
                  'show' => "function(e) {show}",
                ],
                'pluginOptions' => [
                    'autoclose'=>true
                ]
            ])->label('Resign date');
            // echo $form->field($model, 'EMP_RESIGN_DATE')->widget(DatePicker::classname(), [
            //     'options' => ['placeholder' => 'Enter Resign date ...'],
            //     'pluginEvents'=>[
            //       'show' => "function(e) {show}",
            //     ],
            //     'pluginOptions' => [
            //         'autoclose'=>true
            //     ]
            // ])->label('Resign date');

			?>
			</div>
	<div  class="col-lg-12" style="text-align: right;">
			<?php echo Html::submitButton('Update',['class' => 'btn btn-primary']); ?>
		</div>

    <?php ActiveForm::end(); ?>
	</div>
</div>
