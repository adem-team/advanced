<?php

use yii\helpers\Html;
use kartik\grid\GridView;

use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use lukisongroup\models\master\Suplier;
use lukisongroup\models\hrd\Employe;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\models\esm\po\PurchaseorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchaseorder';
$this->params['breadcrumbs'][] = $this->title;


    $idEmp = Yii::$app->user->identity->EMP_ID;
    $emp = Employe::find()->where(['EMP_ID'=>$idEmp])->one();
    $kr = $emp->DEP_SUB_ID;

?>

<div class="purchaseorder-index" style="padding:10px;">

<script type="text/javascript">
function submitform()
{
  document.myform.submit();
}
</script>

    <!-- h1>< ?= Html::encode($this->title) ?></h1 -->
<?php if( $kr == 'HR-02'){ ?>
	<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus fa-fw"></i> Buat PO</button>
	<br/><br/>
<?php } ?>

<?php 
	$gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],

        //'ID',
        'KD_PO',
        'KD_SUPPLIER',
        'pembuat',
        'disetujui',
        'approved',
        // 'APPROVE_BY',
        // 'APPROVE_AT',
        // 'STATUS',
        // 'NOTE:ntext',


        ['class' => 'yii\grid\ActionColumn',
		'template' => '{link} {edit}',
		'buttons' => [
			'link' => function ($url,$model) { return Html::a('', ['view','kd'=>$model->KD_PO],['class'=>'glyphicon glyphicon-eye-open', 'title'=>'Detail']);},

			'edit' => function ($url,$model) use ($kr) { 
				if( $kr == 'HR-02'){ 
					return Html::a('', ['create','kdpo'=>$model->KD_PO],['class'=>'glyphicon glyphicon-pencil', 'title'=>'Ubah RO']); 
				}
			} ,

			],
        ],
	];

	echo GridView::widget([
			'dataProvider'=> $dataProvider,
			'filterModel' => $searchModel,
			'columns' => $gridColumns,
			'pjax'=>true,
			'toolbar' => [
				'{export}',
			],
			'panel' => [
				'heading'=>'<h3 class="panel-title"></h3>',
				'type'=>'warning',
				'before'=> '',
				'showFooter'=>false,
			],		
			
			'export' =>['target' => GridView::TARGET_BLANK],
			'exportConfig' => [
				GridView::PDF => [ 'filename' => 'PO-'.date('ymdHis') ],
				GridView::EXCEL => [ 'filename' => 'PO-'.date('ymdHis') ],
			],
		]);
		
?>
    <!-- ?= GridView::widget([
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
    ]); ? -->

</div>

    <p>
		<!-- Button trigger modal - - >
		< button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
		  Buat PO
		</button >

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
			    <?= $form->field($model, 'KD_SUPPLIER')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Supplier'); ?>
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

