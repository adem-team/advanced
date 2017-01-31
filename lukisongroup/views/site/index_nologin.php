<?php
/* @var $this yii\web\View */
use kartik\helpers\Html;
use yii\bootstrap\Carousel;
use lukisongroup\assets\Profile;
Profile::register($this);

$this->title = 'My Yii Application';
?>

<!-- CROUSEL Author: -ptr.nov- !-->
			<?php
				echo Carousel::widget([
				  'items' => [
					 // equivalent to the above
					  [
						'content' => '<img src="'.Yii::getAlias('@path_carousel') . '/Lukison-Slider1.jpg" style="width:100%; height:100%"/>',
						//'content' => '<img src="http://lukisongroup.int/upload/carousel/Lukison-Slider3.jpg" style="width:100%; height:100%"/>',
					//	'options' =>[ 'style' =>'width: 100%; height: 300px;'],
					  ],
					  [
						'content' => '<img src="'.Yii::getAlias('@path_carousel') . '/Lukison-Slider2.jpg" style="width:100%; height:100%"/>',
						//'options' =>[ 'style' =>'width: 100% ; height: 300px;'],
					  ],

					  // the item contains both the image and the caption
					  [
						  'content' => '<img src="'.Yii::getAlias('@path_carousel') . '/Lukison-Slider3.jpg" style="width:100%;height:100%"/>',
						  //'caption' => '<h4>This is title</h4><p>This is the caption text</p>',
						// 'options' =>[ 'style' =>'width: 100%; height: 300px;'],

					  ],
					  [
						  'content' => '<img src="'.Yii::getAlias('@path_carousel') . '/Lukison-Slider4.jpg" style="width:100%;height:100%"/>',
						  //'caption' => '<h4>This is title</h4><p>This is the caption text</p>',
						// 'options' =>[ 'style' =>'width: 100%; height: 300px;'],

					  ],
				  ],
				   //'options' =>[ 'style' =>'width: 100%!important; height: 300px;'],
				]);
			?>

							
					
				
	<div class="row">					
		<div class="w3-card-2 w3-round w3-white w3-center" style="margin-top:5px;margin-left:5px;margin-right:5px;">
			<div class="panel-heading" style="background-color:#2292d0;">
				<div class="row" >						
					<div style="min-height:10px; height:40px">										
					</div>	
					<div class="col-lg-12 col-xs-12">
						<div class="row" >	
							<div class="col-lg-4 col-xs-12" style="background-color:#c72b42;">
								<div class="row" >	
									<div class="col-lg-12 col-xs-12" style="min-height:150px;height:150px;background-color:#c72b42;">								
										<div class="col-lg-6 col-xs-6 text-right" style="margin-top:30px;">								
											<span class="fa-stack fa-3x">
												<i class="fa fa-circle fa-stack-2x " style="color:#25ca4f"></i>
												<i class="fa fa-phone fa-stack-1x" style="color:#fbfbfb"></i>
											</span> 
										</div>
										<div class="col-lg-6 col-xs-6 text-left" style="margin-top:30px;">								
											<div style="color:#fbfbfb"><b>Call</b></div>
											<div style="color:#dfd6d8">T: 021-30448598/99</div>
											<div style="color:#dfd6d8">F: 021-30448597</div>													
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-xs-12">
								<div class="row" >	
									<div class="col-lg-12 col-xs-12" style="min-height:150px;height:150px;background-color:#c72b42;">
										<div class="col-lg-6 col-xs-6 text-right" style="margin-top:30px;">								
											<span class="fa-stack fa-3x">
												<i class="fa fa-circle fa-stack-2x " style="color:#25ca4f"></i>
												<i class="fa fa-envelope-o fa-stack-1x" style="color:#fbfbfb"></i>
											</span> 
										</div>
										<div class="col-lg-6 col-xs-6 text-left" style="margin-top:40px;">								
											<div style="color:#fbfbfb"><b>Contact</b></div>
											<div style="color:#dfd6d8">info@lukison.com</div>												
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-lg-4 col-xs-12">
								<div class="row" >	
									<div class="col-lg-12 col-xs-12" style="min-height:150px;height:150px;background-color:#c72b42;">
										<div class="col-lg-6 col-xs-6 text-right" style="margin-top:30px;">								
											<span class="fa-stack fa-3x">
												<i class="fa fa-circle fa-stack-2x " style="color:#25ca4f"></i>
												<i class="fa fa-copyright fa-stack-1x" style="color:#fbfbfb"></i>
											</span> 
										</div>
										<div class="col-lg-6 col-xs-6 text-left" style="margin-top:40px;">								
											<div style="color:#dfd6d8">© 2016 / 2017 by lukisongroup.com</div>												
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div style="min-height:200px;background-color:#2292d0;">										
					</div>		
				</div>			
			</div>		
		</div>		
	</div>		
					
	

