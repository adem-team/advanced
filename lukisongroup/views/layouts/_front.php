<?php
use kartik\icons\Icon;
use kartik\nav\NavX;
use kartik\sidenav\SideNav;
use yii\bootstrap\NavBar;
use kartik\helpers\Html;
use yii\bootstrap\Carousel;
use yii\bootstrap\Modal;
use lukisongroup\assets\AppAsset_front;
AppAsset_front::register($this);
?>

<?php $this->beginBody('class="home"'); ?>  
		
			<div class="container ">
				
				<?php
					// echo  \yii\helpers\Json::encode($menuItems);
					if (Yii::$app->user->isGuest) {
						//$menuItemsNoLogin[] = ['label' => '<a data-toggle="modal" data-target="#modal" style="cursor: pointer">Click me gently!</a>' , 'url'=> ['/site/login5']];
						$menuItemsNoLogin[] = ['label' =>'Home', 'url' => ['/site/index']];
						$menuItemsNoLogin[] = [
							'label' =>'About', 'url' => ['/site/profile/index'],
								'items' => [
									// ['label' => 'Lukison Group', 'url' => '#',
										// 'items' => [
											// ['label' =>'Profile', 'url' => '/front/profile?id=lg'],
											// ['label' => 'Product', 'url' => '/front/product?id=lg'],
											// ['label' => 'Teams', 'url' => '/front/teams?id=lg'],
										// ]
									// ],
									['label' => 'Sarana Sinar Surya', 'url' => '#',
										'items' => [
												['label' =>'Profile', 'url' => '/front/profile?id=sss'],
												['label' => 'Product', 'url' => '/front/product?id=sss'],
												['label' =>'Teams', 'url' => '/front/teams?id=sss'],
										]
									],
									['label' => 'Efenbi Sukses Makmur', 'url' => '#',
										'items' => [
												['label' => 'Profile', 'url' => '/front/profile?id=esm'],
												['label' =>'Product', 'url' => '/front/product?id=sss'],
												['label' => 'Teams', 'url' => '/front/teams?id=sss'],
										]
									],
									// ['label' => 'Arta Lipat Ganda', 'url' => '#',
										// 'items' => [
											// ['label' =>'Profile', 'url' => '/front/profile?id=alg'],
											// ['label' => 'Product', 'url' => '/front/product?id=alg'],
											// ['label' => 'Teams', 'url' => '/front/teams?id=alg'],
										// ]
									// ],
								],
						];
						$menuItemsNoLogin[] = ['label' => 'Events', 'url' => ['/front/event/index']];
						$menuItemsNoLogin[] = ['label' => 'Karir', 'url' => ['/front/karir/index']];
						$menuItemsNoLogin[] = ['label' => 'Contact Us', 'url' => ['/front/contact/index']];
						$menuItemsNoLogin[] = [
							'label' =>'Catalog', 'url' => ['/site/loginc'],
								'items' => [
									['label' => 'e-Procurement', 'url' => '/front/procurement/index'],
									['label' => 'e-Recruitment', 'url' => '/front/recruitment/index'],
									//['label' => 'e-CRM', 'url' => 'http://crm.lukisongroup.com'],
								
								],
						];
						$menuItemsNoLogin[] = ['label' => '<div class="btn">LOGIN</div>', 'url' => ['/site/login'],];
						?>
						<div class="navbar navbar-inverse navbar-fixed-top headroom" ></div>
						<?php
						NavBar::begin([
							'brandLabel' => '<img src="http://lukisongroup.com/logo.png" class="navbar-fixed-top" style="width:120px; height:80px; margin-left:20px; margin-top:10px"/>',//.'<div class=" navbar-fixed-top pull-right" style="margin-left:20%; margin-top:10px; color:black"><h5>Under Maintenance !!</h5> </div>',//.'<div class=" navbar-fixed-top pull-right" style="margin-left:20%; margin-top:10px; color:black"><h5>info@lukison.com / Support: 021888888</h5> </div>',
								
							//'<div style="margin-left:50px"><img src="http://lukisongroup.com/favicon.ico"/>LukisonGroup</div>',
							//'brandUrl' => Yii::$app->homeUrl,
							'options' => [
								   'class' =>  'navbar navbar-inverse navbar-fixed-top headroom',
							],
						]);
						
						echo NavX::widget([
							'options' => ['class' => 'nav navbar-nav pull-right active'],
							'items' => $menuItemsNoLogin,
							'activateParents' => true,
							'encodeLabels' => false,
						]);
						NavBar::end();
					};
				?>
								
			</div>
			<!-- MENU SECTION END-->
			<div style="margin-top:100px">
			<?php echo $content; ?>		
			<div>
		
		
	
<?php $this->endBody() ?>