<?php
/* @var $this yii\web\View */
use kartik\helpers\Html;
use yii\bootstrap\Carousel;

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
<div class="content">
			<div class="content">			
				 <div class="row">
					<div class="col-md-12">						
						<h4 class="page-head-line">Customer Relationship Management</h4>
						<p>Lukison group considered being one of the largest premium food court in the city and it is a great mix of old favorites and new restaurants. With the large space more than 2000m2 and futuristic and old style design, Lukison offered a coz/ambiance and warm place to enjoy your dinning experiences.

							complete with 3D lenticular light box and vintage wood plank will make the visitors feel relax and chill with new ambiance that they can’t discover in another place. With all variety of different kinds of food, Lukison give you many choices to eat and simplicity payment that will save your time

							And that’s where you come in. You’re an experienced professional with a passion for people and hospitality; someone who will proudly promote our brands while always striving to create the ultimate guest experience. At Prime you’ll enjoy competitive compensation and benefits, and advance your career with a team that values your contributions and helps you reach your goals.
						</p>
					</div>
				</div>
				 <!--<div class="row">
					<div class="col-md-12">
						<h4 class="page-head-line">CONTACT</h4>	!-->				
						<?php
							/* echo Html::well(Html::address(
							'Ruko De Mansion Blok C No.12',
							 ['Jl. Jalur Sutera, Alam Sutera, Serpong','Tangerang Selatan.'],
							 ['Tel ' => '(021) 3044-85-98/99'],
							 ['Fax ' => '(021) 3044 85 97'],
							 ['Website : ' => 'www.lukison.com', 'Email' => 'info@lukison.com']
							), Html::SIZE_TINY); */
						?>		
					<!--</div>
				</div>!-->				
			</div>				
		</div>
</div>

