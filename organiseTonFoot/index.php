<?php
session_start();
$path = str_replace(DIRECTORY_SEPARATOR,'/',realpath(dirname(__FILE__)));

//define constants
define("ROOT_DIR", $path);
define("ROOT_DIR_SRC", $path . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR);
define("ROOT_DIR_CONFIG", $path . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR);
define("ROOT_DIR_PUBLICS", $path . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR);

//include url utils
require_once (ROOT_DIR_SRC . 'utils/UrlUtils.php');

//include logger
require_once (ROOT_DIR_SRC . 'utils/LoggerUtils.php');
$logger = LoggerUtils::getLogger();

//include template engine
require_once (ROOT_DIR_SRC . 'utils/TplEngineUtils.php');

$showParts = !(isset ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) && strtolower ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) == "xmlhttprequest");

/**
 * HEADER
 */
if ($showParts) {
    TplEngineUtils::renderTpl("layout/header");
}

/**
 * MAIN CONTENT
 */

// routing REST
require_once (ROOT_DIR_SRC . "controller" . DIRECTORY_SEPARATOR . "FrontController.php");
require_once (ROOT_DIR_SRC . "utils" . DIRECTORY_SEPARATOR . "JsonUtils.php");

try{
    $router = new FrontController();
}
catch(Exception $ex)
{
    $logger->error("An error as occurred", $ex);
        
    JsonUtils::renderError("Une erreur non g&eacute;r&eacute;e s'est produite, veuillez r&eacute;&eacute;ssayer ult&eacute;rieurement.");    
}

/**
 * FOOTER
 */
if ($showParts) {
    TplEngineUtils::renderTpl("layout/footer");
}
?>