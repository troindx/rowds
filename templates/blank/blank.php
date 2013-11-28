<?php
 global $loader;
 include("modules/$name/views/$actionView.php");
 $loader->printJSController($name);
 ?>
