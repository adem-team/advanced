<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'lukisongroup';
?>


<div class="content">
	<div class="content">					
				
			<div class="row">
				<div class="col-md-12" >						
					<h4 class="page-head-line">e-Procurement</h4>
						<p>e-Procurement modul lelang ..... Lukison group considered being one of the largest premium food court in the city and it is a great mix of old favorites and new restaurants. With the large space more than 2000m2 and futuristic and old style design, Lukison offered a coz/ambiance and warm place to enjoy your dinning experiences.

		complete with 3D lenticular light box and vintage wood plank will make the visitors feel relax and chill with new ambiance that they can’t discover in another place. With all variety of different kinds of food, Lukison give you many choices to eat and simplicity payment that will save your time

		And that’s where you come in. You’re an experienced professional with a passion for people and hospitality; someone who will proudly promote our brands while always striving to create the ultimate guest experience. At Prime you’ll enjoy competitive compensation and benefits, and advance your career with a team that values your contributions and helps you reach your goals.</p>

				</div>					
				<div class="col-md-12" style="padding-top:50px">	
					<div class="row">
						<div class="col-md-8">	
							<div>
								<h5 class="page-head-line1">A. e-Procurement, Session Periode : 03-11-2015 s/d 10-11-2015</h5>
								e-Procurement Items Order
							</div>						
								<?php echo GridView::widget([
											'dataProvider' => $dataProvider,
											'filterModel' => $searchModel,
											'columns' => [
												['class' => 'yii\grid\SerialColumn'],

												//'ID',
												//'PRC_BRG_ID',
												'GROUP',
												'PRC_BRG_NM',
												'KATEGORI',
												'PRC_BRG_SPEK:ntext',
												'PRC_BRG_DCRP:ntext',
												
												// 'TGL_START',
												// 'TGL_END',
												// 'CREATED_BY',
												// 'UPDATED_BY',
												// 'UPDATED_TIME',

												['class' => 'yii\grid\ActionColumn', 
													'template' => '{view}{edit}',
													'header'=>'Action',
													'buttons' => [
														'view' =>function($url, $model, $key){
																return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px; height:30px">View </button>',['/front/procurement/view','id'=>$model->ID],[
																							'data-toggle'=>"modal",
																							'data-target'=>"#gv-proc-item",													
																							'data-title'=> $model->ID,
																							]);
														},					
													],
												],
											],
											'pjax'=>true,
											'pjaxSettings'=>[
												'options'=>[
													'enablePushState'=>false,
													'id'=>'active',
												 ],
											],
											'hover'=>true, 
											'responsive'=>true,
											'responsiveWrap'=>true,
											'bordered'=>true,
											'striped'=>'4px',
											'autoXlFormat'=>true,
											'export'=>[
												'fontAwesome'=>true,
												'showConfirmAlert'=>false,
												'target'=>GridView::TARGET_BLANK
											],
										]); 
								?>
						</div>
						<div class="col-md-4">
							<h5 class="page-head-line1">B. Supplier Register</h5>
						</div>
					</div>					
				</div>
				

			</div>
				








				
	</div>				
</div>

