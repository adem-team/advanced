<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\widgets\FileInput;
?>
	 <!--
			Hari, TanggalTempat
				 Waktu
				 Materi Rapat 
				 
				:  Selasa,28 Mei 2013:  Aula SMP Negeri …..
				:  10.00 s/d 12.00 WIB
				:  Persiapan Menyambut HUT RI Ke-68
				Rapat persiapan menyambut HUT RI Ke-68 ini dihadiri oleh :
				Pimpinan RapatNotulis
				Peserta
				Terdiri atas
				Tidak Hadir 	
				:  AISYA ALIYA MADINA (Ketua Osis):  AHMAD WAFA
				:  30 Orang
				:  Kepala Sekolah, Anggota OSIS dan Ketua Kelas 7, 8, 9
				:  Tida ada
		!-->
				
    <div class="col-xs-12 col-sm-6 col-dm-6 col-lg-6"  style="margin-left:0 ;padding-left: 0; padding-top:10px; margin-bottom: 10px">	
		<dl>
			<dt style="width:150px; float:left;">Memo.ID</dt>
			<dd style="color:rgba(87, 163, 247, 1)">:<b> <?php echo 'm12051601'; ?></b></dd>
			
			<dt style="width:150px; float:left;">Hari, Tanggal,Tempat</dt>
			<dd>: <?php echo "Selasa,28 Mei 2016  R.Meeting lt2";?></dd>
			
			<dt style="width:150px; float:left;">Title</dt>
			<dd>: <?php echo 'Judul Memo'; ?></dd>
			
			<dt style="width:150px; float:left;"><b>ISI MEMO</b></dt>
			<dd>: <?php echo 'Isi Memo';?></dd>     	  
		</dl>
    </div>
    <div class=" col-xs-12 col-sm-6 col-dm-6 col-lg-6"  style="padding-left:0;padding-top:10px;"  >
		<dl>
			<dt style="width:100px; float:left;">Company</dt>
			<dd>: <?php echo 'Lukisongroup';?></dd>
			
			<dt style="width:100px; float:left;">Location</dt>
			<dd>: <?php echo 'Demension c12'; ?></dd>			
		
		</dl>
    </div>
	
	<div class="row">
		<div class=" col-xs-12 col-sm-12 col-dm-12 col-lg-12">
			<?php $form = ActiveForm::begin([
			  //'id'=>$model->formName(),
			  'enableClientValidation' => true,
			  'enableAjaxValidation'=>true,
			  'validationUrl'=>Url::toRoute('/widget/berita/valid-berita-acara')
			]); ?>
			
			<?= $form->field($model, 'title')->widget(CKEditor::className(), [
					'options' => ['rows' => 6],
					'preset' => [
						//'height' => 400,
						'toolbarGroups' => [
							['name' => 'document', 'groups' => ['mode', 'document', 'doctools']],
							['name' => 'clipboard', 'groups' => ['clipboard', 'undo']],
							['name' => 'editing', 'groups' => [ 'find', 'selection', 'spellchecker']],
							['name' => 'forms'],
							'/',
							['name' => 'basicstyles', 'groups' => ['basicstyles', 'colors','cleanup']],
							['name' => 'paragraph', 'groups' => [ 'list', 'indent', 'blocks', 'align', 'bidi' ]],
							['name' => 'links'],
							['name' => 'insert'],
							'/',
							['name' => 'styles'],
							['name' => 'blocks'],
							['name' => 'colors'],
							['name' => 'tools'],
							['name' => 'others'],
						],
					],
					
				]) ?>
				
			<div class="form-group">
				<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>