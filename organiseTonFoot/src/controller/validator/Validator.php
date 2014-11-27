<?php
require_once (ROOT_DIR_SRC . 'controller/validator/IValidator.php');
require_once (ROOT_DIR_SRC . 'utils/JsonUtils.php');
require_once (ROOT_DIR_SRC . 'utils/StringUtils.php');
require_once (ROOT_DIR_SRC . 'utils/CollectionUtils.php');
require_once (ROOT_DIR_SRC . 'utils/HeaderUtils.php');
require_once (ROOT_DIR_SRC . 'controller/validator/DataType.php');

/**
 * Validator
 *
 * @author Morgan
 *        
 */
abstract class Validator implements IValidator {
    protected $logger;
    
    /**
     * Constructor
     */
    public function Validator() {
        $this->logger = LoggerUtils::getLogger ();
    }
    
    /**
     * Call validate method and render errors as Json
     */
    public function validateInputs(Array $data) {
        $error = null;
        $fieldErrors = null;
        try {
            $fieldErrors = $this->validate ( $data );
        }
        catch ( Exception $ex ) {
            $error = $ex->getMessage ();
        }
        
        $isValid = (CollectionUtils::isEmpty ( $fieldErrors ) && StringUtils::isBlank ( $error ));
        
        if (! $isValid) {
            $json = array (
                            "success" => $isValid,
                            "error" => $error,
                            "fieldErrors" => $fieldErrors 
            );
            JsonUtils::renderJson ( $json );
        }
        
        return $isValid;
    }
    
    /**
     * Check defined rules
     *
     * @param array $rules            
     */
    public function checkRules(Array $rules) {
        $fieldErrors = array ();
        if (CollectionUtils::isEmpty ( $rules )) {
            return $fieldErrors;
        }
        
        foreach ( $rules as $rule ) {
            /*
             * rule example : array("fieldName" => "address", "mandatory" => true, "size" => "<= 20", "dataType" => DataType::MAIL, "value" => $address, "equalsTo" => "toto")
             */
            
            $fieldName = $rule ['fieldName'];
            $isMandatory = $rule ['mandatory'];
            $size = $rule ['size'];
            $dataType = $rule ['dataType'];
            $value = $rule ['value'];
            $equalValue = $rule ['equalsTo'];
            
            switch ($dataType) {
                case DataType::INTEGER :
                    if (is_null ( $value ) && $isMandatory) {
                        $fieldErrors [$fieldName] = "obligatoire";
                    }
                    
                    if (! is_int ( $value )) {
                        $fieldErrors [$fieldName] = "doit &ecirc;tre un entier";
                    }
                    else if (is_array ( $equalValue ) && in_array ( $value, $equalValue )) {
                        $fieldErrors [$fieldName] = "Valeur non valide";
                    }
                    else if (isset ( $equalValue ) && ! is_null ( $equalValue ) && $value !== $equalValue) {
                        $fieldErrors [$fieldName] = "Valeur non valide";
                    }
                    
                    break;
                
                case DataType::DECIMAL :
                    echo "i égal 0";
                    break;
                
                case DataType::STRING :
                    echo "i égal 1";
                    break;
                
                case DataType::MAIL :
                    echo "i égal 2";
                    break;
                
                case DataType::PHONE :
                    echo "i égal 2";
                    break;
                
                case DataType::POSTAL_CODE :
                    echo "i égal 2";
                    break;
            }
        }
    }
}
?>