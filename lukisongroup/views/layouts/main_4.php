<?php

use yii\helpers\Html;
use yii\bootstrap\Carousel;

use kartik\form\ActiveForm;
/*use yii\bootstrap\Nav;*/
use kartik\nav\NavX;
use kartik\sidenav\SideNav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use kartik\icons\Icon;
use dmstr\widgets\Alert;
use app\models\system\user\UserloginSearch;
/* @var $this \yii\web\View */
/* @var $content string */
/* VARIABLE SIDE MENU Author: -Eka- */
use lukisongroup\models\system\side_menu\M1000;			/* TABLE CLASS */
use lukisongroup\assets\AppAsset;
use mdm\admin\components\MenuHelper;
use yii\bootstrap\Modal;
//AppAsset::register($this);
dmstr\web\AdminLteAsset::register($this);



?>
<?php $this->beginPage() ?>
	<!DOCTYPE html>
	<html lang="<?= Yii::$app->language ?>">
		<head>
			<meta charset="<?= Yii::$app->charset ?>">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<?= Html::csrfMetaTags() ?>
			<title><?= Html::encode($this->title) ?></title>

            <title><?= Html::encode($this->sideMenu) ?></title>
			<?php $this->head() ?>
		</head>

		<?php
			/*
			* == Call Variable Menu manipulation | --author: ptr.nov--
			*/
			$callback = function($menu){
				$data = eval($menu['data']);
				return [
					'label' => $menu['name'],
					'url' => [$menu['route']],
					//'options' => $data,
					'items' => $menu['children']
				];
			};

			/**
			 * Validasi database Default EMP_ID =0 
			 * note error : lost left join Field unn\known attribute properties
			 * Author: -ptr.nov-, 
			 */
			if (!Yii::$app->user->isGuest) {
				$ModelUserAttr = UserloginSearch::findUserAttr(Yii::$app->user->id)->one();
				//print_r($ModelUserAttr);
				//echo $ModelUserAttr->emp->EMP_IMG;
				$MainAvatar =  $ModelUserAttr->emp->EMP_IMG;
				$MainUserProfile = $ModelUserAttr->emp->EMP_NM . ' '. $ModelUserAttr->emp->EMP_NM_BLK;
			
			}
			$corp="<p class='pull-left'>&copy; LukisonGroup <?= date('Y') ?></p>";			
		?>
		
		<! - NOT LOGIN- Author : -ptr.nov- >
		<?php if (Yii::$app->user->isGuest) { ?>
			<body class="skin-red sidebar-mini">
				<!Refrensi:skin-blue|skin-blue-light|skin-green|skin-yellow|skin-purple|skin-red|skin-black>
				<?php $this->beginBody(); ?>  
					<div class="wrapper bg-olive">
						<!Refrensi:bg-light-blue|bg-green|bg-yellow|bg-red|bg-aqua|bg-purple|bg-blue|bg-navy|bg-teal|bg-maroon|bg-black|bg-gray|bg-olive|bg-lime|bg-orange|bg-fuchsia>
						<header class="main-header">
							<a  class="logo">
								<!-- LOGO -->
								LukisonGroup
							</a>

							<?php
								// echo  \yii\helpers\Json::encode($menuItems);
								if (Yii::$app->user->isGuest) {
									//$menuItemsNoLogin[] = ['label' => '<a data-toggle="modal" data-target="#modal" style="cursor: pointer">Click me gently!</a>' , 'url'=> ['/site/login5']];
                                    $menuItemsNoLogin[] = ['label' => Icon::show('home').'Home', 'url' => ['/site/']];
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
											//'class' => 'navbar-inverse navbar-fixed-top',
										   //'class' =>  'navbar navbar-inverse navbar-static-top',
											'class' => 'navbar-inverse navbar-static-top',
										   // 'class' => 'navbar navbar-inverse',
											'role'=>'navigation'//,'style'=>'margin-bottom: 0'
										],
									]);

									echo NavX::widget([
										'options' => ['class' => 'navbar-nav navbar-left'],
										'items' => $menuItemsNoLogin,
										'activateParents' => true,
										'encodeLabels' => false,
									]);
									NavBar::end();
								};

							?>
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
						<?php echo $content; ?>
					</div>
                    <footer class="footer bg-black" style="height: 50px">
                        <br>
                            <?php echo $corp . date('Y') ?>
                        </br>
                    </footer>
				<?php $this->endBody() ?>
			</body>
		<?php } ?>

		<! -LOGIN- Author : -ptr.nov- >
		<?php if (!Yii::$app->user->isGuest) { ?>
			<body class="hold-transition skin-blue"> <!--  sidebar-mini !-->
				<?php $this->beginBody(); ?>
                <div class="wrapper">
                    <header class="main-header">
                        <a  class="logo bg-red">
                            <!-- LOGO -->
                            LukisonGroup
                        </a>
                           <!--  <div class="navbar-custom-menu">!-->
                                <?php
                                    // echo  \yii\helpers\Json::encode($menuItems);
                                    if (!Yii::$app->user->isGuest) {
                                        //$menuItems  = MenuHelper::getAssignedMenu(Yii::$app->user->id);
                                        $menuItems = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback);
                                        $menuItems[] = [
                                            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                                            'url' => ['/site/logout'],
                                            'linkOptions' => ['data-method' => 'post']
                                        ];

                                        NavBar::begin([
                                            //'brandLabel' => 'LukisonGroup',
                                            //'brandUrl' => Yii::$app->homeUrl,
                                            //-ptr.nov-
                                            'brandLabel' => '<!-- Sidebar toggle button-->
                                                            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                                                                <span class="sr-only">Toggle Navigation</span>
                                                            </a>',
                                            'options' => [
                                                //'class' => 'navbar-inverse navbar-fixed-top',
                                               'class' =>  'navbar navbar-inverse navbar-static-top',
                                                //'class' => 'navbar-inverse navbar-static-top',
                                               // 'class' => 'navbar-inverse navbar',
                                                // 'class' => 'navbar navbar-fixed-top',
                                                'role'=>'button',
                                                'style'=>'margin-bottom: 0',
                                            ],
                                        ]);

                                        echo NavX::widget([
                                            'options' => ['class' => 'navbar-nav  navbar-left'],
                                            'items' => $menuItems,
                                            'activateParents' => true,
                                            'encodeLabels' => false,
                                        ]);

                                        NavBar::end();
                                    };
                                ?>
                           <!-- </div>!-->

                    </header>
                    <aside class="main-sidebar">
                        <section class="sidebar">
                            <!-- User Login -->
                                <div class="user-panel">
                                    <div class="pull-left image">
                                        <img src="<?= Yii::getAlias('@HRD_EMP_UploadUrl') .'/'. $MainAvatar; ?>" class="img-circle" alt="User Image"/>
                                    </div>
                                    <div class="pull-left info">
                                        <p><?php echo $MainUserProfile; ?></p>

                                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                                    </div>
                                </div>
                            <!-- /.User Login -->
                            <!-- search form -->
                                <form action="#" method="get" class="sidebar-form">
                                    <div class="input-group">
                                        <input type="text" name="q" class="form-control" placeholder="Search..."/>
                                      <span class="input-group-btn">
                                        <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                                        </button>
                                      </span>
                                    </div>
                                </form>
                            <!-- /.search form -->
                                <?php
                                    /**
                                     * Author: -ptr.nov-
                                     * Noted: add variable "sideMenu" get value
                                     * \vendor\yiisoft\yii2\web\View.php
                                    */
                                    //echo $this->sideMenu;
                                    if ($this->sideMenu != false) {
                                        $getSideMenu=$this->sideMenu;
                                    }else{
                                        $getSideMenu='mdefault';
                                    }
                                    $side_menu=\yii\helpers\Json::decode(M1000::find()->findMenu($getSideMenu)->one()->jval);
                                    if (!Yii::$app->user->isGuest) {
                                        echo SideNav::widget([
                                            'items' => $side_menu,
                                            'encodeLabels' => false,
                                            //'heading' => $heading,
                                            'type' => SideNav::TYPE_DEFAULT,
                                            'options' => [
                                                'class' => 'navbar-inverse',
                                                'style'=>'background-color:#313131',
                                            ],
                                        ]);
                                    };
                                ?>

                        </section>
                    </aside>
                    <div class="content-wrapper">
                        <div class="panel panel-default" style="margin-bottom: 0">
                            <?php
                               echo Breadcrumbs::widget([
                                               'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                               'options'=>[
                                                   'class' => 'breadcrumb',
                                                   'style'=>'background-color:#e1e1e1;margin-bottom:0;margin-top:0',
                                               ],
                                           ]);
                            ?>
                        </div>
                        <div class="panel panel-default" style="margin-left: 2px; margin-right: 2px ;margin-bottom: 0">
                            <?php
                               echo $content;
                            ?>
                       </div>

                    </div>
                <div class="box-footer bg-black" style="color: blue">
                    <p> <?php echo $corp .'-'. date('Y') ?></p>
                </div>
            </div>
			<?php $this->endBody() ?>
		</body>
	<?php } ?>
	</html>
<?php $this->endPage() ?>
