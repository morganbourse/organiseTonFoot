<?php
importValidator('bean/BeanValidator.php');
importBean("player/PlayerBean.php");

/**
 * RegisterValidator
 *
 * @author Morgan
 *        
 */
class RegisterValidator extends BeanValidator {
    /**
     * @see BeanValidator::validateInputs()
     */
    public function validateInputs(Array $data, $object, Array $ignoreFields = null, Array $mapping = null) {
        parent::validateInputs($data, $object, array("pwdConfirm"), array());
    }
    
    /**
     * @see BeanValidator::validate()
     */
    public function validate(Array $data) {        
        $fieldErrors = array ();
        
        $pwd = null;
        $pwdConfirm = null;
        
        if (CollectionUtils::isNotEmpty ( $data )) {
            $pwd = $data ["password"];
            $pwdConfirm = $data ["pwdConfirm"];
            
            if(!StringUtils::isBlank($pwd) && !StringUtils::equals($pwd, $pwdConfirm))
            {
                $fieldErrors['pwdConfirm'] = "La confirmation du mot de passe doit &ecirc;tre &eacute;gale &agrave; la valeur du mot de passe";                
            }
        }
        
        return $fieldErrors;
    }
}
?>