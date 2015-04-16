<?php
importLib('addendum/annotations.php');
importUtil('StringUtils.php');

/**
 * @author Morgan
 * @since 23 janv. 2015
 *
 * The Annotation class
 */
interface IAnnotation {
    /**
     * Method validate
     * 
     * Validate value
     * 
     * @param String $value
     */
    function validate($value);
    
    /**
     * return the error message
     */
    function getErrorMessage();
}

?>