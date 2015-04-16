<?php
importValidatorAnnotation('IAnnotation.php');

/**
 * @author Morgan
 * @since 23 janv. 2015
 *
 * The PhoneNumber class
 * 
 * Check if the value is valid phone number
 */
class PhoneNumber extends Annotation implements IAnnotation {
    const DEFAULT_ERROR_MSG = "Le format du num&eacute;ro de t&eacute;l&eacute;phone est incorrect.";    
    
    /**
     * @see Annotation::validate()
     */
    public function validate($value)
    {
        if(is_null($value) || StringUtils::isBlank($value))
        {
            return true;
        }
        
        return preg_match ( "/^[0-9]{10}$/", $value );
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
