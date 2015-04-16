<?php
session_start();
$path = str_replace(DIRECTORY_SEPARATOR,'/',realpath(dirname(__FILE__)));

//define constants
define("ROOT_DIR", $path);
define("PHP_EXTENSION", ".php");
define("ANOTATION_LIST_VAR", "ANNOTATION_LIST");

//import the import manager
require_once (ROOT_DIR . '/src/utils/ImportUtils.php');

//get annotation list
$dirIterator = new DirectoryIterator(ROOT_DIR_VALIDATOR_ANNOTATIONS);
$annotationList = array();
foreach($dirIterator as $file){
    if(!$file->isDot()){
        $className = explode(".", $file->getFilename());
        $className = $className[0];
        $annotationList[] = $className;
    }
}

$GLOBALS[ANOTATION_LIST_VAR] = $annotationList;

//include url utils
importUtil('UrlUtils.php');

//include logger
importUtil('LoggerUtils.php');
$logger = LoggerUtils::getLogger();

//include template engine
importUtil('TplEngineUtils.php');

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
importController('FrontController.php');
importUtil('JsonUtils.php');

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