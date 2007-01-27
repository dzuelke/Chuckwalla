<form method="post" action="<?php echo $ro->gen('login'); ?>">
<fieldset>
<legend class="icon" style="background-image:url('images/icons/user_add.png')">Login</legend>
<dl>
<dt><label for="email">email</label></dt>
<dd><input type="text" name="email" id="email" value="<?php echo $t['email']; ?>" /></dd>
</dl>
<dl>
<dt><label for="password">Password</label></dt>
<dd><input type="password" name="password" id="password" value="<?php echo $t['password']; ?>" /></dd>
</dl>
<dl>
<dt><label for="remember">Remember Me</label></dt>
<dd><input type="checkbox" name="remember" id="remember" <?php if ($t['email']) echo 'checked'; ?>"/></dd>
</dl>
<div class='submit'>
	<input type="submit" name="login" id="login" value="login" />
</div>
</fieldset>
</form>
