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
				'action' => ['/hrd/employe/edit-titel','id'=>$model->EMP_ID],
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




				/* echo $form->field($model, 'vCabID')->dropDownList($aryCbgID,[
					'id'=>'emp-cab',
					'prompt'=>$model->cabOne['CAB_NM'],
				])->label('Cabang'); */


				echo $form->field($model, 'EMP_NM')->textInput(['maxlength' => true,'style'=>[
								'width'=>'100%'
							],])->label('Nama');
				//CABANG -> Source Generate code  Compponen


				//echo $form->field($model, 'KAR_NM')->textInput(['maxlength' => true])->label('Nama');

				//INPUT FILE IMAGE
				  // $form->field($model, 'image')->widget(FileInput::classname(), [
					// 	'options'=>['accept'=>'image/*'],
					// 	'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]
					// ]);
          // echo $form->field($model, 'EMP_NM')->textInput(['maxlength' => true,'style'=>[
          //         'width'=>'100%'
          //       ],])->label('Nama');
          // $datacorp = $this->aryCorpID();
          // print_r($datacorp);
          // die();

          // echo $form->field($model, 'EMP_CORP_ID')->widget(Select2::classname(), [
          //     'data' => $datacorp,
          //     'options' => ['placeholder' => 'Select a state ...'],
          //     'pluginOptions' => [
          //           'allowClear' => true
          //           ],
          //       ]);
          echo $form->field($model, 'EMP_CORP_ID')->dropDownList($datacorp,['prompt'=>'Select...'])->label('Corp');
          // echo $form->field($model, 'DEP_ID')->widget(Select2::classname(), [
          //       'data' => $datadep,
          //       'options' => ['placeholder' => 'Select...'],
          //           'pluginOptions' => [
          //                 'allowClear' => true
          //                 ],
          //             ]);
        echo $form->field($model, 'DEP_ID')->dropDownList($datadep,['prompt'=>'Select...'])->label('Departement');

          echo $form->field($model, 'DEP_SUB_ID')->widget(DepDrop::classname(), [
              'options' => ['placeholder' => 'Select ...'],
              // 'type' => DepDrop::TYPE_SELECT2,
              // 'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
              'pluginOptions'=>[
                'depends'=>['employe-dep_id'],
                'url' => Url::to(['/hrd/employe/subdept']),
                'loadingText' => 'Loading ...',
              ]
            ])->label('Sub Departement');
// echo $form->field($model, 'GF_ID')->widget(Select2::classname(), [
//       'data' => $aryGrpFnc,
//       'options' => ['placeholder' => 'Select...'],
//           'pluginOptions' => [
//                 'allowClear' => true
//                 ],
//             ]);
            echo $form->field($model, 'GF_ID')->dropDownList(
            $aryGrpFnc,
            ['prompt'=>'Select...'])->label('Group Function');

            // echo $form->field($model, 'SEQ_ID')->widget(Select2::classname(), [
            //       'data' => $arySeqID,
            //       'options' => ['placeholder' => 'Select...'],
            //           'pluginOptions' => [
            //                 'allowClear' => true
            //                 ],
            //             ]);
            echo $form->field($model, 'SEQ_ID')->dropDownList($arySeqID,['prompt'=>'Select...'])->label('Group Sequen');
            echo $form->field($model, 'JOBGRADE_ID')->widget(DepDrop::classname(),
                      ['options' => ['placeholder' => 'Select ...'],
                            // 'type' => DepDrop::TYPE_SELECT2,
                            // 'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                        'pluginOptions'=>[
                              'depends'=>['employe-gf_id','employe-seq_id'],
                              'url' => Url::to(['/hrd/employe/grading']),
                              'loadingText' => 'Loading ...',
                            ]
                        ])->label('Grading Karyawan');

              // echo $form->field($model, 'EMP_STS')->widget(Select2::classname(), [
              //       'data' => $emp_sts,
              //       'options' => ['placeholder' => 'Select...'],
              //           'pluginOptions' => [
              //                 'allowClear' => true
              //                 ],
              //             ]);
            echo $form->field($model, 'EMP_STS')->dropDownList($emp_sts,['prompt'=>'Select...'])->label('Status Karyawan');

            echo $form->field($model, 'EMP_JOIN_DATE')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter Join date ...'],
                'pluginEvents'=>[
                  'show' => "function(e) {show}",
                ],
                'pluginOptions' => [
                    'autoclose'=>true
                ]
            ])->label('Join date');
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
