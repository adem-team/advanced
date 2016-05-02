<?php
//use yii\helpers\Html;
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use kartik\markdown\Markdown;

use lukisongroup\hrd\models\Corp;
use lukisongroup\hrd\models\Dept;
use lukisongroup\hrd\models\Deptsub;
use lukisongroup\hrd\models\Groupfunction;
use lukisongroup\hrd\models\Groupseqmen;
use lukisongroup\hrd\models\Jobgrade;
use lukisongroup\hrd\models\Status;
use lukisongroup\hrd\models\Employe;
use yii\helpers\Url;
use kartik\widgets\DepDrop;

//use lukisongroup\models\system\side_menu\M1000;
//use kartik\sidenav\SideNav;

?>

  <?php
$form = ActiveForm::begin([
		'type'=>ActiveForm::TYPE_VERTICAL,
		'options'=>['enctype'=>'multipart/form-data'],
		'id'=>'emp-form1-create',
		'enableClientValidation' => true,
	]);

//$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
//$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
/*Author: -ptr.nov- Generate digit EMP_ID */

/*Get Id count Author:-ptr.nov-*/
//$cnt= (Employe::find()->count())+1;

/*get ID Sparator Array , Author: -ptr.nov-*/
//$sql = 'SELECT max(EMP_ID) as EMP_ID FROM a0001';
//$cnt= Employe::findBySql($sql)->one();
///$arySplit=explode('.',$cnt->EMP_ID);
//$str_id_cnt=trim($arySplit[2]);
//print_r($str_id_cnt+1);
//$id_cnt=$str_id_cnt+1;

/*Combine String and Digit Author: -ptr.nov- */
//$digit=str_pad($id_cnt,4,"0",STR_PAD_LEFT);
//$thn=date("Y");
//$nl='LG'.'.'.$thn.'.'.$digit;
/*Author: Eka Side Menu */
//$side_menu=\yii\helpers\Json::decode(M1000::find()->findMenu('hrd')->one()->jval);
?>

    <?php
  echo $form->field($model, 'image')->widget(FileInput::classname(), [
    // 'options' => [
    //               ],
    'pluginOptions' => ['browseIcon'=>'<i class="glyphicon glyphicon-folder-open"></i>',
                        'overwriteInitial'=>true,
                        'showCaption' => false,
                        'showClose' => false,
                      // 'maxImageWidth'=> 300,
                      'browseLabel'=> '',
                      'removeLabel'=> '',
                      'removeIcon'=> '<i class="glyphicon glyphicon-remove"></i>',
                      'removeTitle'=> 'Cancel or reset changes',
                       'showUpload' => false,
                        'defaultPreviewContent' => '<img src="https://www.mautic.org/media/images/default_avatar.png" alt="Your Avatar" style="width:160px">'

                    ]
]);?>


<?php
$EmployeeInput= FormGrid::widget([
	'model'=>$model,
	'form'=>$form,
	'autoGenerateColumns'=>true,
	'rows'=>[
		[
            //'columns'=>2,
			//'contentBefore'=>'<div class="box box-warning box-solid "> <div class="box-header with-border ">CORPORATE IDENTITY</div></div>',
			//autoGenerateColumns'=>false,
			'columns'=>1,
			'attributes'=>[
				'employe_identity' => [
					//'columns'=>6,
					'label'=>'GENERATE CODE BY COORPORATE :',
					'attributes'=>[
						'EMP_CORP_ID'=>[

								'type'=>Form::INPUT_DROPDOWN_LIST ,
								'items'=>ArrayHelper::map(Corp::find()->orderBy('SORT')->asArray()->all(), 'CORP_ID','CORP_NM'),
								'options' => [ 'id'=>'cat-id',],
								'columnOptions'=>['colspan'=>1],
						],

					],
				],
			],
		],
		/* SUB INPUT*/
		[
			'contentBefore'=>'<legend class="text-info"><small>EMPLOYEE IDENTITY</small></legend>',
			'columns'=>1,
			'autoGenerateColumns'=>false,
			'attributes'=>[
				'employe_identity' => [
					'label'=>'Employee.ID',
					//'columns'=>5,
					'attributes'=>[
						'EMP_ID'=>[
                            'disabled'=>true,
                            'type'=>Form::INPUT_WIDGET,
                            'widgetClass'=>'kartik\widgets\DepDrop',
                            'options' => [
                                'options'=>['id'=>'subcat-id','readonly'=>true,'selected'=>false], //PR VISIBLE DROP DOWN
                                'pluginOptions'=>[
                                    'depends'=>['cat-id'],
                                    //'placeholder'=>'Select...',
                                    'url'=>Url::to(['/hrd/employe/subcat']),
                                    'initialize'=>true, //loding First //
                                    'placeholder' => false, //disable select //
                                ],

                            ],

                            'columnOptions'=>['colspan'=>3],
                        ],
                        'EMP_NM'=>[
                          'type'=>Form::INPUT_TEXT,
                          'options'=>['placeholder'=>'Enter First Name...'],
                          'columnOptions'=>['colspan'=>1],
                        ],
                        'EMP_NM_BLK'=>[
                          'type'=>Form::INPUT_TEXT,
                          'options'=>['placeholder'=>'Enter Last Name...'],
                          'columnOptions'=>['colspan'=>1],
                        ],
					]
				],
			],
		],

		/* SUB INPUT*/


		/* SUB INPUT*/
		[ //-Action Author: -ptr.nov-
			'attributes'=>[
				'actions'=>[    // embed raw HTML content
						'type'=>Form::INPUT_RAW,
						'value'=>  '<div style="text-align: right; margin-top: 20px">' .
							Html::resetButton('Reset', ['class'=>'btn btn-default']) . ' ' .
							Html::submitButton('Submit', ['class'=>'btn btn-primary']) .
							'</div>'
				],
			],
		],
	]

]);
?>

<?php
echo Html::listGroup([
	 [
		 'content' => 'IINPUT DATA KARYAWAN',
		 'url' => '#',
		 'badge' => '',
		 'active' => true
	 ],
	 [
		 'content' => $EmployeeInput,

	 ],
]);
?>


<?php
ActiveForm::end();
?>
