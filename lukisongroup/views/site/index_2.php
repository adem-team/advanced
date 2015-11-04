
<?php
use app\models\system\user\UserloginSearch;
/* @var $this yii\web\View */
if (!Yii::$app->user->isGuest) {
    $ModelUserAttr = UserloginSearch::findUserAttr(Yii::$app->user->id)->one();
    $MainAvatar =  $ModelUserAttr->emp->EMP_IMG;
    $EmployeeName = $ModelUserAttr->emp->EMP_NM . ' '. $ModelUserAttr->emp->EMP_NM_BLK;
}
$this->title = 'Workbench ' .  '<a href="#"><i class="fa  fa fa-coffee"></i> ' . $EmployeeName .'</a>';
?>

<div class="panel panel-default" style="margin-top: 0px">

    <div class="panel-body">
		<div class="dashboard-view">
				<h1>Congratulations!</h1>

				<p class="lead">You have successfully created your Yii-powered application.</p>

				<p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
		
			
		</div>
    </div>
</div>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Standar Kerja</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Detail Standar Kerja &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>JobsDesk</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Detail JobsDesk &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>SOP</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Detail SOP &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
