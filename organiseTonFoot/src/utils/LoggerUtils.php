<?php
class LoggerUtils
{
    private static $instance = null;
    
	/**
	 * This class should not be instantiated
	 */
	private function __construct() {}

	/**
	 * Get logger
	 * 
	 * @return logger
	 * @static
	 */
	public static function getLogger() {
        if(is_null(self::$instance))
        {
            importLib('log4php/Logger.php');
            Logger::configure(ROOT_DIR_CONFIG . 'log4php.xml');
            self::$instance = Logger::getLogger('default'); 
        }
       
		return self::$instance;
	}
}
?>