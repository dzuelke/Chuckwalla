<?php $user = $t['user']; ?>
<form method="post" action="<?php echo $ro->gen('account'); ?>" class="ajaxForm">
<fieldset>
<legend class="icon" style="background-image:url('images/icons/user_edit.png')">Account Management</legend>
<?php if ($t['updated']): ?><div id="flash" class="flash">Details Updated</div><?php endif;?>
<dl>
	<dt><label for="email">email</label></dt>
	<dd><input type="text" name="email" id="email" value="<?php echo $user->getEmail();?>"/></dd>
</dl>
<dl>
	<dt><label for="password">Password</label></dt>
	<dd><input type="password" name="password" id="password" value=""/></dd>
</dl>
<dl>
	<dt><label for="password2">Password Again</label></dt>
	<dd><input type="password" name="password2" id="password2" /></dd>
</dl>
<div class='submit'>
	<input type="submit" name="update" id="update" value="update details" />
</div>
</fieldset>
</form>