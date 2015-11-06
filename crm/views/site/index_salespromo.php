<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use kartik\builder\FormGrid;
use kartik\tabs\TabsX;
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,'options'=>['enctype'=>'multipart/form-data']]);
$ProfAttribute1 = [
    [
        'label'=>'',
        'attribute' =>'EMP_IMG',
        'value'=>Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$model->EMP_IMG,
        //'group'=>true ,
        //'groupOptions'=>[
        //	'value'=>Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$model->EMP_IMG,
        //],
        'format'=>['image',['width'=>'auto','height'=>'auto']],
        //'inputWidth'=>'20%'
        //'inputContainer' => ['class'=>'col-md-1'],
    ],
];
$this->title = 'Workbench CRM <i class="fa  fa fa-coffee"></i> ' . $model->EMP_NM . ' ' . $model->EMP_NM_BLK .'</a>';
$prof=$this->render('login_index/_info', [
    'model' => $model,
	'dataProvider' => $dataProvider,
]);
$EmpDashboard=$this->render('login_index/_dashboard', [
    'model' => $model,
]);
?>

<div class="container-fluid" style="padding-left: 20px; padding-right: 20px" >
		<div class="row">
					<?php
					echo Html::panel(
						[
							'heading' => '<div></div>',
							'body'=>$prof,
						],
						Html::TYPE_INFO
					);
					?>
		</div>
       <div class="row" >
			<div class="col-xs-12 col-sm-6 col-dm-4  col-lg-4">
				<?php
					echo Html::panel([
							'id'=>'home1',
							'heading' => 'Data Prosess',
							'postBody' => Html::listGroup([
									[
										'content' => 'Entry Stock Penjualan',
										'url' => '/salespromo/sales-daily',
										'badge' => '0'
									],
									[
										'content' => 'Entry Stock Gudang',
										'url' => '/salespromo/stock-daily',
										'badge' => '0'
									],
									[
										'content' => 'Jadwak Kunjungan',
										'url' => '/salespromo/schadule',
										'badge' => '0'
									],
									[
										'content' => 'Peta Customer',
										'url' => '/salespromo/customer-map',
										'badge' => '0'
									],
								]),
						],
						Html::TYPE_INFO
					);
				?>
			</div>
			<div class="col-xs-12 col-sm-6 col-dm-4  col-lg-4" >
				
				<?php
					echo Html::panel([
							'id'=>'home1',
							'heading' => 'Penjualan Terbanyak',
							'postBody' => Html::listGroup([
									[
										'content' => 'Penjualan perHarian',
										'url' => '/salespromo/top-daily',
										'badge' => '0'
									],									
									[
										'content' => 'Penjualan perBulanan',
										'url' => '/salespromo/top-monthly',
										'badge' => '0'
									],
									[
										'content' => 'Penjualan perTahun',
										'url' => '/salespromo/top-monthly',
										'badge' => '0'
									]
								]),
						],
						Html::TYPE_INFO
					);
				?>
			</div>
			<div class="col-xs-12 col-sm-6 col-dm-4  col-lg-4" >
			<?php
					echo Html::panel([
							'id'=>'home1',
							'heading' => 'Lows Sales',
							'postBody' => Html::listGroup([
									[
										'content' => 'Penjualan perHarian',
										'url' => '/salespromo/low-daily',
										'badge' => '0'
									],
									[
										'content' => 'Penjualan perBulanan',
										'url' => '/salespromo/low-monthly',
										'badge' => '0'
									],	
									[
										'content' => 'Penjualan perTahun',
										'url' => '/salespromo/low-yearly',
										'badge' => '0'
									]
								]),
						],
						Html::TYPE_INFO
					);
				?>
				
			</div>
		</div>
 </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
    </body>
    </html>
<?php ActiveForm::end(); ?>