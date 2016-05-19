<?php
/* extensions */
use kartik\helpers\Html;
?>
<div class="direct-chat" style="margin-top:10px;font-family: tahoma ;font-size: 10pt;">
	<div class="direct-chat-msg">
		<div class="direct-chat-info clearfix">
			<span class="direct-chat-name pull-left" style="margin-top:10px;font-family: tahoma ;font-size: 7pt;">
				<?php echo $nama;?>
			</span>
			<span class="direct-chat-timestamp pull-right" style="margin-top:10px;font-family: tahoma ;font-size: 7pt;"><?= $jamwaktu ?></span>
			</div>
			<img class="direct-chat-img" src=<?=$profile; ?> alt="message user image">
			<div class="direct-chat-text">
			<?php
				echo $messageReply;
				//echo $lampiran;
			?>
		</div>
	</div>
</div>
<!-- HEADER JUDUL/ISI/ATTACH ptr.nov-->
<div class="box box-success direct-chat direct-chat-success collapsed-box">
	 <!-- box-header -->
	<div class="box-header with-border">
		<h3 class="box-title"></h3>
		<div class="box-tools pull-right">
			<!--<span data-toggle="tooltip" title="3 New Messages" class="badge bg-green">3</span>-->
			<button class="btn btn-box-tool" data-toggle="tooltip" title="show/hide" data-widget="collapse"><i class="fa fa-minus"></i></button>
			<!-- <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
		</div>
	</div><!-- /.box-header -->
	<div class="box-body" style="display: none;">
		<!-- Conversations are loaded here -->
		<div class="direct-chat-messages">
			<!-- Message. Default to the left -->
			<?php

			if(count($attach_image) == 0)
			{
				for($a = 0; $a < 2; $a++)
				{
				echo Html::img(Yii::getAlias('@web').'/upload/barang/df.jpg', ['width'=>'130','height'=>'130', 'align'=>'center' ,'class'=>'img-thumbnail']);
				}
			}else{
				// $item = [];
				foreach ($attach_image as $key => $value) {
					# code...


						// Html::img('data:image/jpg;base64,'.$value->ATTACH64, ['class' => 'pull-left img-thumbnail','width'=>"120px",'height'=>"120px"]);
					// $item[]= ['img'=>'data:image/jpg;base64,'.$value->ATTACH64];

				$fotorama = \metalguardian\fotorama\Fotorama::begin(
        [
            'options' => [
                'loop' => true,
                'hash' => true,
                'ratio' => 800/600,
								  'width' => '50%',
            ],
            'spinner' => [
                'lines' => 20,
            ],
            'tagName' => 'span',
            'useHtmlData' => false,
            'htmlOptions' => [
                'class' => 'custom-class',
                'id' => 'custom-id',
            ],
        ]
    );
    ?>
		<?php
		// $data;
		echo '<img src=data:image/jpg;base64,'.$value->ATTACH64.'></img>';
	}
		 ?>

    <?php $fotorama->end(); }?>




		<!-- // 	echo \metalguardian\fotorama\Fotorama::widget(
	  //       [
	  //           'items' => [
	  //               $item
	  //           ],
	  //           'options' => [
	  //               'nav' => 'thumbs',
	  //           ]
	  //       ]
	  //   );
		// }

			?> -->

				<!-- // echo $model->ISI; -->

			<!-- Message to the right -->
		</div><!--/.direct-chat-messages-->
		<!-- Contacts are loaded here -->
	</div><!-- /.box-body -->
		<div>
		<?php
						//echo $itemHeaderAttach;
		?>
		</div>
		<div>

		</div>
</div>
