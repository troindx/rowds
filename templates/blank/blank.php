<?php
 global $loader;
 $loader->printJSController($name);
 include("modules/$name/$actionView.php");
 ?>
