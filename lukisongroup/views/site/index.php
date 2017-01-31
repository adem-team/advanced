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
use yii\helpers\Url;
$this->title = Yii::t('app', 'lukisongroup');
use lukisongroup\assets\Profile;
Profile::register($this);

    /**
    *@author wawan
	* Declaration Componen User Permission
	* Function getPermission
	* Modul Name[8=SO2]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses('8')){
			return Yii::$app->getUserOpt->Modul_akses('8');
		// }elseif(Yii::$app->getUserOpt->Modul_akses('10')){
			// return Yii::$app->getUserOpt->Modul_akses('10');
		}else{
			return false;
		}
	}

  //if(getPermission()){
  	if(getPermission()->BTN_CREATE){
  		$link = '/purchasing/salesman-order';

  	}else{
  		$link = '/site/validasi';
  	}

  // }



$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,'options'=>['enctype'=>'multipart/form-data']]);
	$ProfAttribute1 = [
		[
			'label'=>'',
			'attribute' =>'EMP_IMG',
			'value'=>Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$model->EMP_IMG,
			'format'=>['image',['width'=>'auto','height'=>'auto']],
		],
	];

	//$this->title = 'Workbench <i class="fa fa fa-coffee"></i> ' . $model->EMP_NM . ' ' . $model->EMP_NM_BLK .'</a>';
	$prof=$this->render('login_index/_info', [
		'model' => $model,
		'dataProvider' => $dataProvider,
	]);

	$EmpDashboard=$this->render('login_index/_dashboard', [
		'model' => $model,
	]);

	/**
     * Logoff
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	function tombolLentera(){
		$title1 = Yii::t('app', ' . . . read-more');
		$options1 = [ 'id'=>'lentera',
					  'data-target'=>"#dashboard-lentera",
					  'style'=>'color:rgba(255, 255, 19, 1)',
		];
		//$icon1 = '<span class="fa fa-power-off fa-lg"></span>';
		$label1 = $title1; //$icon1 . ' ' . $title1;
		//$url1 = Url::toRoute(['/sistem/user-profile/lentera']);//,'kd'=>$kd]);
		$url1 = Url::toRoute(['/widget/help']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	};

	 $profile = Yii::$app->getUserOpt->profile_user()->emp;
	 $emp_nm = $profile->EMP_NM;
?>

	<input type="hidden" name="emp_nm" id='emp' value=<?= $emp_nm ?> >

	<div class="container-fluid" style="padding-left: 20px; padding-right: 20px" >
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">
					<div class="w3-card-2 w3-round w3-white w3-center">
						<div class="row" >
							<div class="w3-container text-left" style="margin-top:3px">
								<?php
									echo Html::panel(
										[
											'heading' => '
											<div>
												<span class="fa-stack fa-xs">
													<i class="fa fa-circle fa-stack-2x " style="color:#ef3933"></i>
													<i class="fa fa-dashboard fa-stack-1x" style="color:#fbfbfb"></i>
												</span> <b>EMPLOYEE DASHBOARD</b>
											</div>',
											'body'=>$prof,
										],
										Html::TYPE_INFO
									);
								?> 
							</div>
						</div>
					</div>
						<?php
						// $profile = Yii::$app->getUserOpt->profile_user();
						// $id = $profile->EMP_ID;
						// $connection = Yii::$app->db_widget;
						// $notif = $connection->createCommand('SELECT sum(TYPE) from bt0001notify where ID_USER='.$id.'')->queryScalar();
						
						// echo Html::panel(
							// [
								// 'heading' => '<div>Employee Dashboard</div>',
								// 'body'=>$prof,
							// ],
							// Html::TYPE_DANGER
						// );
						?>
				</div>
			</div>
		   <div class="row" >				
				<div class="col-xs-12 col-sm-6 col-dm-4  col-lg-4" style="margin-top:10px;padding-left:30px">
					<div class="row" >
						<div class="w3-card-2 w3-round w3-white w3-center">
							<div class="row" >
								<div class="w3-container text-left">					
									<?php
										$bColorCycle1='#25ca4f';
										$iconColor='';
										echo Html::panel([
												'id'=>'task',
												'heading' => '<b>TASK MANAGE </b>',
												'postBody' => Html::listGroup([
														[
															'content' =>'
																<span class="fa-stack fa-xs">
																	<i class="fa fa-circle fa-stack-2x " style="color:'.$bColorCycle1.'"></i>
																	<i class="fa fa-user-plus fa-stack-1x" style="color:#fbfbfb"></i>
																</span> 
															'. '   '. 'Profile',
															'url' => '/sistem/user-profile',

														],
														[
															'content' => '
																<span class="fa-stack fa-xs">
																	<i class="fa fa-circle fa-stack-2x " style="color:'.$bColorCycle1.'"></i>
																	<i class="fa fa-edit fa-stack-1x" style="color:#fbfbfb"></i>
																</span> 
															'. '   '.'Daily Jobs',
															'url' => '/widget/dailyjob',
															'badge' => ''
														],
														/* [
															'content' =>'<span class="fa fa-tags fa-lg"></span>'. '   '. 'Head Jobs ',
															'url' => '/widget/headjob',
															'badge' => ''
														], */
														[
															'content' => '
																<span class="fa-stack fa-xs">
																	<i class="fa fa-circle fa-stack-2x " style="color:'.$bColorCycle1.'"></i>
																	<i class="fa fa-upload fa-stack-1x" style="color:#fbfbfb"></i>
																</span> 
															'. '   '.'Arsip File',
															//'url' => '/widget/arsip',
															'url' => '/filemanager/files',
															'badge' => ''
														],
														[
															'content' => '
																<span class="fa-stack fa-xs">
																	<i class="fa fa-circle fa-stack-2x " style="color:'.$bColorCycle1.'"></i>
																	<i class="fa fa-envelope-o fa-stack-1x" style="color:#fbfbfb"></i>
																</span> 
															'. '   '.'email',
															'url' => '/email/mail-box',
															'badge' => ''
														],
														[
															'content' => '
																<span class="fa-stack fa-xs">
																	<i class="fa fa-circle fa-stack-2x " style="color:'.$bColorCycle1.'"></i>
																	<i class="fa fa-sitemap fa-stack-1x" style="color:#fbfbfb"></i>
																</span> 
															'. '   '.'Organization & Regulation ',
															'url' => '/hrd/administrasi'
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
				</div>
				<div class="col-xs-12 col-sm-6 col-dm-4  col-lg-4" style="margin-top:10px;padding-left:25px">
					<div class="row" >
						<div class="w3-card-2 w3-round w3-white w3-center">
							<div class="row" >
								<div class="w3-container text-left">	
									<?php
										$bColorCycle2='#60aee7';
										echo Html::panel([
												'id'=>'widget',
												'heading' => '<b>WIDGET REMAINDER</b>',
												'postBody' => Html::listGroup([
														[
															'content' => '
																<span class="fa-stack fa-xs">
																	<i class="fa fa-circle fa-stack-2x " style="color:'.$bColorCycle2.'"></i>
																	<i class="fa fa-calendar-check-o fa-stack-1x" style="color:#fbfbfb"></i>
																</span>
															'. '   '.'Pilot Project',
															'url' => '/widget/pilotproject',
															'badge' => ''
														],
														[
															'content' => '
																<span class="fa-stack fa-xs">
																	<i class="fa fa-circle fa-stack-2x " style="color:'.$bColorCycle2.'"></i>
																	<i class="fa fa-folder-open fa-stack-1x" style="color:#fbfbfb"></i>
																</span>
															'. '   '. 'Berita Acara',
															'url' => '/widget/berita',
															'badge' =>'1',
															//'badge' =>'<span class="badge" style="background-color:#ff0000">ABSENT </span>',
														],
														[
															'content' => '
																<span class="fa-stack fa-xs">
																	<i class="fa fa-circle fa-stack-2x " style="color:'.$bColorCycle2.'"></i>
																	<i class="fa fa-comments fa-stack-1x" style="color:#fbfbfb"></i>
																</span>
															'. '   '.'Chating ',
															'url' => '/widget/chat',
															'badge' => '',
															'options'=>[
																'id'=>'chat-tab'
															]
															
														],
														[
															'content' => '
																<span class="fa-stack fa-xs">
																	<i class="fa fa-circle fa-stack-2x " style="color:'.$bColorCycle2.'"></i>
																	<i class="fa fa-sticky-note-o fa-stack-1x" style="color:#fbfbfb"></i>
																</span>
															'. '   '.'Memo',
															'url' => '/widget/memo',
															'badge' => ''
														],
														[
															'content' => '
																<span class="fa-stack fa-xs">
																	<i class="fa fa-circle fa-stack-2x " style="color:'.$bColorCycle2.'"></i>
																	<i class="fa fa-desktop fa-stack-1x" style="color:#fbfbfb"></i>
																</span>
															'. '   '.'Notulen',
															'url' => '/widget/notulen',
															'badge' => ''
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
				</div>
				<div class="col-xs-12 col-sm-6 col-dm-4  col-lg-4" style="margin-top:10px;padding-left:25px;padding-right:30px" >
					<div class="row" >
						<div class="w3-card-2 w3-round w3-white w3-center">
							<div class="row" >
								<div class="w3-container text-left">	
									<?php
										$bColorCycle3='#f08f2e';
										echo Html::panel([
												'id'=>'approval',
												'heading' => '<b>REQUEST AND APPROVAL</b>',
												'postBody' => Html::listGroup([										
														[
															'content' => '
																<span class="fa-stack fa-xs">																	
																	<i class="fa fa-circle fa-stack-2x " style="color:'.$bColorCycle3.'"></i>
																	<i class="fa fa-cart-arrow-down fa-stack-1x" style="color:#fbfbfb"></i>
																</span> 
															'. '   '.'Request Order',
															'url' => '/purchasing/request-order',
															'badge' => ''
														],
														[
															'content' => '
																<span class="fa-stack fa-xs">
																	<i class="fa fa-circle fa-stack-2x " style="color:'.$bColorCycle3.'"></i>
																	<i class="fa fa-cart-plus fa-stack-1x" style="color:#fbfbfb"></i>
																</span> 
															'. '   '.'Sales Order T1',
															'url' => '/purchasing/sales-order',
															'badge' => ''
														],
														[
															'content' => '
																<span class="fa-stack fa-xs">
																	<i class="fa fa-circle fa-stack-2x " style="color:'.$bColorCycle3.'"></i>
																	<i class="fa fa-shopping-cart fa-stack-1x" style="color:#fbfbfb"></i>
																</span> 											
															'. '   '.'Purchase Order',
															'url' => '/purchasing/purchase-order',
															'badge' => ''
														],
														[
															'content' => '
																<span class="fa-stack fa-xs">
																	<i class="fa fa-circle fa-stack-2x " style="color:'.$bColorCycle3.'"></i>
																	<i class="fa fa-chain fa-stack-1x" style="color:#fbfbfb"></i>
																</span> 
															'. '   '.'Sales Order T2 ',
															'url' => $link
														],
														[
															'content' => '
																<span class="fa-stack fa-xs">
																	<i class="fa fa-circle fa-stack-2x " style="color:'.$bColorCycle3.'"></i>
																	<i class="fa fa-exchange fa-stack-1x" style="color:#fbfbfb"></i>
																</span> 
															'. '   '.'Request Trade invest',
															'url' => '/purchasing/request-term',
															'badge' => ''
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
				</div>
			</div>
			<div class="row" style="margin-top:10px;padding-bottom:40px" >
				<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12" >
					<div class="pre-scrollable alert alert-info" style="height:95px; padding-bottom:50px">
					  <strong> Lentera Lukison </strong> <span class='fa fa-fire fa-lg'> </span>
						<br>
							Let's try to use ERP (Enterprise resource planning), hopefully this can !, remember, simplify, speed up and tidying your work.
							Erp first launched with ver 0.1, probably still a lot of homework, but we've tried to set the foundation for the next update. We need feedback for the next version
							<?php echo ' '. tombolLentera(); ?>
						</br>
					</div>
				</div>
			</div>
	 </div>

<!-- <script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/scripts.js"></script>!-->
</body>
</html>
<?php ActiveForm::end(); ?>


<?php

	Modal::begin([
			'id' => 'confirm-permission-alert',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/warning/denied.png',  ['class' => 'pnjg', 'style'=>'width:40px;height:40px;']).'</div><div style="margin-top:10px;"><h4><b>Permmission Confirm !</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
			]
		]);
		echo "<div>You do not have permission for this module.
				<dl>
					<dt>Contact : itdept@lukison.com</dt>
				</dl>
			</div>";
	Modal::end();



