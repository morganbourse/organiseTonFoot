<?php
importValidatorAnnotation('IAnnotation.php');
importUtil('mail/MailUtils.php');

/**
 * @author Morgan
 * @since 23 janv. 2015
 *
 * The Mail class
 * 
 * Check if the value is valid mail
 */
class Mail extends Annotation implements IAnnotation {
    const DEFAULT_ERROR_MSG = "Le format de l'adresse mail est incorrect.";
    
    /**
     * @see Annotation::validate()
     */
    public function validate($value)
    {
        if(is_null($value) || StringUtils::isBlank($value))
        {
            return true;
        }
        
        return MailUtils::isValidMail ( $value );
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