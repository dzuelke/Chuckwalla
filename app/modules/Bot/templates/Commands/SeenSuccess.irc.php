<?php if($t['result']['is_online']): ?> 
The user <?php echo $t['nickname']; ?> is currently online
<?php else: ?>
The user <?php echo $t['nickname']; ?> was last seen at <?php /*$tm->_d($t['last_quit_time']); */?>
<?php endif; ?>