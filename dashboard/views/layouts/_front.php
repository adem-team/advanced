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

<?php $this->beginBody('class="content-fluid" style="background-color:lightgrey"'); ?>  
		
			<!-- MENU SECTION END-->
			<div style="background-color: rgba(153, 154, 141, 0.6)">
			<?php echo $content; ?>		
			<div>
		
		
	
<?php $this->endBody() ?>