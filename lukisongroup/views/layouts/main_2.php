<?php
use lukisongroup\assets\AppAsset;
use mdm\admin\components\MenuHelper;
use yii\helpers\Html;
/*use yii\bootstrap\Nav;*/
use kartik\nav\NavX;
use kartik\sidenav\SideNav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use kartik\icons\Icon;
use dmstr\widgets\Alert;
/* @var $this \yii\web\View */
/* @var $content string */

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
    <?php $this->head() ?>

</head>

<body class="skin-blue sidebar-mini">
<?php $this->beginBody(); ?>

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

            /*
             * == Admin Menu manipulation | --author: ptr.nov--
             */
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => Icon::show('gears') .'Login', 'url' => ['/site/login']];
            } else {
                //$menuItems  = MenuHelper::getAssignedMenu(Yii::$app->user->id);
                $menuItems = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback);
                $menuItems[] = [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }

            $footerStart ="<footer class='footer'>";
            $footerEnd ="</footer>";
            $divStar="<div class='container'>";
            $divEnd="</div>";
            $corp="<p class='pull-left'>&copy; LukisonGroup <?= date('Y') ?></p>";
        ?>


        <?php
            /*
             * Body Page permission User| --author: ptr.nov--
             */
            if (Yii::$app->user->isGuest) {
                echo $content; // Login Content Show wirh blank backgroud
            };
            //else{

        ?>

<?php if (!Yii::$app->user->isGuest) { ?>
    <div class="wrapper">
        <header class="main-header">
            <a  class="logo">
                <!-- LOGO -->
                LukisonGroup
            </a>
            <?php
                // echo  \yii\helpers\Json::encode($menuItems);
                if (!Yii::$app->user->isGuest) {
                    NavBar::begin([
                        //'brandLabel' => 'LukisonGroup',
                        //'brandUrl' => Yii::$app->homeUrl,
                        'options' => [
                            //'class' => 'navbar-inverse navbar-fixed-top',
                           //'class' =>  'navbar navbar-inverse navbar-static-top',
                            'class' => 'navbar-inverse navbar-static-top',
                           // 'class' => 'navbar navbar-fixed-top',
                            'role'=>'navigation'//,'style'=>'margin-bottom: 0'
                        ],
                    ]);

                    echo NavX::widget([
                        'options' => ['class' => 'navbar-nav navbar-left'],
                        'items' => $menuItems,
                        'activateParents' => true,
                        'encodeLabels' => false,
                    ]);
                    NavBar::end();
                };

            ?>
         </header>

        <div class="content-wrapper" >
            <aside class="main-sidebar">
                <?php
                    if (!Yii::$app->user->isGuest) {
                        echo SideNav::widget([
                            'items' => $menuItems,
                            'encodeLabels' => false,
                            //'heading' => $heading,
                            'type' => SideNav::TYPE_DEFAULT,
                            'options' => ['class' => 'sidebar-nav'],
                        ]);
                    };
                ?>


                <form class="sidebar-form" method="get" action="#"></form>
                <li class="header">
                  
                </li>
            </aside>
            <section class="content">
                <?php //echo Breadcrumbs::widget([
						  //			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
						  //		]);
                ?>
                <?= Alert::widget() ?>
                <?php echo $content; ?>
            </section>
        </div>

        <footer class="main-footer">
                <p class="pull-left"> <?php echo $corp . date('Y') ?></p>
        </footer>
    </div>
<?php } ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
