<?php
importUtil('CollectionUtils.php');
importUtil('StringUtils.php');
importUtil('LoggerUtils.php');

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