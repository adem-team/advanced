<?php
/* @var $this yii\web\View */
use kartik\helpers\Html;
use yii\bootstrap\Carousel;

$this->title = 'Dashboard';
?>

<?php
	 $content1 ='<div style="background-color:black; height:70px"></div>';

?>
<div class="container-fluid">

		<div class="row" style="background-color:blue">
	
			<div class="col-xs-12 col-sm-12 col-md-12col-lg-12   " style="margin-top:210px">
				<div class="col-xs-12 col-sm-12 col-md-12col-lg-12" style="padding-top:0px	">
					<!-- <b class="text-right"> echo btnTanggal($model) ?></b> -->
					<nav class="menu">
						<input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open" />
						<label class="menu-open-button" for="menu-open"> <span>LG</span></label>
						<a href="/site/login" class="menu-item item-1"> <i class="fa fa-anchor"></i> </a> 
						<a href="/site/login" class="menu-item item-2"> <i class="fa fa-coffee"></i> </a> 
						<a href="/site/login" class="menu-item item-3"> <i class="fa fa-envelope-o"></i> </a> 
						<a href="http://dashboard.lukisongroup.com/" class="menu-item item-4"> <i class="fa fa-undo"></i></a> 
						<a href="/site/login" class="menu-item item-5"> <i class="fa fa-print fa-fw"></i> </a> 
						<a href="/site/login" class="menu-item item-6"> <i class="fa fa-diamond"></i> </a>
					</nav>
				</div>
			</div>		
	</div>

</div>