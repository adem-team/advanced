<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Json;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;


$this->params['breadcrumbs'][] = $this->title;

$this->sideCorp = 'Purchasing Stock';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'purchasing_stock';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Purchase Stock');      /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;
// print_r($tipe);
// die();             /* belum di gunakan karena sudah ada list sidemenu, on plan next*/
?>

<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
    <div  class="row">
      	<?php
				/*
				 * PURCHASE REPORT ALL
				 * @author ptrnov  [piter@lukison.com]
				 * @since 1.2
				*/
				$actionClass='btn btn-info btn-xs';
				$actionLabel='View';
				$attDinamik =[];
				/*GRIDVIEW ARRAY FIELD HEAD*/
				$headColomn=[
					// ['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','DATE'=>'DATE','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>$aryCorpID,'filterType'=>GridView::FILTER_SELECT2,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','DATE'=>'DATE','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>1, 'ATTR' =>['FIELD'=>'KD_PO','SIZE' => '10px','label'=>'PO','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>2, 'ATTR' =>['FIELD'=>'NM_BARANG','SIZE' => '12px','label'=>'NM_BARANG','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>3, 'ATTR' =>['FIELD'=>'UNIT','SIZE' => '11px','label'=>'UNIT','align'=>'right','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'decimal','filter'=>false,'filterType'=>false,'filterwarna'=>'74, 206, 231, 1']],
					['ID' =>4, 'ATTR' =>['FIELD'=>'PO_QTY','SIZE' => '10px','label'=>'QTY_PO','align'=>'left','warna'=>'74, 206, 231, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'74, 206, 231, 1']],
					['ID' =>5, 'ATTR' =>['FIELD'=>'QTY_RCVD','SIZE' => '10px','label'=>'QTY_RCVD','align'=>'left','warna'=>'74, 206, 231, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'74, 206, 231, 1']],
					['ID' =>6, 'ATTR' =>['FIELD'=>'QTY_REJECT','SIZE' => '10px','label'=>'QTY_REJECT','align'=>'right','warna'=>'74, 206, 231, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'74, 206, 231, 1']],
					['ID' =>7, 'ATTR' =>['FIELD'=>'QTY_RETURE','SIZE' => '10px','label'=>'QTY_RETURE','align'=>'right','warna'=>'74, 206, 231, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'74, 206, 231, 1']],
					// ['ID' =>9, 'ATTR' =>['FIELD'=>'SUB_TTL','SIZE' => '10px','label'=>'Sub Total','align'=>'right','warna'=>'74, 206, 231, 1','GRP'=>false,'FORMAT'=>'decimal','filter'=>false,'filterType'=>false,'filterwarna'=>'74, 206, 231, 1']],
					// ['ID' =>10, 'ATTR' =>['FIELD'=>'PAJAK','SIZE' => '10px','label'=>'PPN','align'=>'right','warna'=>'74, 206, 231, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'74, 206, 231, 1']],
				];
				/* 'ID','TGL','TYPE','KD_PO','KD_REF','KD_SPL','ID_BARANG','NM_BARANG','UNIT','UNIT_NM','UNIT_QTY','UNIT_WIGHT','QTY','NOTE:ntext','STATUS','CREATE_BY',
						'CREATE_AT','UPDATE_BY',
						'UPDATE_AT',
				*/
				$gvHeadColomn = ArrayHelper::map($headColomn, 'ID', 'ATTR');


				/*GRIDVIEW ARRAY ROWS*/
				foreach($gvHeadColomn as $key =>$value[]){
					$attDinamik[]=[
						'attribute'=>$value[$key]['FIELD'],
						'label'=>$value[$key]['label'],
						'filterType'=>$value[$key]['filterType'],
						'filter'=>$value[$key]['filter'],
						'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
						'hAlign'=>'right',
						'vAlign'=>'middle',
						//'mergeHeader'=>true,
						'noWrap'=>true,
						'group'=>$value[$key]['GRP'],
						'format'=>$value[$key]['FORMAT'],
						'headerOptions'=>[
								'style'=>[
								'text-align'=>'center',
								'width'=>$value[$key]['FIELD'],
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								//'background-color'=>'rgba(74, 206, 231, 1)',
								'background-color'=>'rgba('.$value[$key]['warna'].')',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>$value[$key]['align'],
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								//'background-color'=>'rgba(13, 127, 3, 0.1)',
							]
						],
						//'pageSummaryFunc'=>GridView::F_SUM,
						//'pageSummary'=>true,
						// 'pageSummaryOptions' => [
							// 'style'=>[
									// 'text-align'=>'right',
									//'width'=>'12px',
									// 'font-family'=>'tahoma',
									// 'font-size'=>'8pt',
									// 'text-decoration'=>'underline',
									// 'font-weight'=>'bold',
									// 'border-left-color'=>'transparant',
									// 'border-left'=>'0px',
							// ]
						// ],
					];
				};

				/*SHOW GRID VIEW LIST EVENT*/
				echo GridView::widget([
					'id'=>'puchase-rcvd-form',
					'dataProvider' => $dataProvider,
					//'filterModel' => $searchModel,
					//'filterRowOptions'=>['style'=>'background-color:rgba(74, 206, 231, 1); align:center'],
					'columns' => $attDinamik,
					/* [
						['class' => 'yii\grid\SerialColumn'],
						'start',
						'end',
						'title',
						['class' => 'yii\grid\ActionColumn'],
					], */
					'pjax'=>true,
					'pjaxSettings'=>[
						'options'=>[
							'enablePushState'=>false,
							'id'=>'puchase-rcvd-form',
						],
					],
					'panel' => [
								'heading'=>'<h3 class="panel-title">FORM RECIVED STOCK</h3>',
								'type'=>'info',
								'showFooter'=>false,
					],
					'toolbar'=> [
						''
					],
					'hover'=>true, //cursor select
					'responsive'=>true,
					'responsiveWrap'=>true,
					'bordered'=>true,
					'striped'=>true,
					'export' =>['target' => GridView::TARGET_BLANK],
					'exportConfig' => [
							GridView::PDF => [ 'filename' => 'Recived'.'-'.date('ymdHis') ],
							GridView::EXCEL => [ 'filename' => 'Recived'.'-'.date('ymdHis') ],
						],
					]);
				?>
	</div>
</div>

<div class="stock-rcvd-form">

    <?php $form = ActiveForm::begin(); ?>

     <!-- $form->field($model, 'TGL')->textInput() ?> -->
    <?= $form->field($model, 'TGL')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Dari  ...'],
    'pluginOptions' => [
       'autoclose'=>true,
       'format' => 'dd-mm-yyyy',
    ],

    'pluginEvents'=>[
           'show' => "function(e) {errror}",
               ],

    ])  ?>

     <!-- $form->field($model, 'TYPE')->textInput() ?> -->
     <!-- $form->field() -->
     <?= $form->field($model, 'TYPE')->widget(Select2::classname(), [
      'data' => $tipe,
      'options' => ['placeholder' => 'Select Type ...'],
      'pluginOptions' => [
            'allowClear' => true
       ],
      ]) ?>

    <?= $form->field($model, 'KD_PO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_REF')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_SPL')->textInput(['maxlength' => true]) ?>

     <!-- $form->field($model, 'ID_BARANG')->textInput(['maxlength' => true]) ?> -->
     <?= $form->field($model, 'ID_BARANG')->widget(Select2::classname(), [
      'data' => $brg,
      'options' => ['placeholder' => 'Select Type ...'],
      'pluginOptions' => [
            'allowClear' => true
       ],
      ]) ?>

    <?= $form->field($model, 'NM_BARANG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UNIT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UNIT_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UNIT_QTY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UNIT_WIGHT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QTY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <?php
    if(!$model->isNewRecord)
    {
       echo $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']);
    }

     ?>



     <!-- $form->field($model, 'CREATE_BY')->textInput(['maxlength' => true]) ?> -->

     <!-- $form->field($model, 'CREATE_AT')->textInput() ?> -->

     <!-- $form->field($model, 'UPDATE_BY')->textInput(['maxlength' => true]) ?> -->

     <!-- $form->field($model, 'UPDATE_AT')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php


 ?>
