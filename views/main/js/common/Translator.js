function Translator()
{
	var strings;
	var that = this;
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
		this.strings = JSON.parse(that.loadScript('lang/'+lang+'/exposed.js'));
	};

	this.trans = function(arg)
	{
		return strings[arg];
	};
	
};