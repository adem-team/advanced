
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use lukisongroup\hrd\models\Employe;
use lukisongroup\sales\models\Salesorderstatus;
use lukisongroup\sales\models\Sodetail;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use lukisongroup\sales\models\Barang;
use lukisongroup\sales\models\Unitbarang;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\models\esm\ro\RequestorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales Order';
$this->params['breadcrumbs'][] = $this->title;

$this->sideCorp = 'Sales Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_esm';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Sales Order');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

?>


<!-- aside class="main-sidebar">
    < ?php
		/*variable Dropdown*/
		use lukisongroup\models\system\side_menu\M1000;
		use kartik\sidenav\SideNav;
		$side_menu=\yii\helpers\Json::decode(M1000::find()->findMenu('esm')->one()->jval);		
		if (!Yii::$app->user->isGuest) {
			echo SideNav::widget([
				'items' => $side_menu,
				'encodeLabels' => false,
				//'heading' => $heading,
				'type' => SideNav::TYPE_DEFAULT,
				'options' => ['class' => 'sidebar-nav'],
			]);
		};
    ?>
</aside -->

 <div class="container">
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info fa fa-plus " data-toggle="modal" data-target="#myModal">&nbsp;Permintaan Barang (SO)</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">List Product</h4>
        </div>
        <div class="modal-body">
          
			<?php
			$empId = Yii::$app->user->identity->EMP_ID;
			$dt = Employe::find()->where(['EMP_ID'=>$empId])->all();
			$jbtan = $dt[0]['JOBGRADE_ID'];

			$form = ActiveForm::begin([
			'method' => 'post',
			'action' => ['/sales/sales-order/create'],
			]);



			$brgar['Barang ESM'] = $brgs = ArrayHelper::map(Barang::find()->all(), 'KD_BARANG', 'NM_BARANG');

			$unit = ArrayHelper::map(Unitbarang::find()->all(), 'KD_UNIT', 'NM_UNIT');
			?>
			<?php echo $form->field($sodetail, 'CREATED_AT')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?>	
			<?php echo $form->field($sodetail, 'NM_BARANG')->hiddenInput(['value' => ''])->label(false); ?>	

			
		
			<?php echo $form->field($sodetail, 'KD_BARANG')->dropDownList($brgar, ['prompt'=>' -- Pilih Salah Satu --','onchange' => '$("#sodetail-nm_barang").val($(this).find("option:selected").text())'])->label('Nama Barang'); ?>
			<?php echo $form->field($sodetail, 'QTY')->textInput(['maxlength' => true, 'placeholder'=>'Jumlah Barang']); ?>
			<?php echo $form->field($sodetail, 'NOTE')->textarea(array('rows'=>2,'cols'=>5))->label('Informasi'); ?>
			
	

			<div class="row">
			<div class="col-xs-6">
			<?php echo Html::submitButton( '<i class="fa fa-floppy-o fa-fw"></i>  Simpan', ['class' => 'btn btn-success']); ?>  
			<?php // echo Html::a('<i class="fa fa-print fa-fw"></i> Cetak', ['cetakpdf','kd'=>$id], ['target' => '_blank', 'class' => 'btn btn-warning']); ?>
			</div>
			</div>
			<?php
			ActiveForm::end(); 
			?>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

