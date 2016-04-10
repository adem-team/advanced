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
						<i class="fa fa-cutlery"></i> </br>PT.Efenbi Sukses Makmur
						
					</a>
				</div>		
				<!-- COLOMN 1 ROW2!-->				
				<div class="menu-item green">
					<a href="/site/login" data-toggle="modal">
						<i class="fa fa-coffee"></i></br>PT.Sarana Sinar Surya
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
					<a href="/site/login" data-toggle="modal">
						<i class="fa fa-map-o"></i></br>PT.Artha Lipat Ganda
					</a>
				</div>	
				<!-- COLOMN 1 ROW2!-->				
				<div class="menu-item color">
					<a href="/site/login" data-toggle="modal">
						<i class="fa fa-truck"></i></br>PT.Gosend
					</a>
				</div>						
			</div>
		</div>
		
		<div class="row">
			<!-- COLOMN 1 !-->
			<div class="col-md-3">	
				<!-- COLOMN 1 ROW1!-->
				<div class="menu-item blue">
					<a href="/site/login" data-toggle="modal">
						<i class="fa fa-users"></i></br>HIRS
						
					</a>
				</div>							
			</div>
			<!-- COLOMN 2 !-->
			<div class="col-md-3">
				<!-- COLOMN 1 ROW1!-->
				<div class="menu-item color">
					<a href="/site/login" data-toggle="modal">
						<i class="fa fa-shopping-basket"></i></br>Purchasing
					</a>
				</div>				                    
			</div>
			
			<!-- COLOMN 2 !-->
			<div class="col-md-3">
				<!-- COLOMN 1 ROW1!-->
				<div class="menu-item color">
					<a href="/site/login" data-toggle="modal">
						<i class="fa fa-money"></i></br>Accounting
					</a>
				</div>	
				                    
			</div>
			<!-- COLOMN 4 !-->
			<div class="col-md-3">	
				<!-- COLOMN 1 ROW1!-->			
				<div class="menu-item light-red">
					<a href="/site/login" data-toggle="modal">
						<i class="fa fa-exchange"></i></br>General Affair
					</a>
				</div>								
			</div>
		</div>
	</div>
</div>