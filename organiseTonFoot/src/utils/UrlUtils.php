<?php
importUtil('StringUtils.php');

/**
 * @author Morgan
 * @since 25 nov. 2014
 *
 * The UrlUtils class
 */
class UrlUtils
{
    const APACHE_MOD_REWRITE_PARAMETER_NAME = "mod_rewrite";
    const URL_PREFIX_WITHOUT_MOD_REWRITE = "./?/";
    
	/**
	 * This class should not be instantiated
	 */
	private function __construct() {}

	/**
	 * Method rewrite
	 * 
	 * Rewrite url if apache mod_rewrite is disable
	 * 
	 * @param String $url
	 * @return String newUrl
	 */
	public static function rewrite($url){
	    //check if apache mod_rewrite is disable
        if(!StringUtils::isBlank($url) && !in_array(self::APACHE_MOD_REWRITE_PARAMETER_NAME, apache_get_modules()))
        {
            //rewrite url to standard url with parameters
            if(!StringUtils::startsWith($url, self::URL_PREFIX_WITHOUT_MOD_REWRITE))
            {
                if(StringUtils::startsWith($url, "./"))
                {
                    return StringUtils::replaceFirst($url, "./", self::URL_PREFIX_WITHOUT_MOD_REWRITE);
                }
                else if(StringUtils::startsWith($url, "/"))
                {
                    return StringUtils::replaceFirst($url, "/", self::URL_PREFIX_WITHOUT_MOD_REWRITE);
                }
                else
                {
                    return self::URL_PREFIX_WITHOUT_MOD_REWRITE . $url;
                }
            }
        }
        
        return $url;
	}
}
?>