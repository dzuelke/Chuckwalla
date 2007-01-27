<?php $headerInfo = $t['headerInfo']; ?>
<h1 class="siteHeader"><?php echo $headerInfo['title']; ?> Agavi</h1>
<div>
<div id="menu">
<ul>
	<?php if(!$us->isAuthenticated()): ?>
		<li><a href="<?php echo $ro->gen('login'); ?>">Login</a></li>
	<?php else: ?>
		<li><a href="#">Messages 2</a></li>
		<li><a href="<?php echo $ro->gen('account'); ?>">Account Management</a></li>
		<li><a href="<?php echo $ro->gen('login').'/logout'; ?>">Logout</a></li>
	<?php endif; ?>
</ul>
</div>
</div>
	