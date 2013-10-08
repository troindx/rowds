<script type="text/javascript">
function Translator()
{
	var strings;
	var that = this;
	var BASE_URL = '<?php echo BASE_URL; ?>';

	this.loadScript = function(url, callback)
	{
	    // Adding the script tag to the head as suggested before
	    var head = document.getElementsByTagName('head')[0];
	    var script = document.createElement('script');
	    script.type = 'text/javascript';
	    script.src = url;

	    // Then bind the event to the callback function.
	    // There are several events for cross browser compatibility.
	    script.onreadystatechange = callback;
	    script.onload = callback;

	    // Fire the loading
	    head.appendChild(script);
	};

	this.loadScriptCallback = function() 
	{
		console.log('foo');
	};

	this.loadLanguage = function(lang)
	{
		that.loadScript(BASE_URL+'lang/'+lang+'/exposed.js');
	};

	this.trans = function(arg)
	{
		return localStorage[arg];
	};
	
};
</script>