<?php
importValidatorAnnotation('IAnnotation.php');

/**
 * @author Morgan
 * @since 23 janv. 2015
 *
 * The NotNull class
 */
class NotNull extends Annotation implements IAnnotation {
    const DEFAULT_ERROR_MSG = "La valeur ne peut &ecirc;tre nulle.";
    
    /**
     * @see Annotation::validate()
     */
    public function validate($value)
    {
        return (null != $value);
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