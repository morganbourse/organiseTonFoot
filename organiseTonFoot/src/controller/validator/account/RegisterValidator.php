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
            $login = $data ["login"];
            $pwd = $data ["pwd"];
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
                                        "fieldName" => "login",
                                        "mandatory" => true,
                                        "size" => "<= 20",                                        
                                        "dataType" => DataType::STRING,
                                        "value" => $login 
                        ),
                        array (
                                        "fieldName" => "pwd",
                                        "mandatory" => true,
                                        "size" => "<= 20",
                                        "dataType" => DataType::STRING,
                                        "value" => $pwd 
                        ),
                        array (
                                        "fieldName" => "pwdConfirm",
                                        "mandatory" => true,
                                        "size" => "<= 20",
                                        "dataType" => DataType::STRING,
                                        "equalsTo" => $pwd,
                                        "value" => $pwdConfirm
                        ),
                        array (
                                        "fieldName" => "name",
                                        "mandatory" => true,
                                        "dataType" => DataType::STRING,
                                        "size" => "<= 20",
                                        "value" => $name
                        ),
                        array (
                                        "fieldName" => "surname",
                                        "mandatory" => true,
                                        "size" => "<= 20",
                                        "dataType" => DataType::STRING,
                                        "value" => $surname 
                        ),
                        array (
                                        "fieldName" => "mail",
                                        "mandatory" => true,
                                        "size" => "<= 20",
                                        "dataType" => DataType::MAIL,
                                        "value" => $mail 
                        ),
                        array (
                                        "fieldName" => "phone",
                                        "mandatory" => true,
                                        "size" => "<= 20",
                                        "dataType" => DataType::PHONE,
                                        "value" => $phone 
                        ),
                        array (
                                        "fieldName" => "address",
                                        "mandatory" => true,
                                        "size" => "<= 20",
                                        "dataType" => DataType::STRING,
                                        "value" => $address
                        ),
                        array (
                                        "fieldName" => "cp",
                                        "mandatory" => true,
                                        "dataType" => DataType::POSTAL_CODE,
                                        "value" => $cp 
                        ),
                        array (
                                        "fieldName" => "city",
                                        "mandatory" => true,
                                        "dataType" => DataType::STRING,
                                        "size" => "<= 20",
                                        "value" => $city 
                        ) 
        );

        return $fieldErrors;
    }
}
?>