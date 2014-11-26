<?php
require_once (ROOT_DIR_SRC . 'utils/LoggerUtils.php');
/**
 * Read ini file easyly
 * @author Morgan
 *
 */
class IniManager {
    private static $instanceArray = array();
    private $settings;
   
    /**
     * constructeur
     * @param unknown_type $ini_file
     */
    private function __construct($ini_file) {
        $this->settings = parse_ini_file($ini_file, true);
    }
   
    /**
     * get instance of this class
     * @param unknown_type $ini_file
     * @return Settings
     */
    public static function getInstance($ini_file) {
        if(!array_key_exists($ini_file, self::$instanceArray)) {
            LoggerUtils::getLogger()->debug("Load ini file : " . $ini_file);
            self::$instanceArray[$ini_file] = new IniManager($ini_file);           
        }
        return self::$instanceArray[$ini_file];
    }
   
    /**
     * get a property
     * @param unknown_type $setting
     * @return unknown
     */
    public function __get($setting) {
        if(array_key_exists($setting, $this->settings)) {
            return $this->settings[$setting];
        } else {
            foreach($this->settings as $section) {
                if(array_key_exists($setting, $section)) {
                    return $section[$setting];
                }
            }
        }
    }
}

?>