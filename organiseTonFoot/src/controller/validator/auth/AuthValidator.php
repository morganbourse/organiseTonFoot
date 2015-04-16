<?php
require_once (ROOT_DIR_SRC . 'controller/validator/Validator.php');

/**
 * AuthValidator
 * @author Morgan
 *
 */
class AuthValidator extends Validator
{
    /**
     * @see IValidator->validate(Array $data)
     */
	public function validate(Array $data)
    {
        $login = null;
        $pwd = null;
        if(CollectionUtils::isNotEmpty($data))
        {
            if(isset($data["login"]) && isset($data["pwd"]))
            {
                $login = $data["login"];
                $pwd = $data["pwd"];   
            }
        }
        
        $fieldErrors = array();
		
		if(StringUtils::isBlank($login))
		{
			$fieldErrors['login'] = 'Veuillez renseigner le nom d\'utilisateur';			
		}

		if(StringUtils::isBlank($pwd))
		{
			$fieldErrors['pwd'] = 'Veuillez renseigner le mot de passe';			
		}
		
		return $fieldErrors;
    }
}
?>