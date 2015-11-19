<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model app\models\system\Dashboard */
?>
<div class="panel panel-default">
    <div class="dashboard-view" > Combo Department </div>
<div class="dashboard-view" >

				<?php
								
				$subCorp=[
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> PT.Sarana Sinar Surya',
						'active'=>true,
							'items'=>[
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Struktur Departmen',
									'encode'=>false,'content'=>'OK',
								],
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Visi/Misi Departmen','encode'=>false,
									'content'=>'AAAAA',
								],
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Stadard Kerja','encode'=>false,
									'content'=>'AAAAA',
								],									
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> JobsDesk','encode'=>false,
									'content'=>'AAAAA',
								],	
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> SOP','encode'=>false,
									'content'=>'AAAAA',
								],	
							],
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> PT.Arta Lipat Ganda',
							'items'=>[
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Struktur Departmen',
									'encode'=>false,'content'=>'OK',
								],
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Visi/Misi Departmen','encode'=>false,
									'content'=>'AAAAA',
								],
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Stadard Kerja','encode'=>false,
									'content'=>'AAAAA',
								],									
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> JobsDesk','encode'=>false,
									'content'=>'AAAAA',
								],	
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> SOP','encode'=>false,
									'content'=>'AAAAA',
								],	
							],				
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> PT.Efembi Sukses Makmur',
							'items'=>[
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Struktur Departmen',
									'encode'=>false,'content'=>'OK',
								],
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Visi/Misi Departmen','encode'=>false,
									'content'=>'AAAAA',
								],
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Stadard Kerja','encode'=>false,
									'content'=>'AAAAA',
								],									
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> JobsDesk','encode'=>false,
									'content'=>'AAAAA',
								],	
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> SOP','encode'=>false,
									'content'=>'AAAAA',
								],	
							],						
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> PT.Gosent',
							'items'=>[
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Struktur Departmen',
									'encode'=>false,'content'=>'OK',
								],
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Visi/Misi Departmen','encode'=>false,
									'content'=>'AAAAA',
								],
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Stadard Kerja','encode'=>false,
									'content'=>'AAAAA',
								],									
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> JobsDesk','encode'=>false,
									'content'=>'AAAAA',
								],	
								[
									'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> SOP','encode'=>false,
									'content'=>'AAAAA',
								],	
							],			
					],
				];
				
				echo TabsX::widget([						
						'items'=>$subCorp,
						'position'=>TabsX::POS_ABOVE,
						'height'=>TabsX::SIZE_TINY,
						'bordered'=>true,
						'encodeLabels'=>false,
						'align'=>TabsX::ALIGN_LEFT,						
					]);
				?>
				</div>
</div>