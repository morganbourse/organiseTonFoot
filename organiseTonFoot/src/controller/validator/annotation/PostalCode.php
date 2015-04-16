<?php
importValidatorAnnotation('IAnnotation.php');

/**
 * @author Morgan
 * @since 23 janv. 2015
 *
 * The PostalCode class
 * 
 * Check if the value is valid postal code
 */
class PostalCode extends Annotation implements IAnnotation {
    const DEFAULT_ERROR_MSG = "Le format du code postal est incorrect. (5 chiffres)";
    
    /**
     * @see Annotation::validate()
     */
    public function validate($value)
    {
        if(is_null($value) || StringUtils::isBlank($value))
        {
            return true;
        }
        
        return preg_match ( "/^[0-9]{5}$/", $value );
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