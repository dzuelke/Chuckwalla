<?php foreach($t['messages'] as $message): ?>
<tr>
	<td class="name"><?php echo $message->getNick()->getNick(); ?></td>
	<td class="message"><?php echo $message->getMessage(); ?></td>
	<td class="time"><?php echo $message->getDate(); ?></td>
</tr>
<?php endforeach; ?>