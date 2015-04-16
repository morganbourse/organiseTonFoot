<?php
require_once (ROOT_DIR_SRC . 'utils/CollectionUtils.php');
require_once (ROOT_DIR_SRC . 'utils/StringUtils.php');
require_once (ROOT_DIR_SRC . 'utils/LoggerUtils.php');

/**
 *
 * @author Morgan
 * @since 24 nov. 2014
 *       
 * The TplEngineUtils class
 */
class TplEngineUtils
{
    private static $instance = null;
    
	/**
	 * This class should not be instantiated
	 */
	private function __construct() {}

	/**
	 * Get tpl engine instance
	 * 
	 * @return RainTPL
	 * @static
	 */
	public static function getTplEngineInstance() {
        if(is_null(self::$instance))
        {
            require_once (ROOT_DIR_SRC . 'vendors/rain.tpl.class.php');
            RainTPL::$tpl_dir = ROOT_DIR_SRC . "view" . DIRECTORY_SEPARATOR;
            RainTPL::$cache_dir = ROOT_DIR_SRC . ".." . DIRECTORY_SEPARATOR . "tmp" . DIRECTORY_SEPARATOR;
            RainTPL::$path_replace = false;
            RainTPL::$tpl_ext = "tpl";
            
            LoggerUtils::getLogger()->debug("init template engine...");
            self::$instance = new RainTPL();
        }
       
		return self::$instance;
	}
	
	/**
	 * draw the template in the response
	 * @param String $templateName
	 * @param array $variables
	 * @param boolean $asString
	 * @throws ControllerException
	 */
	public static function renderTpl($templateName, Array $variables = null, $asString = false) {
	    $tpl = self::getTplEngineInstance();
	    if(CollectionUtils::isNotEmpty($variables))
		{
			$tpl->assign($variables);
		}

		if(StringUtils::isEmpty($templateName))
		{
			throw new Exception("The template name to load cannot be an empty string", "EMPTY_TEMPLATE_NAME");
		}

		// get the template as String if $asString = true
		return $tpl->draw($templateName, $asString);
	}
}
?>