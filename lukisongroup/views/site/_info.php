	<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
	/*
	$attribute = [
		[
			'attribute' =>'EMP_ID',
			//'inputWidth'=>'20%'
			//'inputContainer' => ['class'=>'col-md-1'],
		],
		[
			'attribute' =>	'EMP_NM',
			//'inputWidth'=>'40%'
		],
		[
			'attribute' =>	'EMP_NM_BLK',
			//'inputWidth'=>'40%'
		],
		[
			'attribute' =>	'EMP_KTP' ,
		],
		[
			'attribute' =>	'EMP_ALAMAT' ,
		],
		[
			'attribute' =>	'EMP_ZIP' ,
		],
		[
			'attribute' =>	'EMP_TLP' ,
		],
		[
			'attribute' =>	'EMP_HP' ,
		],
	];
	$form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]);

	$test1= DetailView::widget([
		'model' => $model,
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'panel'=>[
			'heading'=>$model->EMP_NM . ' '.$model->EMP_NM_BLK,
			'type'=>DetailView::TYPE_INFO,
		],

			'attributes'=>$attribute,


		'deleteOptions'=>[
			'url'=>['delete', 'id' => $model->EMP_ID],
			'data'=>[
				'confirm'=>Yii::t('app', 'Are you sure you want to delete this record?'),
				'method'=>'post',
			],
		],
	]);
ActiveForm::end();

	*/

	?>
	
	<div class="col-xs-12 col-sm-3 col-dm-2 col-lg-2"  style="valign:bottom; margin-left:0 ; text-align: center"  >
      	<img src="<?= Yii::getAlias('@HRD_EMP_UploadUrl') .'/'. $model->EMP_IMG; ?>" class="img-thumbnail" alt="Cinque Terre" width="auto" height="auto"/>
	</div>
	
    <div class="col-xs-12 col-sm-5 col-dm-3 col-lg-3"  style="margin-left:0 ;padding-left: 0; padding-top:10px; margin-bottom: 20px">

      <table id="table1" style="display:block;padding-left: 0">
		<tr>
			<td width="auto"  valign="top">Name  </td>
			<td valign="top" style="padding-left: 2px"> :</td>
			<td  width="auto">Piter Novian asdas asdasd zasdas asdas</td>
		</tr>
		<tr>
			<td width="auto"> Jabatan </td>
			<td valign="top" style="padding-left: 2px"> :</td>
			<td  width="auto">This table will  </td>
		</tr>
		<tr>
			<td width="auto"> Company </td>
			<td valign="top" style="padding-left: 2px"> :</td>
			<td  width="auto">This table will  </td>
		</tr>


	</table>

    </div>
    <div class=" col-xs-12 col-sm-4 col-dm-3 col-lg-3"  style="padding-left:0 "  >
     <table id="table1" style="display:block;">
		<tr>
			<td width="auto"> table </td>
			<td width="1px" style="padding-left: 10px"> :</td>
			<td  width="auto">This table will  </td>
		</tr>
		<tr>
			<td width="auto"> table </td>
			<td width="1px" style="padding-left: 10px"> :</td>
			<td  width="auto">This table will  </td>
		</tr>
		<tr>
			<td width="auto"> table </td>
			<td width="1px" style="padding-left: 10px"> :</td>
			<td  width="auto">This table will  </td>
		</tr>
          <tr>
              <td width="auto"> table </td>
              <td width="1px" style="padding-left: 10px"> :</td>
              <td  width="auto">This table will  </td>
          </tr>
          <tr>
              <td width="auto"> table </td>
              <td width="1px" style="padding-left: 10px"> :</td>
              <td  width="auto">This table will  </td>
          </tr>
	</table>
    </div>
   