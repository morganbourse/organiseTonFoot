<?php
importValidatorAnnotation('IAnnotation.php');

/**
 * @author Morgan
 * @since 23 janv. 2015
 *
 * The NotEmpty class
 * 
 * Check if the value is empty
 */
class NotEmpty extends Annotation implements IAnnotation {
    const DEFAULT_ERROR_MSG = "La valeur ne peut &ecirc;tre vide.";
    
    /**
     * @see Annotation::validate()
     */
    public function validate($value)
    {
        return !StringUtils::isEmpty($value);
    }
    
    /**
     * @see IAnnotation::getErrorMessage()
     */
    public function getErrorMessage()
    {
        if(empty($this->errorMsg))
        {
            return self::DEFAULT_ERROR_MSG;
        }
    
        return $this->errorMsg;
    }
}
?>