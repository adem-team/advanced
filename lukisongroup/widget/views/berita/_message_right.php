<div class="direct-chat direct-chat-info" style="margin-top:10px;font-family: tahoma ;font-size: 10pt;">
	<div class="direct-chat-msg direct-chat-danger right">
		<div class="direct-chat-info clearfix">
			<span class="direct-chat-name pull-right">
				<?php echo $nama;?>
			</span>
			<span class="direct-chat-timestamp pull-left"><?= $jamwaktu ?></span>
			</div>
			<img class="direct-chat-img" src=<?=$profile; ?> alt="message user image">
			<div class="direct-chat-text">
			<?php echo $messageReply; ?>
		</div>
	</div>
</div>