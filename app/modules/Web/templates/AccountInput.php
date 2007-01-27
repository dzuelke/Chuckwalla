<form method="post" action="<?php echo $ro->gen('account'); ?>">
<fieldset>
<legend class="icon" style="background-image:url('images/icons/user_edit.png')">Account Management</legend>
<dl>
	<dt><label for="email">email</label></dt>
	<dd><input type="text" name="email" id="email" /></dd>
</dl>
<dl>
	<dt><label for="password">Password</label></dt>
	<dd><input type="password" name="password" id="password" /></dd>
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