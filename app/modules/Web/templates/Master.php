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
	<script type="text/javascript">
		function onload() {
			// Toggle Rooms and people lists
			document.getElementsByClassName('toggles').each( function (el) { 
				toggleHeader = el.getElementsByClassName('toggleHeader')[0];
				toggleItem = el.getElementsByClassName('toggleItem')[0];
				Event.observe(toggleHeader, 'click', function (e) { toggleItem.toggle(); el.toggleClassName('toggleNames');})
			 });
			// Toggle Room Titles
			Event.observe($('roomTitle'), 'click', function  (e) {Event.element(e).toggleClassName('fullview');});
		}
	</script>
</head>
<body>
	<div id="header">
		<?php echo $slots['header']; ?>
	</div>	
	<div id="content">
		<div id="sidebar">
			<?php echo $slots['sidebar']; ?>
		</div>
		<div id="core" class="<?php echo (array_key_exists('coreClass', $t)) ? $t['coreClass'] : 'content' ;?>">
			<?php echo $slots['content']; ?>
		</div>
	</div>
	<div id="logo" class="transparent50"></div>
	<div id="footer">
		Powered by Chuckwalla
	</div>
</body>
</html>
