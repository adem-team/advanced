<?php
/* @var $this yii\web\View */
use kartik\helpers\Html;
$this->title = 'lukisongroup';
?>


<div class="content">
			<div class="content">					
				
				 <div class="row">
					<div class="col-md-12">						
						<h4 class="page-head-line">Contact Us</h4>
						<?php
							echo Html::well(Html::address(
							'Ruko De Mansion Blok C No.12',
							 ['Jl. Jalur Sutera, Alam Sutera, Serpong','Tangerang Selatan.'],
							 ['Tel ' => '(021) 3044-85-98/99'],
							 ['Fax ' => '(021) 3044 85 97'],
							 ['Website : ' => 'www.lukison.com', 'Email' => 'info@lukison.com']
							), Html::SIZE_TINY); 
						?>	
					</div>
				</div>
				 	
			</div>				
		</div>
</div>
