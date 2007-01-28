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
			if ($('roomTitle'))
				Event.observe($('roomTitle'), 'click', function  (e) {Event.element(e).toggleClassName('fullview');});
			// Lets highlight all flash messages
			document.getElementsByClassName('flash').each( function (el) { new Effect.Highlight(el,{duration: 1});});
			
			// Lets Add Ajax Submission by all forms with the class ajaxForm!
			document.getElementsByClassName('ajaxForm').each( function (el) { 
				Event.observe(el, 'submit', function (e) {
					var d = new Date();
					var time = d.getTime();
					var formVars = Form.serialize(el);
					console.log(formVars);
					new Ajax.Request(el.action, {
				  		method: 'post',
				  		parameters: formVars,
				  		onSuccess: function(transport, json) {
				    		console.log(transport);
							//console.log(json);
				  		}
					});
					Event.stop(e);
				});
			});
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
