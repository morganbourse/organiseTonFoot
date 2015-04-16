<?php
importLib('JSON.php');

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
	 * Display error message at screen
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
	 * Display success message at screen and redirect
	 * 
	 * @param String $successMessage : msg to display
	 * @param String $redirectTo : url to redirect
	 */
	public static function renderSuccess($successMessage, $redirectTo = null)
	{
	    $json = array("success" => true, "successMessage" => $successMessage, "redirectTo" => $redirectTo);
        self::renderJson($json);
	}
	
	/**
	 * renderSuccess
	 *
	 * Display success message at screen and redirect
	 *
	 * @param String $successMessage : msg to display
	 * @param String $html : html page to show
	 */
	public static function renderSuccessAndDisplayPage($successMessage, $html = null)
	{
	    $json = array("success" => true, "successMessage" => $successMessage, "html" => $html);
	    self::renderJson($json);
	}
}
?>