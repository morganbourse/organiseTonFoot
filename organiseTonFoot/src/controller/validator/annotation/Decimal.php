<?php
importValidatorAnnotation('IAnnotation.php');

/**
 * @author Morgan
 * @since 23 janv. 2015
 *
 * The Decimal class
 * 
 * Check if the value is valid decimal
 */
class Decimal extends Annotation implements IAnnotation {
    const DEFAULT_ERROR_MSG = "La valeur do&icirc;t &ecirc;tre au format d&eacute;cimal.";
    
    /**
     * @see IAnnotation::validate()
     */
    public function validate($value)
    {
        if(is_null($value) || StringUtils::isBlank($value))
        {
            return true;
        }
        
        return is_numeric($value);
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