<div class="requestorder-index" style="padding:10px;">

   
    <hr/>

    <?php 
	
	
	
	$gridColumns = [
		['class' => 'yii\grid\SerialColumn'],
		'KD_RO',
		'nmemp',
		'CREATED_AT',
		
			[
				'format' => 'raw',
				'value' => function ($model) {
					$rodetail = new Sodetail();
					$dt = Sodetail::find()->where(['KD_RO'=>$model->KD_RO])->andWhere('STATUS <> 3')->count();
					$cn = Sodetail::find()->where(['KD_RO'=>$model->KD_RO, 'STATUS'=>1])->count();
					
					if ($model->STATUS == 1) {
						return Html::a('<i class="fa fa-check"></i> &nbsp;&nbsp;&nbsp;'.$cn.' Dari '.$dt, ['proses','kd'=>$model->KD_RO],['class'=>'btn btn-success btn-sm', 'title'=>'Detail']);
					} else if ($model->STATUS == 0) {
						return Html::a('<i class="fa fa-navicon"></i> &nbsp;&nbsp;&nbsp;&nbsp;Proses', ['proses','kd'=>$model->KD_RO],['class'=>'btn btn-danger btn-sm', 'title'=>'Detail']);
					} 
				},
			], 
			
		[
			'class' => 'yii\grid\ActionColumn',
			'template' => '{link} {edit} {delete} {cetak}',
			'buttons' => [
				'link' => function ($url,$model) { return Html::a('', ['view','kd'=>$model->KD_RO],['class'=>'fa fa-info-circle fa-lg', 'title'=>'Detail']);},
				'edit' => function ($url,$model) { return Html::a('', ['buatro','id'=>$model->KD_RO],['class'=>'fa fa-pencil-square-o fa-lg', 'title'=>'Ubah RO']); },
				'delete' => function ($url,$model) { if($model->STATUS == 0){ return Html::a('', ['hapusro','id'=>$model->KD_RO],['class'=>'fa fa-trash-o fa-lg', 'title'=>'Hapus RO','data-confirm'=>'Anda yakin ingin menghapus RO ini?']); } },
				'cetak' => function ($url,$model) { return Html::a('', ['cetakpdf','kd'=>$model->KD_RO],[ 'class'=>'fa fa-print fa-lg', 'target' => '_blank', 'title'=>'Cetak RO', 'data-pjax' => '0',]);},
			],
		],
	];
	
	/*
if($jbtan == 'MGR'){
} else { 
	$gridColumns = [
		['class' => 'yii\grid\SerialColumn'],
		'KD_RO',
		'nmemp',
		'KD_CORP',
		[
			'class' => 'yii\grid\ActionColumn',
			'template' => '{link} {edit} {delete} {cetak}',
			'buttons' => [
				'link' => function ($url,$model) { return Html::a('', ['view','kd'=>$model->KD_RO],['class'=>'fa fa-info-circle fa-lg', 'title'=>'Detail']);},
				'edit' => function ($url,$model) { return Html::a('', ['buatro','id'=>$model->KD_RO],['class'=>'fa fa-pencil-square-o fa-lg', 'title'=>'Ubah RO']); },
				'delete' => function ($url,$model) { return Html::a('', ['hapusro','id'=>$model->KD_RO],['class'=>'fa fa-trash-o fa-lg', 'title'=>'Hapus RO','data-confirm'=>'Anda yakin ingin menghapus RO ini?']); },
				'cetak' => function ($url,$model) { return Html::a('', ['cetakpdf','kd'=>$model->KD_RO],[ 'class'=>'fa fa-print fa-lg', 'target' => '_blank', 'title'=>'Cetak RO', 'data-pjax' => '0',]);},
			],
		],
	];
}	
	*/
	
		echo GridView::widget([
			'dataProvider'=> $dataProvider,
			'filterModel' => $searchModel,
			'columns' => $gridColumns,
			'rowOptions' => function ($model, $index, $widget, $grid) use($empId){
				
				$ro = new Salesorderstatus();
				$reqro = Salesorderstatus::find()->where(['KD_RO' => $model->KD_RO,'ID_USER' => $empId])->one();
				
				if(count($reqro) != 0){
					if($reqro->STATUS == 0){
						return ['class' => 'danger'];
					}else{
						return [];
					}
				}
			},			
			
			'pjax'=>true,
			'toolbar' => [
				'{export}',
			],
			'panel' => [
				'heading'=>'<h3 class="panel-title">'. Html::encode($this->title).'</h3>',
				'type'=>'warning',
				'before'=>Html::a('<i class="fa fa-plus fa-fw"></i> Permintaan Barang (SO)', ['create'], ['class' => 'btn btn-warning',
					'data' => [
						'confirm' => 'Anda yakin ingin membuat permintaan barang baru?',
						'method' => 'post',
					],
				]),
				'showFooter'=>false,
			],		
			
			'export' =>['target' => GridView::TARGET_BLANK],
			'exportConfig' => [
				GridView::PDF => [ 'filename' => 'permintaan-barang-'.date('ymdHis') ],
				GridView::EXCEL => [ 'filename' => 'permintaan-barang-'.date('ymdHis') ],
			],
		]);
		
	?>

</div>
<?php //// ?>