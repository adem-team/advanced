
<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use app\models\system\user\UserloginSearch;



use lukisongroup\assets\HomeWorkbench;  	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
HomeWorkbench::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/






/* @var $this yii\web\View */
if (!Yii::$app->user->isGuest) {
    $ModelUserAttr = UserloginSearch::findUserAttr(Yii::$app->user->id)->one();
    $MainAvatar =  $ModelUserAttr->emp->EMP_IMG;
    $EmployeeName = $ModelUserAttr->emp->EMP_NM . ' '. $ModelUserAttr->emp->EMP_NM_BLK;
};
$this->title = 'Workbench <i class="fa  fa fa-coffee"></i> ' . $EmployeeName .'</a>';

	$attribute = [
			[
				'attribute' =>	'EMP_IMG' ,
				'label'=>'',//'Picture',				
				'value'=>Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$model->EMP_IMG,
				//'group'=>true ,
				//'groupOptions'=>[
				//	'value'=>Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$model->EMP_IMG,
				//],
				'format'=>['image',['width'=>'150','height'=>'120']],
				'type' => DetailView::INPUT_FILEINPUT,
				'widgetOptions'=>[
							'pluginOptions' => [
								'showPreview' => true,
								'showCaption' => false,
								'showRemove' => false,
								'showUpload' => false
							],
						
				],				
			],
			[
			'label'=>'',
			//'attribute' =>	'EMP_NM',
            'value'=> $model->EMP_NM . ' ' .$model->EMP_NM_BLK
			//'inputWidth'=>'40%'					
		    ],
            [
                'attribute' =>	'EMP_JOIN_DATE',
                'format'=>'date',
                'type'=>DetailView::INPUT_DATE,
                'widgetOptions'=>[
                    'pluginOptions'=>['format'=>'yyyy-mm-dd']
                ],
                //'inputContainer' => ['class'=>'col-sm-3'],
                //'inputWidth'=>'40%'
            ],
	];

$form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]);

	$empProfile= DetailView::widget([
		'model' => $model,
		'condensed'=>true,
		//'hover'=>true,
		//'mode'=>DetailView::MODE_VIEW,
		/*
		'panel'=>[
			'heading'=>$model->EMP_NM . ' '.$model->EMP_NM_BLK,
			'type'=>DetailView::TYPE_INFO,
		],
		*/		
		'attributes'=>$attribute,
		'bordered'=>false,
		'striped' => true,
		//'options'=>[
		//'hAlign' => self::ALIGN_RIGHT,
				
		//],
		
		
	]);		
ActiveForm::end();	
?>




<div class="panel panel-default" style="margin-top: 0px">

    <div class="panel-body">
		<div class="dashboard-view">
			<div class="col-lg-3">
				<?php
					 echo Html::listGroup([
					 [
					   'content' => 'Welcome : Piter Novian',
					   'url' => '#',
					   'badge' => '',
					   'active' => true
					 ],
					 [
					   'content' => $empProfile,
					   
					 ],					 
				  ]);     
			    ?>
		</div>
		<div class="col-lg-3">
				<?php
					 echo Html::listGroup([
					 [
					   'content' => 'Employe Task',
					   'url' => '#',
					   'badge' => '14',
					   'active' => true
					 ],
					 [
					   'content' => 'Open Purchase Order',
					   'url' => '#',
					   'badge' => '2'
					 ],
					 [
					   'content' => 'Stock Warehouse',
					   'url' => '#',
					   'badge' => '5'
					 ],
                     [
                         'content' => 'Request Order',
                         'url' => '#',
                         'badge' => '8'
                     ],
                     [
                         'content' => 'Jobs Request',
                         'url' => '#',
                         'badge' => '3'
                     ],
				  ]);     
				?>            
			</div>
		</div>
</div>
<div class="site-index">
    <div class="body-content" style="padding-left: 5px; padding-right: 5px">
      <div class="row">
            <div class="col-lg-4">
				<?php
					echo Html::panel([
						'id'=>'home1',
						'heading' => 'Standar Kerja',
						'body' => 'Standar kinerja (performance standards) adalah persyaratan tugas, fungsi atau perilaku yang ditetapkan oleh pemberi kerja sebagai sasaran yang harus dicapai oleh seorang karyawan',
						'postBody' => Html::listGroup([
							   [
								   'content' => 'Standar Kerja :',
								   'url' => '#',
								   'badge' => '14'
							   ],
							   [
								   'content' => 'Standar Kerja dua',
								   'url' => '#',
								   'badge' => '2'
							   ],

						   ]),
					],	
					Html::TYPE_INFO
					);				
				?>
            </div>
            <div class="col-lg-4">
				<?php
					echo Html::panel([
						'id'=>'home2',
						'heading' => 'JobsDesk',
						'body' => 'merupakan panduan dari perusahaan kepada karyawannya dalam menjalankan tugas. ' .
                               'Semakin jelas job description yang diberikan, maka semakin mudah bagi karyawan untuk melaksanakan tugas sesuai dengan tujuan perusahaan, ' .
							   'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
						'postBody' => Html::listGroup([
							   [
								   'content' => 'JobsDesk1 :',
								   'url' => '#',
								   'badge' => '14'
							   ],
							   [
								   'content' => 'JobsDesk2 :',
								   'url' => '#',
								   'badge' => '2'
							   ],
							   [
								   'content' => 'JobsDesk3',
								   'url' => '#',
								   'badge' => '1'
							   ],
						   ]),
					],	
					Html::TYPE_INFO
					);				
				?>
            </div>
            <div class="col-lg-4">
				<?php
					echo Html::panel([
						'id'=>'home3',
						'heading' => 'SOP',
						'body' => 'SOP (Standard Operating Procedures) adalah panduan hasil kerja yang diinginkan serta proses kerja yang harus dilaksanakan.' .
                                  'SOP dibuat dan di dokumentasikan secara tertulis yang memuat prosedur (alur proses) kerja secara rinci dan sistematis.',
						'postBody' => Html::listGroup([
							   [
								   'content' => 'SOP 1 :',
								   'url' => '#',
								   'badge' => '14'
							   ],
							   [
								   'content' => 'SOP 2',
								   'url' => '#',
								   'badge' => '2'
							   ],
							   [
								   'content' => 'SOP 3',
								   'url' => '#',
								   'badge' => '1'
							   ],
						   ]),
					],	
					Html::TYPE_INFO
					);				
				?>                
            </div>
        </div>
    </div>
</div>
