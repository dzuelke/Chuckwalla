<?php foreach ($t['channels'] as $channel): ?>
<dl id="<?php echo $channel->id; ?>" class="toggles">
	<dt class="toggleHeader channel"><?php echo $channel->name; ?></dt>
	<dd class="channelInformation"><?php echo $channel->number_of_members; ?> Member
		<?php if ($channel->number_of_members > 1) : ?>s<?php endif;?> 
		<dl class="members toggleItem">
			<?php foreach ($channel->users as $user): ?>
			<dd id="<?php echo $channel->name.'_'.$user->name; ?>" class="user"><?php echo $user->name;?></dd>
			<?php endforeach;?>
		</dl>
	</dd>
</dl>
<?php endforeach; ?>

<ul>
	<li>
		<div>#agavi</div>
		<ul>
			<li><a href="#">splatch</a></li>
			<li><a href="#">MrJeep</a></li>
			<li><a href="#">RossC0</a></li>
			<li><a href="#">Wombert</a></li>
		</ul>
	</li>
</ul>
