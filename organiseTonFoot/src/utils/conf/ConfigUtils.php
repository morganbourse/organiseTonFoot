<?php
importUtil('IniManager.php');
class ConfigUtils
{
    const CONFIG_INI_FILE = "config.ini";
    
	/**
	 * Constructor
	 */
	private function ConfigUtils()
	{
		
	}
	
	/**
	 * get config settings
	 * 
	 * @param unknown $code
	 * @return string
	 */
	public static function loadConfigSettings(){
		return IniManager::getInstance(ROOT_DIR_CONFIG . self::CONFIG_INI_FILE);
	}	
}
?>