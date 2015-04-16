<?php
importValidatorAnnotation('IAnnotation.php');

/**
 * @author Morgan
 * @since 3 avr. 2015
 *
 * The Lenght class
 * 
 * Check if the value has lenght between min and max characters
 */
class Lenght extends Annotation implements IAnnotation {
    const MIN_SIZE_PLACEHOLDER = "<min>";
    const MAX_SIZE_PLACEHOLDER = "<max>";
    const DEFAULT_ERROR_MSG = "La taille de la valeur doit &ecirc;tre comprise entre <min> et <max> caract&egrave;res.";
    
    public $min;
    public $max;
    
	/**
     * @see IAnnotation::validate()
     */
    public function validate($value) {
        if(is_null($this->min))
        {
            $this->min = 0;
        }
        
        if(is_null($this->max))
        {
            $this->max = mb_strlen($value);
        }
        
        return StringUtils::sizeSuperior($value, $this->min, true) && StringUtils::sizeInferior($value, $this->max, true);
    }

	/**
     * @see IAnnotation::getErrorMessage()
     */
    public function getErrorMessage() {
        if(empty($this->errorMsg))
        {
            $msg = StringUtils::replace(self::DEFAULT_ERROR_MSG, self::MIN_SIZE_PLACEHOLDER, $this->min);
            $msg = StringUtils::replace(self::DEFAULT_ERROR_MSG, self::MAX_SIZE_PLACEHOLDER, $this->max);
            return self::DEFAULT_ERROR_MSG;
        }
        
        return $this->errorMsg;
    }    
}

?>