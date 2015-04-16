<?php
importValidatorAnnotation('IAnnotation.php');

/**
 * @author Morgan
 * @since 23 janv. 2015
 *
 * The InfOrEqual class
 * 
 * Check if the numeric value is inferior or equal to the specified numeric
 */
class InfOrEqual extends Annotation implements IAnnotation {
    const DEFAULT_ERROR_MSG = "La valeur do&icirc;t &ecirc;tre inf&eacute;rieur ou &eacute;gale &agrave; ";
    public $comparedValue;

    /**
     * @see Annotation::validate()
     */
    public function validate($value)
    {
        if(is_null($value) || StringUtils::isBlank($value))
        {
            return true;
        }
        return $value <= $this->comparedValue;
    }
    

    /**
     * @see IAnnotation::getErrorMessage()
     */
    public function getErrorMessage()
    {
        if(empty($this->errorMsg))
        {
            return self::DEFAULT_ERROR_MSG . $this->comparedValue;
        }
    
        return $this->errorMsg;
    }
}
?>