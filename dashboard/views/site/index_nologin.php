<?php
/* @var $this yii\web\View */
use kartik\helpers\Html;
use yii\bootstrap\Carousel;

$this->title = 'Dashboard';
?>

<?php
	 $content1 ='<div style="background-color:black; height:70px"></div>';

?>
<div class="mainbody-section text-center">
	<div class="container">
		<div class="row">
			<!-- COLOMN 1 !-->
			<div class="col-md-3">	
				<!-- COLOMN 1 ROW1!-->
				<div class="menu-item blue">
					<a href="/site/login" data-toggle="modal">
						<i class="fa fa-magic"></i>ss
						
					</a>
				</div>		
				<!-- COLOMN 1 ROW2!-->				
				<div class="menu-item green">
					<a href="#portfolio-modal" data-toggle="modal">
						<i class="fa fa-file-photo-o"></i>
					</a>
				</div>									
			</div>
			<!-- COLOMN 2 !-->
			<div class="col-md-6">
				<?php
				$content1=Yii::$app->controller->renderPartial('carousel_nologin');
				echo Html::panel(
					['heading' => '<h3>LUKISONGROUP DASHBOARD</h3>', 'body' => $content1],
					Html::TYPE_INFO
				);
				?>						                
			</div>
			
			<!-- COLOMN 4 !-->
			<div class="col-md-3">	
				<!-- COLOMN 1 ROW1!-->			
				<div class="menu-item light-red">
					<a href="#contact-modal" data-toggle="modal">
						<i class="fa fa-envelope-o"></i>
					</a>
				</div>	
				<!-- COLOMN 1 ROW2!-->				
				<div class="menu-item color">
					<a href="#clients-modal" data-toggle="modal">
						<i class="fa fa-comment-o"></i>
					</a>
				</div>						
			</div>
		</div>
		
		<div class="row">
			<!-- COLOMN 1 !-->
			<div class="col-md-3">	
				<!-- COLOMN 1 ROW1!-->
				<div class="menu-item blue">
					<a href="#feature-modal" data-toggle="modal">
						<i class="fa fa-magic"></i>ss
						
					</a>
				</div>							
			</div>
			<!-- COLOMN 2 !-->
			<div class="col-md-3">
				<!-- COLOMN 1 ROW1!-->
				<div class="menu-item color">
					<a href="#service-modal" data-toggle="modal">
						<i class="fa fa-area-chart"></i>
					</a>
				</div>				                    
			</div>
			
			<!-- COLOMN 2 !-->
			<div class="col-md-3">
				<!-- COLOMN 1 ROW1!-->
				<div class="menu-item color">
					<a href="#service-modal" data-toggle="modal">
						<i class="fa fa-area-chart"></i>
					</a>
				</div>	
				                    
			</div>
			<!-- COLOMN 4 !-->
			<div class="col-md-3">	
				<!-- COLOMN 1 ROW1!-->			
				<div class="menu-item light-red">
					<a href="#contact-modal" data-toggle="modal">
						<i class="fa fa-envelope-o"></i>
					</a>
				</div>								
			</div>
		</div>
	</div>
</div>