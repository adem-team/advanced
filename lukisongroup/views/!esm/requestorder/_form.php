<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

//use yii\widgets\ActiveForm;
/*
use lukisongroup\models\esm\ro\RequestorderSearch;
use lukisongroup\models\esm\ro\Roatribute;

use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\widgets\FileInput;


*/

use lukisongroup\models\esm\ro\Requestorder;
use lukisongroup\models\esm\ro\Rodetail;
use lukisongroup\models\master\Barangumum;
use lukisongroup\models\master\Unitbarang;

use lukisongroup\models\hrd\Employe;

use yii\grid\GridView;
use yii\data\ActiveDataProvider;

use kartik\widgets\ActiveForm;
use kartik\widgets\DepDrop;


/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\ro\Requestorder */
/* @var $form yii\widgets\ActiveForm */

/*
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,  'action' => ['controller/action'],]);

//$customers = Rodetail::find()->where('KD_RO = 1')->all();
//$reqorder->rodet->NO_URUT;
//$customers = Rodetail::find()->where(['KD_RO = 1' ])->all();


echo FormGrid::widget([
	'model'=>$rodetail,
	'form'=>$form,
	'autoGenerateColumns'=>true,
	'rows'=>[
        [
            'contentBefore'=>'<legend class="text-info"><small>Buat Permintaan Barang</small></legend>',
            'attributes'=>[       // 2 column layout
				'NO_URUT' => ['type' => Form::INPUT_TEXT],
				'KD_BARANG' => ['type' => Form::INPUT_TEXT],
//				'NM_BARANG' => ['type' => Form::INPUT_TEXT],
				'QTY' => ['type' => Form::INPUT_TEXT],
            ]
        ],
		
	],		
]);
*/


$id=$_GET['id'];	
$ros = Requestorder::find()->joinWith('employe')->where(['KD_RO' => $id])->asArray()->all(); 

?>

<div class="requestorder-form" style="margin:0px 20px;">
<form class="form-horizontal">

	<div class="form-group">
		<div class="col-sm-12">
			<br/>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-2 control-label">Nama User</label>
		<div class="col-sm-5">
			<input type="email" class="form-control" id="inputEmail3" value="<?php echo $ros[0]['employe']['EMP_NM'].' '.$ros[0]['employe']['EMP_NM_BLK']; ?>" readonly >
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-2 control-label">Perusahaan</label>
		<div class="col-sm-5">
			<input type="email" class="form-control" id="inputEmail3" value="<?php echo $ros[0]['employe']['EMP_CORP_ID']; ?>" readonly >
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Departement</label>
		<div class="col-sm-5">
			<input type="email" class="form-control" id="inputEmail3" value="<?php echo $ros[0]['employe']['DEP_ID']; ?>" readonly >
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-12">
			<br/>
		</div>
	</div>

 </form>
 
 
<?php

$form = ActiveForm::begin([
    'method' => 'post',
    'action' => ['esm/requestorder/simpan?id='.$id],
]);


	$brg = ArrayHelper::map(Barangumum::find()->all(), 'KD_BARANG', 'NM_BARANG');
	$unit = ArrayHelper::map(Unitbarang::find()->all(), 'KD_UNIT', 'NM_UNIT');
?>
<?php echo $form->field($rodetail, 'CREATED_AT')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?>	
<?php echo $form->field($rodetail, 'NM_BARANG')->hiddenInput(['value' => ''])->label(false); ?>	

<?php echo $form->field($rodetail, 'KD_RO')->textInput(['value' => $id, 'readonly' => true])->label('Kode Request Order'); ?>

<div class="row">
  <div class="col-xs-3"><?php echo $form->field($rodetail, 'KD_BARANG')->dropDownList($brg, ['prompt'=>' -- Pilih Salah Satu --','onchange' => '$("#rodetail-nm_barang").val($(this).find("option:selected").text())'])->label('Nama Barang'); ?></div>
  <div class="col-xs-3"><?php echo $form->field($rodetail, 'QTY')->textInput(['maxlength' => true, 'placeholder'=>'Jumlah Barang']); ?></div>
  <div class="col-xs-3"><?php echo $form->field($rodetail, 'UNIT')->dropDownList($unit, ['prompt'=>' -- Pilih Salah Satu --']); ?></div>
  <div class="col-xs-3"><?php echo $form->field($rodetail, 'NOTE')->textInput(['maxlength' => true, 'placeholder'=>'Catatan Barang']); ?></div>
</div>

<div class="row">
  <div class="col-xs-6">
	  <?php echo Html::submitButton( '<i class="fa fa-floppy-o fa-fw"></i>  Simpan', ['class' => 'btn btn-success']); ?>  
	  <?php echo Html::a('<i class="fa fa-print fa-fw"></i> Cetak', ['cetakpdf','kd'=>$id], ['target' => '_blank', 'class' => 'btn btn-warning']); ?>
</div>
</div>
<?php
 ActiveForm::end(); 
 ?>

<?php
 $que = Rodetail::find()->where(['KD_RO' => $id])->andWhere('STATUS <> 3');; 
 
echo "<br/><br/>";

        $dataProvider = new ActiveDataProvider([
            'query' => $que,
        ]);
		
		
		echo GridView::widget([
        'dataProvider' => $dataProvider,
		
        'columns' => [
         //specify the colums you wanted here
			//'KD_BARANG', 
			'NM_BARANG', 'QTY', 'UNIT',  'NOTE', 
			
			
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{hapus}',
				'buttons' => [
/*
					'hapus' => function ($url,$model,$key) {
							return Html::a('<span class="glyphicon glyphicon-trash"></span>', [$url, 'kode' =>$_GET['id'] ]);
					},
					*/
					
					'hapus' => function ($model,$key) {
						if($key->STATUS == 0){
							return Html::a( '<span class="glyphicon glyphicon-trash"></span>',['hapus','kode'=>$_GET['id'], 'id'=>$key->ID], ['data-confirm'=>'Anda yakin ingin menghapus barang ini?','title'=>'Hapus']  );
						}
					},
				],

				//'botton'=>[
				//	'delete'=> function()
				//],
			],
			
        ],
		]);
		
/*
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'responsive'=>true,
    'hover'=>true
]);*/
?>

<!-- div class="requestorder-form">

    <?php // $form = ActiveForm::begin(); 
	
	
	?>
	<?php
$form = ActiveForm::begin([
    'method' => 'post',
    'action' => ['esm/requestorder/create'],
]);
	?>

    <?= $form->field($model, 'KD_RO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_USER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_CORP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_CAB')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_DEP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATED_ALL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DATA_ALL')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div -->


<br/><br/><br/>
</div>