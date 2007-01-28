<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="<?php echo $t['_contentType']; ?>"/>
	<title><?php echo $t['_title']; ?></title>
	<base href="<?php echo $ro->getBaseHref(); ?>" />
	<title>Chuckwalla Bot</title>
	<link rel="stylesheet" type="text/css" href="css/base.css?ver=1" />
	<link rel="stylesheet" type="text/css" href="css/screen.css?ver=1" />
	<link rel="stylesheet" type="text/css" media="print" href="css/print.css?ver=1" />
	<script src="js/prototype.js" type="text/javascript"></script>
	<script src="js/scriptaculous/scriptaculous.js" type="text/javascript"></script>
	<script src="js/eventSelectors.js" type="text/javascript"></script>
	<script src="js/chuckwalla.js" type="text/javascript"></script>
</head>
<body>
	<div id="header">
		<h1 class="siteHeader"><?php echo AgaviConfig::get('core.app_name'); ?></h1>
		<!-- <div>
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
		</div> -->
	</div>
	<div id="content">
		<div id="sidebar"> 
<?php echo $slots['sidebar']; ?>
		</div>
		<div id="core" class="<?php echo (array_key_exists('coreClass', $t)) ? $t['coreClass'] : 'content' ;?>">
<?php echo $slots['content']; ?>
		</div>
	</div>
	<div id="footer">Powered by <a href="http://www.agavi.org/">Chuckwalla</a></div>
</body>
</html>
