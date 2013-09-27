<div class = "imglogo"><img src="views/main/img/killercorp.png"></img></div>
	
<div class ="fieldinput">
	<div class = "img"><img src="views/main/img/<?php echo $view->imageURL; ?>.jpg"></img></div>
	<div class = "name"><?php echo $view->name; ?>,<span> <?php echo utf8_decode($translator->trans('INVITED'));?></span></div>
	<div class = "info"></div>
	<div class = "mail"><input type="text" placeholder='<?php echo utf8_decode($translator->trans('ENTER_EMAIL'));?>'></input></div>
	<div class = 'button'><?php echo utf8_decode($translator->trans('PARTICIPATE'));?></div>
</div>