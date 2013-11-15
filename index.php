<?php
//load defines ,dependencies and classes
include("essential/defines.php");
include("essential/config.php");
include("essential/AutoLoader.php");
$loader= new AutoLoader();
$loader->loadDir('dependencies');
//$loader->loadDir('modules');
$Session = new Session();
//Start the module router
$router = new ModuleRouter();
$route = $router->loadRoute();

//load the default route and it's handlers
include("modules/$route/$route.php");
$loader->loadHandlers("modules/$route/handlers");
$loader->loadScripts($route);
$module = new $route;
$action = $router->loadAction($module);

//Load the action
$loader->setAction($action);
$loader->setRoute($route);
$module->preEvent();
$module->$action();
$module->postEvent();
?>
