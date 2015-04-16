<?php
define("ROOT_DIR_SRC", ROOT_DIR . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR);
define("ROOT_DIR_CONTROLLERS", ROOT_DIR_SRC . "controller" . DIRECTORY_SEPARATOR);
define("ROOT_DIR_VALIDATORS", ROOT_DIR_CONTROLLERS . "validator" . DIRECTORY_SEPARATOR);
define("ROOT_DIR_VALIDATOR_ANNOTATIONS", ROOT_DIR_VALIDATORS . "annotation" . DIRECTORY_SEPARATOR);
define("ROOT_DIR_MODELS", ROOT_DIR_SRC . "model" . DIRECTORY_SEPARATOR);
define("ROOT_DIR_BEANS", ROOT_DIR_CONTROLLERS . "bean" . DIRECTORY_SEPARATOR);
define("ROOT_DIR_UTILS", ROOT_DIR_SRC . "utils" . DIRECTORY_SEPARATOR);
define("ROOT_DIR_VENDORS", ROOT_DIR_SRC . "vendors" . DIRECTORY_SEPARATOR);
define("ROOT_DIR_CONFIG", ROOT_DIR . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR);
define("ROOT_DIR_PUBLICS", ROOT_DIR . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR);

/**
 * Method importController
 * 
 * import php file from src/controller folder of this project
 * 
 * @param string $controllerSubPath
 */
function importController($controllerSubPath)
{
    require_once(ROOT_DIR_CONTROLLERS . $controllerSubPath);
}

/**
 * Method importValidator
 *
 * import php file from src/controller/validator folder of this project
 *
 * @param string $validatorSubPath
 */
function importValidator($validatorSubPath)
{
    require_once(ROOT_DIR_VALIDATORS . $validatorSubPath);
}

/**
 * Method importValidatorAnnotation
 *
 * import php file from src/controller/validator/annotation folder of this project
 *
 * @param string $validatorAnnotationSubPath
 */
function importValidatorAnnotation($validatorAnnotationSubPath)
{
    require_once(ROOT_DIR_VALIDATOR_ANNOTATIONS . $validatorAnnotationSubPath);
}

/**
 * Method importBean
 *
 * import php file from src/controller/bean folder of this project
 *
 * @param string $beanSubPath
 */
function importBean($beanSubPath)
{
    require_once(ROOT_DIR_BEANS . $beanSubPath);
}

/**
 * Method importModel
 *
 * import php file from src/model folder of this project
 *
 * @param string $modelSubPath
 */
function importModel($modelSubPath)
{
    require_once(ROOT_DIR_MODELS . $modelSubPath);
}

/**
 * Method importLib
 * 
 * import php file from vendors folder of this project
 * 
 * @param string $libSubPath
 */
function importLib($libSubPath)
{
    require_once(ROOT_DIR_VENDORS . $libSubPath);
}

/**
 * Method importUtil
 * 
 * import php file from utils folder of this project
 * 
 * @param string $utilSubPath
 */
function importUtil($utilSubPath)
{
    require_once(ROOT_DIR_UTILS . $utilSubPath);
}

/**
 * Method importSrc
 * 
 * import php file from src folder of this project
 * 
 * @param string $srcSubPath
 */
function importSrc($srcSubPath)
{
    require_once(ROOT_DIR_SRC . $srcSubPath);
}

/**
 * Method importConfig
 *
 * import php file from /config folder of this project
 *
 * @param string $configSubPath
 */
function importConfig($configSubPath)
{
    require_once(ROOT_DIR_CONFIG . $configSubPath);
}

/**
 * Method import
 * 
 * import php file from root folder of this project
 * 
 * @param string $path
 */
function import($path)
{
    require_once(ROOT_DIR_SRC . $path);
}
?>