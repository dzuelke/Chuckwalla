<form method="post" action="<?php echo $ro->gen('login'); ?>">
<fieldset>
<legend class="icon" style="background-image:url('images/icons/user_add.png')">Login</legend>
<dl>
<dt><label for="username">User Name</label></dt>
<dd><input type="text" name="username" id="username" /></dd>
</dl>
<dl>
<dt><label for="password">Password</label></dt>
<dd><input type="password" name="password" id="password" /></dd>
</dl>
<div class='login'>
	<input type="submit" name="login" id="login" value="login" />
</div>
</fieldset>
</form>