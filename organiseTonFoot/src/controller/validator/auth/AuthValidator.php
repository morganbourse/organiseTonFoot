<?php
importValidator ( 'Validator.php' );

/**
 * AuthValidator
 *
 * @author Morgan
 *        
 */
class AuthValidator extends Validator {
    /**
     *
     * @see IValidator->validate(Array $data)
     */
    public function validate(Array $data) {        
        if (CollectionUtils::isNotEmpty ( $data )) {
            if (isset ( $data ["login"] ) && isset ( $data ["pwd"] )) {
                $login = $data ["login"];
                $pwd = $data ["pwd"];
                
                $rules = array (
                                array (
                                                "fieldName" => "login",
                                                "mandatory" => true,
                                                "dataType" => DataType::STRING,
                                                "value" => $login 
                                ),
                                array (
                                                "fieldName" => "pwd",
                                                "mandatory" => true,
                                                "dataType" => DataType::STRING,
                                                "value" => $pwd 
                                ) 
                );
                
                return $this->checkRules($rules);
            }
        }
        
        return null;
    }
}
?>