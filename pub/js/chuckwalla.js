var Rules = {

  // Lets highlight all flash messages
  '.flash' : function(el) {
    new Effect.Highlight(el,{duration: 1});
  },

  // Lets Add Ajax Submission by all forms with the class ajaxForm!
  '.ajaxForm:submit': function(el, event) {
		var d = new Date();
		var time = d.getTime();
		var formVars = Form.serialize(el);
		console.log(formVars);
		new Ajax.Request(el.action, {
			method: 'post',
			parameters: formVars,
			onSuccess: function(transport) {
				var json = transport.responseText.parseJSON();
				var node = el.parentNode;
				node.innerHTML = json.content;
		  	}
		});
	Event.stop(event);
  },

  '.userinfo:click' : function(el, event) {
		if (!el.id)
			el = el.parentNode;
		var userid = el.id.split('-')[1];
		new Ajax.Request('/info',{
			method: 'post',
			parameters: 'user='+userid,
			onSuccess: function(transport) {
				var json = transport.responseText.parseJSON();
				$('lightbox-content').innerHTML = json.content;
				$('lightbox').show();
				$('overlay').show();	
		  	}	
		});
   },

	'#lightbox-close:click' : function(el, event) {
		$('lightbox-content').innerHTML = '';
		$('lightbox').hide();
		$('overlay').hide();
		Event.stop(e);	
   }

}

function onload () {EventSelectors.start(Rules);}

<!-- http://www.json.org/js.html -->
String.prototype.parseJSON = function (filter) {
	try {
    	if (/^("(\\.|[^"\\\n\r])*?"|[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t])+?$/.test(this)) {
            var j = eval('(' + this + ')');
            if (typeof filter === 'function') {
                function walk(k, v) {
                	if (v && typeof v === 'object') {
                    	for (var i in v) {
                        	if (v.hasOwnProperty(i)) {
                            	v[i] = walk(i, v[i]);
                            }
                        }
                     }
                    return filter(k, v);
                 }
                 return walk('', j);
            }
       return j;
     }
  } catch (e) {}
  throw new SyntaxError("parseJSON");
};