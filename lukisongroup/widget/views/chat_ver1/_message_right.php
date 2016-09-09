<?php

use dosamigos\gallery\Gallery;
?>

<div class="direct-chat" style="margin-top:10px;margin-right:10px;font-family: tahoma ;font-size: 10pt;">
	<div class="direct-chat-msg direct-chat-info right">
		<div class="direct-chat-info clearfix" >
			<span class="direct-chat-name pull-right" style="margin-top:10px; margin-right:10px;font-family: tahoma ;font-size: 7pt;">
				<?php echo $nama;?>
			</span>
			<span class="direct-chat-timestamp pull-left" style="margin-top:10px; margin-right:10px;font-family: tahoma ;font-size: 7pt;"><?= $jamwaktu ?></span>
			</div>
			<img class="direct-chat-img" src=<?=$gambar; ?> alt="message user image">
			<div class="direct-chat-text" style="background-color:rgba(255, 223, 34, 0.5);color:black">
			<?php 
				echo $messageReply; 
				//echo $lampiran;	
			?>
		</div>
	</div>
</div>
