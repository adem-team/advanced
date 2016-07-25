<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model modulprj\master\models\IjinDetail */

$pass = Yii::$app->getSecurity()->decryptByPassword($model->password_hash, $model->password_hash);

	/*Customers info*/
	$cusviewinfo=DetailView::widget([
		'model' => $model,
		'attributes' => [
			[
				'attribute' =>'username',
				'label'=>'Nama',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			[
				'attribute' =>'email',
				'label'=>'Email:',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			[ 	//STATUS
			'attribute' =>'status',
			'format'=>'raw',
			'value'=>$model->status ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>',
	
	]
			
		],
	]);

	
	
	
	
	
	
?>
<div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="row" >
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<?= $cusviewinfo ?>
		</div>
	</div>
</div>
