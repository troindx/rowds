<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo WEB_NAME ?></title>
<!--<link href='http://fonts.googleapis.com/css?family=Prosto+One' rel='stylesheet' type='text/css'> -->
<link rel="stylesheet" href="<?php echo "templates/$template/css/style.css" ?>" type="text/css" />
<!--[if lte IE 7]>
<link rel="stylesheet" href="<?php echo "templates/$template/css/ieonly.css" ?>" type="text/css" />
<![endif]-->
<?php global $loader; global $route; $loader->printScripts($route); ?>
</head>
<body>
	<div id="tablecontent" >
	<?php include("views/$name/$actionView.php");?>
		<div class="clearer"></div>
	</div>
</body>
</html>