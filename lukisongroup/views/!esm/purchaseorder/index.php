<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use lukisongroup\models\master\Suplier;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\models\esm\po\PurchaseorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchaseorders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchaseorder-index">

<script type="text/javascript">
function submitform()
{
  document.myform.submit();
}
</script>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
		  Buat PO
		</button>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Pilih Supplier</h4>
				  </div>
				  
    			<?php $form = ActiveForm::begin([
					'type' => ActiveForm::TYPE_HORIZONTAL,
					'method' => 'post',
					'action' => ['esm/purchaseorder/simpanpo'],
				]); ?>
				  <div class="modal-body">
					
				<?php $drop = ArrayHelper::map(Suplier::find()->where(['STATUS' => 1])->all(), 'KD_SUPPLIER', 'NM_SUPPLIER'); ?>
			    <?= $form->field($model, 'KD_SUPPLIER')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Supplier') ?>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" >Save changes</button>
				  </div> 
  				<?php ActiveForm::end(); ?>
			</div>
		  </div>
		</div>
		
        <?php //= Html::a('Create Purchaseorder', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'KD_PO',
            'KD_SUPPLIER',
            'CREATE_BY',
            'CREATE_AT',
            // 'APPROVE_BY',
            // 'APPROVE_AT',
            // 'STATUS',
            // 'NOTE:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
