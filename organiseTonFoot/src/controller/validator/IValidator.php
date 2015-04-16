<?php
require_once (ROOT_DIR_SRC . 'utils/CollectionUtils.php');
require_once (ROOT_DIR_SRC . 'utils/StringUtils.php');
require_once (ROOT_DIR_SRC . 'utils/LoggerUtils.php');

/**
 * Interface IValidator
 * @author Morgan
 *
 */
interface IValidator
{
    /**
     * validate method
     * Called by the framework to validate form
     * 
     * @param Array $data : data from the request
     **/
	function validate(Array $data);
}
?>