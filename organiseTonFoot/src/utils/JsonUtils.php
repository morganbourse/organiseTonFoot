<?php
require_once (ROOT_DIR_SRC . 'vendors/JSON.php');

class JsonUtils
{
	/**
	 * This class should not be instantiated
	 */
	private function __construct() {}
    
   	/**
	 * renderJson
	 * 
	 * @param array $jsonArray
	 */
	public static function renderJson(Array $jsonArray, $httpCode = 200)
	{
        $json = new Services_JSON();
		HeaderUtils::setHeader($httpCode, "application/json");
		echo $json->encode($jsonArray);
	}
    
    /**
	 * renderError
	 * 
	 * @param String $errorMessage
     * @param [string] $httpCode
	 */
	public static function renderError($errorMessage)
	{
	    $json = array("success" => false, "error" => $errorMessage);
        self::renderJson($json);
	}
    
    /**
	 * renderSuccess
	 * 
	 * @param String $successMessage     
	 */
	public static function renderSuccess($successMessage)
	{
	    $json = array("success" => true, "successMessage" => $successMessage);
        self::renderJson($json);
	}
}
?>