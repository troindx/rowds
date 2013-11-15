$.params = function(param_name){
    var value = new RegExp('[\\?&]' + param_name + '=([^&#]*)').exec(window.location.href);
    return value[1];
}

//view.php
$(window).load(function() {
	$('.login input').on('keyup', function() {
		if ($('.login input').val().length > 3 )
		{
			$('.loginButton').removeClass('hide');
			$('.info').fadeOut();

		}
	});

	$('.loginButton').on('click', function(){
		var jqxhr = $.ajax( {url: "index.php?option=main&action=login", data: { code: $('.login input').val() }} )
		  .done(function() {
		    console.log( "success" );
		    if (jqxhr.responseText == "-1")
		    {
		    	$('.info').addClass('error');
		    	$('.info').html('Acceso no autorizado');
		    	$('.info').fadeIn();
		    	return;
		    }
		    else
		    {
		    	$('.infoAssassin').hide();
		    	$('.login').fadeOut();
		    	localStorage['code']= $('.login input').val();
		    	var tmp = $.parseJSON(jqxhr.responseText);
		    	$('.assassinName').html(tmp.name +" tu objetivo es:");
		    	localStorage['id'] = tmp.id;
		    	$('.assassinImg').html('<img src="modules/main/img/'+tmp.imageURL +'.jpg"></img>');
		    	$('.infoAssassin').removeClass('hide');
		    	$('.infoAssassin').fadeIn();

		    	var jqxhr2 = $.ajax( {url: "index.php?option=main&action=getVictims", data: { id: tmp.id ,code: tmp.code  }} )
				  .done(function() {
				    if (jqxhr2.responseText != "-1")
				    {
				    	var tmp2 = $.parseJSON(jqxhr2.responseText);
				    	$('.victimIMG').html('<img src="modules/main/img/'+tmp2.imageURL +'.jpg"></img>');
				    	$('.victimInfo').html(tmp2.info);
				    	$('.victimName').html(tmp2.name);
				    }
				    else
				    {
				    	$('.info').addClass('error');
				    	$('.info').html('Acceso no autorizado');
				    	$('.info').fadeIn();
				    	return;
				    }
				  })
				  .fail(function() {
				    console.log( "error" );
				  })
				  .always(function() {
				    console.log( "complete" );
		  		});
		    }
	
		  })
		  .fail(function() {
		    console.log( "error" );
		  })
		  .always(function() {
		    console.log( "complete" );
  		});
	});


	$('.infoVictim input').on('keyup', function() {
		if ($('.infoVictim input').val().length > 3 )
		{
			$('.killButton').removeClass('hide');
		}
	});

		$('.killButton').on('click', function(){
		var jqxhr = $.ajax( {url: "index.php?option=main&action=kill", data: { code: $('.infoVictim input').val() }} )
		  .done(function() {
		  		 if (jqxhr.responseText != "-1")
		  		 {
		  		 	$('.info').removeClass('error');
		  		 	$('.info').addClass('success');
				    $('.info').html('Asesinato perpetrado con éxito, asignando un nuevo objetivo...');
				    $('.info').fadeIn(400, function(){$('.info').fadeOut(1500)});
				    var tmp2 = $.parseJSON(jqxhr.responseText);
				    $('.victimIMG').html('<img src="modules/main/img/'+tmp2.imageURL +'.jpg"></img>');
				    $('.victimInfo').html(tmp2.info);
				    $('.victimName').html(tmp2.name);


		  		 }
		  		 else
		  		 {
		  		 	$('.info').removeClass('success');
		  		 	$('.info').addClass('error');
				    $('.info').html('Código Erroneo, algo huele a caca aqui...');
				    $('.info').fadeIn(400, function(){$('.info').fadeOut(1500)});
				    return;
		  		 }
			  })
			  .fail(function() {
			    console.log( "error" );
			  })
			  .always(function() {
			    console.log( "complete" );
	  		});
  	});
});



//register.php
$(window).load(function (){
	$('.info').hide();
	$('.button').on('click', function(){
		  var tmp = $('.mail input').val().length;
		  if (tmp < 4)
		  {
		  	$('.info').html("Eso no parece un email.");
		  	$('.mail input').addClass('boxerror');
		  	$('.info').addClass('error');
		  	$('.info').fadeIn();
		  	return;
		  }
		  if ( $('.mail input').val().indexOf("@") <=0)
		  {
		  	$('.info').html("Tenemos conceptos diferentes de lo que es un email.");
		  	$('.mail input').addClass('boxerror');
		  	$('.info').addClass('error');
		  	$('.info').fadeIn();
		  	return;
		  }
		  if ( $('.mail input').val().indexOf(".") <=0)
		  {
		  	$('.info').html("Puede ser que no tengas claro lo que es un email. Buscalo en google.");
		  	$('.mail input').addClass('boxerror');
		  	$('.info').addClass('error');
		  	$('.info').fadeIn();
		  	return;
		  }
		  $('.mail input').fadeOut();
		  $('.info').hide();
		  $('.info').html('Procesando');
		  $('.info').removeClass('error');
		  $('.info').addClass('success');
		  $('.info').fadeIn();
		  $('.button').fadeOut();
		  var jqxhr = $.ajax( {url: "index.php?option=ajax&action=verifyregistration", data: { mail: $('.mail input').val(), security: $.params('k') }} )
		  .done(function() {
		    console.log( "success" );
		    if (jqxhr.responseText != "-1")
		    {
			    $('.info').hide();
			    $('.info').html('Tu c&oacute;digo es '+ jqxhr.responseText +'. No lo pierdas. Bienvenid@ a Killer Corp. Recibir&aacute;s noticias de tu objetivo pr&oacute;ximamente... Recuerda no revelarle a nadie que est&aacute;s jugando');
			    $('.info').fadeIn();
			}	
		    else
		    {
		    	$('.info').hide();
			    $('.info').html('Ha habido un problema con tu registro, ponte en contacto con la organización...');
			    $('.info').removeClass('success');
		  		$('.info').addClass('error');
			    $('.info').fadeIn();
		    }
		  })
		  .fail(function() {
		    console.log( "error" );
		  })
		  .always(function() {
		    console.log( "complete" );
  		});
	});
});