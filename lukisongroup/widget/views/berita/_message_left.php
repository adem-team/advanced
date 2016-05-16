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
