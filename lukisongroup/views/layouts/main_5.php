<?php

//use yii\helpers\Html;
use kartik\helpers\Html;
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
            <!-- tambahan variable untuk template Author: --ptr.nov-- !-->
            <title><?= Html::encode($this->sideMenu) ?></title>
            <title><?= Html::encode($this->sideCorp) ?></title>

			<?php $this->head() ?>
		</head>

		<?php
			/*
			* == Call Variable Menu manipulation | --author: ptr.nov--
			*/
        //Icon::showStack('twitter', 'square-o', ['class'=>'fa-lg'])
			$callback = function($menu){
				$data1=($menu['data']);
				$data2=str_replace("'",'',$data1);
				$data3=str_replace(";",'',$data2);	
                $data1=$menu['data'];
				$data = eval($menu['data']);
                //echo $data;
				return [
					'label' => Icon::show($data3).$menu['name'],
					'url' => [$menu['route']],
					//'options' => $data1,
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
			<body class="skin-blue sidebar-mini">
				<!Refrensi:skin-blue|skin-blue-light|skin-green|skin-yellow|skin-purple|skin-red|skin-black>
				<?php $this->beginBody(); ?>  
					<div class="wrapper bg-olive">
						<!Refrensi:bg-light-blue|bg-green|bg-yellow|bg-red|bg-aqua|bg-purple|bg-blue|bg-navy|bg-teal|bg-maroon|bg-black|bg-gray|bg-olive|bg-lime|bg-orange|bg-fuchsia>
						<header class="main-header">
							<a  class="logo bg-red">
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
		<?php }; ?>

		<! -LOGIN- Author : -ptr.nov- >
		<?php if (!Yii::$app->user->isGuest) { ?>
			<body class="hold-transition skin-blue"> <!--  sidebar-mini !-->
				<?php $this->beginBody(); ?>
                <div class="wrapper">
                    <header class="main-header">
                        <a  class="logo bg-red">
                            <?php
                            echo Html::img('http://lukisongroup.com/favicon.ico', ['width'=>'20']);
                            ?>
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
                                            'label' => Icon::show('power-off') . 'Logout (' . Yii::$app->user->identity->username . ')',
                                            //'label' => Icon::showStack('twitter', 'square-o', ['class'=>'fa-lg']) . 'Logout (' . Yii::$app->user->identity->username . ')',
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
                                               'class' => [
                                                   'navbar navbar-inverse navbar-static-top',
                                                   'style'=>'background-color:#313131'
                                               ],
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
                                    <div class="pull-left" style="text-align: left">
                                        <img src="<?= Yii::getAlias('@HRD_EMP_UploadUrl') .'/'. $MainAvatar; ?>" class="img-circle" alt="Cinque Terre" width="80" height="80"/>
                                    </div>
                                    <div class="pull-left info" style="margin-left: 40px" >
                                        <p><?php echo $MainUserProfile; ?></p>
                                    
                                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                                    </div>
                                </div>
                            <div class="user-panel bg-red">
                                <!-- /.Company Select Dashboard -->
                                 <p>
                                    <?php
                                        if ($this->sideCorp != '') {
                                            echo $this->sideCorp;
                                        }else{
                                            echo 'PT. Lukison Group';
                                        };
                                    ?>
                                 </p>
                            </div>
                               
                            <!-- /.User Login -->
                            <!-- search form -->
                                <form action="#" method="get" class="sidebar-form skin-blue">
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
                                $side_menu='';
                                    //echo $this->sideMenu;
                                    if ($this->sideMenu != false) {
                                        $getSideMenu=$this->sideMenu;
                                        if (M1000::find()->findMenu($this->sideMenu)->one()){
                                            $getSideMenu=$this->sideMenu;

                                        }else{
                                            echo Html::panel(
                                                ['heading' => 'variabel $this->sideMenu = "'.  $getSideMenu . '"; Tidak ditemukan dalam database dbm000, tabel m1000, tambahkan pada view anda menu yang benar untuk menu samping '],
                                                Html::TYPE_INFO
                                            );
                                             $getSideMenu='mdefault';
                                        }
                                    }else{
                                        $getSideMenu='mdefault';
                                    };

                                    $side_menu=\yii\helpers\Json::decode(M1000::find()->findMenu($getSideMenu)->one()->jval);
                                    if (!Yii::$app->user->isGuest) {
                                        echo SideNav::widget([
                                            'items' => $side_menu,
                                            'encodeLabels' => false,
                                            //'heading' => $heading,
                                            'type' => SideNav::TYPE_DEFAULT,
                                            'options' => [
                                                'class' => 'navbar-default bg-black',
                                                //'style'=>'background-color:#313131',
                                            ],
                                        ]);
                                    };
                                ?>

                        </section>
                    </aside>
                    <div class="content-wrapper">
                        <!--<div class="panel panel-default" style="margin-bottom: 0">!-->
                            <?php
                               /*
							   echo Breadcrumbs::widget([
                                               'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                               'options'=>[
                                                   'class' => 'breadcrumb',
                                                   'style'=>'background-color:#e1e1e1;margin-bottom:0;margin-top:0',
                                               ],
                                           ]);
								*/
                            ?>
                        <!--</div>!-->
                        <div class="panel panel-default" style="margin-left: 2px; margin-right: 2px ;margin-bottom: 0">
                            <?php
                                // Title Penganti Breadcrumbs Author: -ptr.nov-
                                echo Html::panel(
                                    ['heading' => $this->title ],
                                    Html::TYPE_DANGER
                                );

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
	<?php }; ?>
	</html>
<?php $this->endPage() ?>
