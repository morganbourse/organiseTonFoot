<?php
importValidatorAnnotation('IAnnotation.php');

/**
 * @author Morgan
 * @since 23 janv. 2015
 *
 * The NotBlank class
 * 
 * Check if the value is blank
 */
class NotBlank extends Annotation implements IAnnotation {
    const DEFAULT_ERROR_MSG = "La valeur ne peut &ecirc;tre vide ou n'&ecirc;tre constitu&eacute;e que d'espaces.";
    
    /**
     * @see Annotation::validate()
     */
    public function validate($value)
    {
        return !StringUtils::isBlank($value);
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