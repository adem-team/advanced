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

<?php $this->beginBody(); ?>  
		<!--<div class="container">!-->
		<div class="">
			<!Refrensi:bg-light-blue|bg-green|bg-yellow|bg-red|bg-aqua|bg-purple|bg-blue|bg-navy|bg-teal|bg-maroon|bg-black|bg-gray|bg-olive|bg-lime|bg-orange|bg-fuchsia>
			<header >			
					<div class="row">
						<div class="col-md-11">
							Under Construction !
							<strong>Email: </strong>info@lukison.com
							&nbsp;&nbsp;
							<strong>Support: </strong>(021) 3044-85-98/99
						</div>
					</div>
								
			 </header>
			<!-- CROUSEL Author: -ptr.nov- !-->
			<?php
				echo Carousel::widget([
				  'items' => [
					 // equivalent to the above
					  [
						'content' => '<img src="'.Yii::getAlias('@path_carousel') . '/test1.jpg" style="width:100%; height:100%"/>',
					//	'options' =>[ 'style' =>'width: 100%; height: 300px;'],
					  ],
					[
						'content' => '<img src="'.Yii::getAlias('@path_carousel') . '/test2.jpg" style="width:100%; height:100%"/>',
						//'options' =>[ 'style' =>'width: 100% ; height: 300px;'],
					  ],

					  // the item contains both the image and the caption
					  [
						  'content' => '<img src="'.Yii::getAlias('@path_carousel') . '/test1.jpg" style="width:100%;height:100%"/>',
						  //'caption' => '<h4>This is title</h4><p>This is the caption text</p>',
						// 'options' =>[ 'style' =>'width: 100%; height: 300px;'],

					  ],
				  ],
				   //'options' =>[ 'style' =>'width: 100%!important; height: 300px;'],
				]);
			?>
			<div>
			<?php
				// echo  \yii\helpers\Json::encode($menuItems);
				if (Yii::$app->user->isGuest) {
					//$menuItemsNoLogin[] = ['label' => '<a data-toggle="modal" data-target="#modal" style="cursor: pointer">Click me gently!</a>' , 'url'=> ['/site/login5']];
					$menuItemsNoLogin[] = ['label' => Icon::show('home').'Perusahaan', 'url' => ['/site/']];
					$menuItemsNoLogin[] = [
						'label' => Icon::show('shopping-cart') .'e-Procurement', 'url' => ['/site/loginc'],
							'items' => [
								['label' => Icon::show('book') .'Catalog', 'url' => '#'],
								['label' => Icon::show('bar-chart-o') .'Supplier', 'url' => '#'],
							],
					];
					$menuItemsNoLogin[] = ['label' => Icon::show('sitemap') .'e-Recruitment', 'url' => ['/site/login7']];
					$menuItemsNoLogin[] = ['label' => Icon::show('comments') .'e-Helpdesk', 'url' => ['/site/login8']];
					$menuItemsNoLogin[] = ['label' => Icon::show('info-circle') .'FAQ', 'url' => ['/site/login8']];
					$menuItemsNoLogin[] = ['label' => Icon::show('user').'User', 'url' => ['/site/login']];

					NavBar::begin([
						//'brandLabel' => 'LukisonGroup',
						//'brandUrl' => Yii::$app->homeUrl,
						'options' => [
							'class' => 'navbar navbar-inverse set-radius-zero #000000 ',
						   //'class' =>  'navbar navbar-inverse navbar-static-top',
							//'class' => 'navbar-inverse navbar-static-top ',
						   // 'class' => 'navbar navbar-inverse',
							//'role'=>'navigation'//,'style'=>'margin-bottom: 0'
						],
					]);

					echo NavX::widget([
						'options' => ['class' => 'nav navbar-nav navbar-left'],
						'items' => $menuItemsNoLogin,
						'activateParents' => true,
						'encodeLabels' => false,
					]);
					NavBar::end();
				};
			?>
			</div>
		<!-- MENU SECTION END-->
		<div class="content">
			<div class="content">					
				<div class="row">
					 <div class="col-md-3 col-sm-3 col-xs-6">
						<div class="dashboard-div-wrapper bk-clr-one">
							<i  class="fa fa-venus dashboard-div-icon" ></i>
							<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"> </div>                           
						</div>
							 <h5>e-Recruitment </h5>
						</div>
					</div>
					 <div class="col-md-3 col-sm-3 col-xs-6">
						<div class="dashboard-div-wrapper bk-clr-two">
							<i  class="fa fa-edit dashboard-div-icon" ></i>
							<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%"></div>											   
						</div>
							 <h5>e-Recruitment</h5>
						</div>
					</div>
					 <div class="col-md-3 col-sm-3 col-xs-6">
						<div class="dashboard-div-wrapper bk-clr-three">
							<i  class="fa fa-cogs dashboard-div-icon" ></i>
							<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"></div>											   
						</div>
							 <h5>FAQ </h5>
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<div class="dashboard-div-wrapper bk-clr-four">
							<i  class="fa fa-bell-o dashboard-div-icon" ></i>
							<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%"></div>												   
						</div>
							 <h5>Karir</h5>
						</div>
					</div>
				</div>
				 <div class="row">
					<div class="col-md-12">
						<h4 class="page-head-line">Perusahaan</h4>
						<?php echo $content; ?>
					</div>
				</div>
				 <div class="row">
					<div class="col-md-12">
						<h4 class="page-head-line">CONTACT</h4>					
						<?php
							echo Html::well(Html::address(
							'Ruko De Mansion Blok C No.12',
							 ['Jl. Jalur Sutera, Alam Sutera, Serpong','Tangerang Selatan.'],
							 ['Tel ' => '(021) 3044-85-98/99'],
							 ['Fax ' => '(021) 3044 85 97'],
							 ['Website : ' => 'www.lukison.com', 'Email' => 'info@lukison.com']
							), Html::SIZE_TINY);
						?>		
					</div>
				</div>				
			</div>				
		</div>
			
	</div>		
		<footer class="footer bg-black" style="height: 50px">
			<br>
				<?php echo $corp . date('Y') ?>
			</br>
		</footer>
	
<?php $this->endBody() ?>