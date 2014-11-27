<?php
require_once (ROOT_DIR_SRC . 'controller/validator/IValidator.php');
require_once (ROOT_DIR_SRC . 'utils/JsonUtils.php');
require_once (ROOT_DIR_SRC . 'utils/StringUtils.php');
require_once (ROOT_DIR_SRC . 'utils/CollectionUtils.php');
require_once (ROOT_DIR_SRC . 'utils/HeaderUtils.php');
require_once (ROOT_DIR_SRC . 'controller/validator/DataType.php');
require_once (ROOT_DIR_SRC . 'controller/validator/OperatorType.php');
require_once (ROOT_DIR . '/src/utils/mail/MailUtils.php');

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
            $dataType = $rule ['dataType'];
            $value = $rule ['value'];
            
            $equalValue = array ();
            
            if (isset ( $rule ['equalsTo'] )) {
                $equalValue = $rule ['equalsTo'];
            }
            
            $comparaisonType = null;
            $expectedSize = null;
            if (isset ( $rule ['size'] )) {
                $expectedSizeParts = preg_split( "/ /", $rule ['size'] );
                $comparaisonType = $expectedSizeParts [0];
                $expectedSize = (int) $expectedSizeParts [1];
            }
            
            switch ($dataType) {
                case DataType::INTEGER :
                    if (! $this->checkMandatory ( $value, $isMandatory )) {
                        $fieldErrors [$fieldName] = "Le champ est obligatoire.";
                    }
                    else if (! is_int ( $value )) {
                        $fieldErrors [$fieldName] = "La valeur saisie doit &ecirc;tre un chiffre entier";
                    }
                    else if (CollectionUtils::isNotEmpty ( $equalValue ) && ! in_array ( $value, $equalValue )) {
                        $fieldErrors [$fieldName] = "La valeur reçue n'est pas une valeur authoris&eacute;e";
                    }
                    
                    break;
                
                case DataType::DECIMAL :
                    if (! $this->checkMandatory ( $value, $isMandatory )) {
                        $fieldErrors [$fieldName] = "Le champ est obligatoire.";
                    }
                    else if (! is_numeric ( $value )) {
                        $fieldErrors [$fieldName] = "La valeur saisie doit &ecirc;tre un chiffre d&eacute;cimal";
                    }
                    else if (CollectionUtils::isNotEmpty ( $equalValue ) && ! in_array ( $value, $equalValue )) {
                        $fieldErrors [$fieldName] = "La valeur reçue n'est pas une valeur authoris&eacute;e";
                    }
                    break;
                
                case DataType::STRING :
                    if (! $this->checkMandatory ( $value, $isMandatory )) {
                        $fieldErrors [$fieldName] = "Le champ est obligatoire.";
                    }
                    else if (!is_null($expectedSize) && $this->checkSizeOfValue ( $value, $expectedSize, $comparaisonType )) {
                        $fieldErrors [$fieldName] = "La valeur ne doit pas d&eacute;passer " . $expectedSize . " caract&egrave;res";
                    }
                    else if (CollectionUtils::isNotEmpty ( $equalValue ) && ! in_array ( $value, $equalValue )) {
                        $fieldErrors [$fieldName] = "La valeur reçue n'est pas une valeur authoris&eacute;e";
                    }
                    break;
                
                case DataType::MAIL :
                    if (! $this->checkMandatory ( $value, $isMandatory )) {
                        $fieldErrors [$fieldName] = "Le champ est obligatoire.";
                    }
                    else if (!is_null($expectedSize) && $this->checkSizeOfValue ( $value, $expectedSize, $comparaisonType )) {
                        $fieldErrors [$fieldName] = "La valeur ne doit pas d&eacute;passer " . $expectedSize . " caract&egrave;res";
                    }
                    else if (MailUtils::isValidMail ( $value )) {
                        $fieldErrors [$fieldName] = "L'adresse mail est invalide.";
                    }
                    break;
                
                case DataType::PHONE :
                    if (! $this->checkMandatory ( $value, $isMandatory )) {
                        $fieldErrors [$fieldName] = "Le champ est obligatoire.";
                    }
                    else if (! preg_match ( "/^[0-9]{10}$/", $value )) {
                        $fieldErrors [$fieldName] = "Le num&eacute;ro de t&eacute;l&eacute;phone est invalide";
                    }
                    break;
                
                case DataType::POSTAL_CODE :
                    if (! $this->checkMandatory ( $value, $isMandatory )) {
                        $fieldErrors [$fieldName] = "Le champ est obligatoire.";
                    }
                    else if (! preg_match ( "/^[0-9]{5}$/", $value )) {
                        $fieldErrors [$fieldName] = "Le code postale est invalide";
                    }
                    break;
            }
        }
        
        return $fieldErrors;
    }
    
    /**
     * Check if mandatory field is not null
     *
     * @param unknown $value            
     * @return boolean
     */
    public function checkMandatory($value, $isMandatory) {
        return ! ((is_null ( $value ) || (is_string ( $value ) && StringUtils::isBlank ( $value ))) && $isMandatory);
    }
    
    /**
     * Check size of string value
     *
     * @param string $value            
     * @param string $expectedSize            
     * @param OperatorType $comparaisonType            
     * @return boolean
     */
    public function checkSizeOfValue($value, $expectedSize, $comparaisonType) {
        if (StringUtils::equals ( $comparaisonType, OperatorType::SUP_OR_EQUAL_STR )) {
            return StringUtils::sizeSuperior ( $value, $expectedSize, true );
        }
        else if (StringUtils::equals ( $comparaisonType, OperatorType::INF_OR_EQUAL_STR )) {
            return StringUtils::sizeInferior ( $value, $expectedSize, true );
        }
        else if (StringUtils::equals ( $comparaisonType, OperatorType::INFERIOR_STR )) {
            return StringUtils::sizeInferior ( $value, $expectedSize, false );
        }
        else if (StringUtils::equals ( $comparaisonType, OperatorType::SUPERIOR_STR )) {
            return StringUtils::sizeSuperior ( $value, $expectedSize, false );
        }
        
        return StringUtils::sizeEqual ( $value, $expectedSize );
    }
}
?>