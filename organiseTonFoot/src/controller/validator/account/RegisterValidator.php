<?php
require_once (ROOT_DIR_SRC . 'controller/validator/Validator.php');

/**
 * AuthValidator
 *
 * @author Morgan
 *        
 */
class RegisterValidator extends Validator {
    /**
     *
     * @see IValidator::validate()
     */
    public function validate(Array $data) {
        // fields
        $login = null;
        $pwd = null;
        $pwdConfirm = null;
        $name = null;
        $surname = null;
        $mail = null;
        $phone = null;
        $address = null;
        $cp = null;
        $city = null;
        
        if (CollectionUtils::isNotEmpty ( $data )) {
            $login = $data ["username"];
            $pwd = $data ["password"];
            $pwdConfirm = $data ["pwdConfirm"];
            $name = $data ["name"];
            $surname = $data ["surname"];
            $mail = $data ["mail"];
            $phone = $data ["phone"];
            $address = $data ["address"];
            $cp = $data ["cp"];
            $city = $data ["city"];
        }
        
        $fieldErrors = array ();
        $rulesArray = array (
                        array (
                                        "fieldName" => "username",
                                        "mandatory" => true,
                                        "size" => "<= 20",
                                        "dataType" => DataType::STRING,
                                        "value" => $login 
                        ),
                        array (
                                        "fieldName" => "password",
                                        "mandatory" => true,
                                        "size" => "<= 255",
                                        "dataType" => DataType::STRING,
                                        "value" => $pwd 
                        ),
                        array (
                                        "fieldName" => "pwdConfirm",
                                        "mandatory" => true,
                                        "size" => "<= 255",
                                        "dataType" => DataType::STRING,
                                        "equalsTo" => array($pwd),
                                        "value" => $pwdConfirm 
                        ),
                        array (
                                        "fieldName" => "name",
                                        "mandatory" => true,
                                        "dataType" => DataType::STRING,
                                        "size" => "<= 25",
                                        "value" => $name 
                        ),
                        array (
                                        "fieldName" => "surname",
                                        "mandatory" => true,
                                        "size" => "<= 25",
                                        "dataType" => DataType::STRING,
                                        "value" => $surname 
                        ),
                        array (
                                        "fieldName" => "mail",
                                        "mandatory" => true,
                                        "size" => "<= 100",
                                        "dataType" => DataType::MAIL,
                                        "value" => $mail 
                        ),
                        array (
                                        "fieldName" => "phone",
                                        "mandatory" => false,
                                        "dataType" => DataType::PHONE,
                                        "value" => $phone 
                        ),
                        array (
                                        "fieldName" => "address",
                                        "mandatory" => false,
                                        "size" => "<= 200",
                                        "dataType" => DataType::STRING,
                                        "value" => $address 
                        ),
                        array (
                                        "fieldName" => "cp",
                                        "mandatory" => false,
                                        "dataType" => DataType::POSTAL_CODE,
                                        "value" => $cp 
                        ),
                        array (
                                        "fieldName" => "city",
                                        "mandatory" => false,
                                        "dataType" => DataType::STRING,
                                        "size" => "<= 100",
                                        "value" => $city 
                        ) 
        );
        
        return $this->checkRules ( $rulesArray );
    }
}
?>