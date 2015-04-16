<?php
importValidatorAnnotation('IAnnotation.php');

/**
 * @author Morgan
 * @since 23 janv. 2015
 *
 * The Int class
 * 
 * Check if the value is valid integer
 */
class Int extends Annotation implements IAnnotation {
    const DEFAULT_ERROR_MSG = "La valeur do&icirc;t &ecirc;tre un entier.";
    
    /**
     * @see Annotation::validate()
     */
    public function validate($value)
    {
        if(is_null($value) || StringUtils::isBlank($value))
        {
            return true;
        }
        return is_int($value);
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