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
        //'attribute' =>'EMP_IMG',
        //'value'=>Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$model->EMP_IMG,
        //'group'=>true ,
        //'groupOptions'=>[
        //	'value'=>Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$model->EMP_IMG,
        //],
        'format'=>['image',['width'=>'auto','height'=>'auto']],
        //'inputWidth'=>'20%'
        //'inputContainer' => ['class'=>'col-md-1'],
    ],
];
//$this->title = 'Workbench CRM <i class="fa  fa fa-coffee"></i> ' . $model->EMP_NM . ' ' . $model->EMP_NM_BLK .'</a>';
/* $prof=$this->render('login_index/_info', [
    'model' => $model,
	'dataProvider' => $dataProvider,
]); */
$EmpDashboard=$this->render('login_index/_dashboard', [
    'model' => $model,
]);
?>

<div class="container-fluid" style="padding-left: 20px; padding-right: 20px" >
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">
					<?php
					 echo Html::panel(
						[
							'heading' => '<div>DASHBOARD - SALESMAN</div>',
							'body'=>'',//$prof,
						],
						Html::TYPE_INFO
					);
					?>
			</div>
		</div>
       <div class="row" >
			<div class="col-xs-12 col-sm-6 col-dm-4  col-lg-4">
				<?php
					echo Html::panel([
							'id'=>'home1',
							'heading' => '<b>DATA MASTER</b>',
							'postBody' => Html::listGroup([
									[
										/*
										 * Modul mastercrm - Customer  | Buka customer Baru
										*/
										'content' => 'New Customers',
										'url' => '/mastercrm/customers-crm',
										'badge' => '0'
									],
									[
										/*
										 * Modul mastercrm - Customer  |  Customer Category -> all Category Customers
										*/
										'content' => 'Customers Category',
										'url' => '/mastercrm/kategori-customers-crm',
										'badge' => '0'
									],
									[
										/*
										 * Modul Salesman - Customer  | Pengeluaran/pencairan  stock ke customer | new coustomer/repeat order
										*/
										'content' => 'City Customers',
										'url' => '/mastercrm/kota-customers-crm',
										'badge' => '0'
									],
									[
										/*
										 * Modul Salesman - Sales Promoton  | maintenance jadwal Spg | User login Spg | Absensi | Bonus
										*/
										'content' => 'Province Customers',
										'url' => '/mastercrm/provinsi-customers-crm',
										'badge' => '0'
									],
                  [
                    /*
                     * Modul Salesman - Sales Promoton  | maintenance jadwal Spg | User login Spg | Absensi | Bonus
                    */
                    'content' => 'Profile',
                    'url' => '/sistem/crm-user-profile',
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
							'heading' => '<b>DATA PROSES</b>',
							'postBody' => Html::listGroup([
									[
										/*
										 * Modul Salesman - Salesman  | maintenance jadwal kunjungan salesman
										*/
										'content' => 'Import data',
										'url' => '/salesman/import-data',
										'badge' => '0'
									],
									[
										/*
										 * Modul Salesman - IT/Admin/Salesman  | Map input
										*/
										'content' => 'Jadwal Kunjungan',
										'url' => '/salesman/schedule-header-crm',
										'badge' => '0'
									],
									[
										/*
										 * Modul Salesman - IT/Admin/Salesman  | Absensi Salesman
										*/
										'content' => 'Customers Visit Group',
										'url' => '/salesman/schedule-group-crm',
										'badge' => '0'
									],
									[
										/*
										 * Modul Salesman - Salesman  | Profile Salesman | Change Password
										*/
										'content' => 'Customers Map',
										'url' => '/mastercrm/customers-crm/crm-map',
										'badge' => '0'
									],
                  [
										/*
										 * Modul Salesman - Salesman  | maintenance jadwal kunjungan salesman
										*/
										'content' => 'Import data Customers',
										'url' => '/salesman/import-data',
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
							'heading' => '<b>REPORTING</b>',
							'postBody' => Html::listGroup([
									[
										/*
										 * Modul Salesman - Salesman | Reporting total penjualan(normal/promo) harian Under report Salesman
										*/
										'content' => 'Sales Daily',
										'url' => '/salesman/sales-daily-crm',
										'badge' => '0'
									],
									[
										/*
										 * Modul Salesman - Sales Promotion  | Reporting total Stock (normal/promo) gudang harian di customer under report Sales promotion
										*/
										'content' => 'Daily Stock Harian',
										'url' => '/salesman/sales-detail-crm',
										'badge' => '0'
									],
									[
										/*
										 * Modul Salesman - Sales Promotion  | Reporting total penjualan(normal/promo) harian bulanan report Sales promotion
										*/
										'content' => 'monthly Selling Out',
										'url' => '/salespromo/report-daily',
										'badge' => '0'
									],
									[
										/*
										 * Modul Salesman - Sales Promotion  | Reporting total Stock (normal/promo) gudang bulanan di customer under report Sales promotion
										*/
										'content' => 'monthly Stock Harian',
										'url' => '/salespromo/report-daily',
										'badge' => '0'
									],
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
