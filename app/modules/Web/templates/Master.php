<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="<?php echo $t['_contentType']; ?>"/>
	<title><?php echo $t['_title']; ?></title>
	<base href="<?php echo $ro->getBaseHref(); ?>" />
	<title>Chuckwalla Bot</title>
	<link rel="stylesheet" type="text/css" href="css/base.css?ver=2" />
	<link rel="stylesheet" type="text/css" href="css/screen.css?ver=2" />
	<link rel="stylesheet" type="text/css" media="print" href="css/print.css?ver=2" />
	<script src="js/prototype.js" type="text/javascript"></script>
	<script src="js/scriptaculous/scriptaculous.js" type="text/javascript"></script>
	<script src="js/eventSelectors.js" type="text/javascript"></script>
	<script src="js/chuckwalla.js" type="text/javascript"></script>
</head>
<body>
	<div id="header">
				<div id="menu">
					<ul>
		<?php if(!$us->isAuthenticated()): ?>
						<li><a href="<?php echo $ro->gen('account.login'); ?>">Login</a></li>
		<?php else: ?>
						<li><a href="#">2 new memos</a></li>
						<li><a href="<?php echo $ro->gen('account'); ?>">My Account</a></li>
						<li><a href="<?php echo $ro->gen('account.logout'); ?>">Logout</a></li>
		<?php endif; ?>
					</ul>
				</div>
		<h1 class="siteHeader"><?php echo AgaviConfig::get('core.app_name'); ?></h1>
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
	<div id="lightbox" style='display:none;'><div id="lightbox-content"></div><div id="lightbox-close"><a href="#">Close</a></div></div>
	<div id="overlay" style='display:none;'></div>
</body>
</html>
