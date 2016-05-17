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
<div class="box box-success direct-chat direct-chat-success">
	 <!-- box-header -->
	<div class="box-header with-border">
		<h3 class="box-title"></h3>
		<div class="box-tools pull-right">
			<!--<span data-toggle="tooltip" title="3 New Messages" class="badge bg-green">3</span>-->
			<button class="btn btn-box-tool" data-toggle="tooltip" title="show/hide" data-widget="collapse"><i class="fa fa-minus"></i></button>
			<button class="btn btn-box-tool" data-toggle="tooltip" title="Attach" data-widget="chat-pane-toggle"><i class="fa fa-picture-o"></i></button>
			<!-- <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
		<!-- Conversations are loaded here -->
		<div class="direct-chat-messages">
			<!-- Message. Default to the left -->
			<?php
				// echo $model->ISI;
			?>
			<!-- Message to the right -->
		</div><!--/.direct-chat-messages-->
		<!-- Contacts are loaded here -->
		<div class="direct-chat-contacts">
			<ul class="contacts-list">
				<li>
					<?php

						//echo $headerImage;
						// echo $itemHeaderAttach;
					?>
				</li><!-- End Contact Item -->
			</ul><!-- /.contatcts-list -->
		</div><!-- /.direct-chat-pane -->
	</div><!-- /.box-body -->
		<div>
		<?php
						//echo $itemHeaderAttach;
		?>
		</div>
		<div>

		</div>
</div>
