<div class="direct-chat" style="margin-top:15px;margin-right:10px;font-family: tahoma ;font-size: 10pt;">
	<div class="direct-chat-msg direct-chat-danger right">
		<div class="direct-chat-danger clearfix">
			<span class="direct-chat-name pull-right" style="margin-top:10px; margin-right:10px;font-family: tahoma ;font-size: 7pt;">
				<?php echo $nama;?>
			</span>
			<span class="direct-chat-timestamp pull-left" style="margin-top:10px; margin-right:10px;font-family: tahoma ;font-size: 7pt;"><?= $jamwaktu ?></span>
		</div>
			<img class="direct-chat-img" src=<?=$gambar; ?> alt="message user image">
		
		<div class="direct-chat-text" style="background-color:rgba(181, 234, 255, 1)" >
			<?php 
				echo $messageReply; 
				//echo $lampiran;	
			?>
		</div>
	</div>
</div>
