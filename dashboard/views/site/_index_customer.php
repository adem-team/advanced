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
							'heading' => '<div>DASHBOARD - CUSTOMER</div>',
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
							'heading' => '<b>DATA PROSESS</b>',
							'postBody' => Html::listGroup([
									[
										/* 
										 * Modul Customer - Request Order | customer request stock prodak
										*/
										'content' => 'Customer Request Order',
										'url' => '/salespromo/stock-gudang',
										'badge' => '0'
									],
									[
										/* 
										 * Modul Customer - Stock Gudang | Input Confirmasi pembayaran customer customer || Attach upload -> bukti pembayaran
										*/
										'content' => 'Customer Payment',
										'url' => '/salespromo/stock-promo',
										'badge' => '0'
									],
									[
										/* 
										 * Modul Customer - Stock Penjualan | input Penjualan langsung dari Customer
										*/
										'content' => 'Customer Input Penjualan',
										'url' => '/salespromo/penjualan',
										'badge' => '0'
									],
									[
										/* 
										 * Modul Sales Promotion - Stock Penjualan | input Stock langsung dariCustomer
										*/
										'content' => 'Customer Input Stock',
										'url' => '/salespromo/penjualan-promo',
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
							'heading' => '<b>WIDGET</b>',
							'postBody' => Html::listGroup([
									[
										/* 
										 * Modul Sales Promotion | jadwal kunjungan ke cusotmer
										*/
										'content' => 'Jadwal Kunjungan',
										'url' => '/salespromo/schadule',
										'badge' => '0'
									],
									[
										/* 
										 * Modul Sales Promotion | Peta posisi alamat customer yang akan di kunjungi, check validasi kunjungan Porsquare
										*/
										'content' => 'Peta Customer',
										'url' => '/salespromo/customer-map',
										'badge' => '0'
									],									
									[
										/* 
										 * Modul Customer | Sacustomer Profile Pribadi | change password Account
										*/
										'content' => 'Profile',	
										'url' => '/salespromo/profile',
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
							'heading' => '<b>REPORTING</b>',
							'postBody' => Html::listGroup([
									[
										/* 
										 * Modul Customer | Customet lihat prodak esm |yang paling banyak laku dan lain2|
										*/
										'content' => 'Prodak',
										'url' => '/salespromo/prodak',
										'badge' => '0'
									],	
									[
										/* 
										 * Modul Customer| Reporting pejualan harian semua sales promotion [Topdaily|BottemDaily]
										*/
										'content' => 'Penjualan Harian',
										'url' => '/salespromo/report-daily',
										'badge' => '0'
									],									
									[
										/* 
										 * Modul Customer | Reporting pejualan bulanan semua sales promotion [Topdaily|BottemDaily]
										*/
										'content' => 'Penjualan Bulanan',
										'url' => '/salespromo/report-monthly',
										'badge' => '0'
									],
									[
										/* 
										 * Modul Customer | Reporting pejualan tahunan semua sales promotion [Topdaily|BottemDaily]
										*/
										'content' => 'Penjualan perTahun',
										'url' => '/salespromo/report-monthly',
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