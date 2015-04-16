<?php
importValidator('IValidator.php');
importUtil('JsonUtils.php');
importUtil('StringUtils.php');
importUtil('CollectionUtils.php');
importUtil('LoggerUtils.php');
importUtil('MapperUtils.php');
importLib('addendum/annotations.php');

/**
 * BeanValidator
 *
 * Validate functionnal rules from bean annotations
 * 
 * @author Morgan
 */
class BeanValidator {
    const ANNOTATION_PATH = "controller/validator/annotation/";
    const VALIDATE_METHOD_NAME = "validate";
    
    /**
     * Constructor
     */
    public function BeanValidator() { }
    
    /**
     * Call validate method and render errors as Json
     * @param Array $data : data array
     * @param Object $object : expected object instance
     * @param [array $ignoreFields] : ignore fields mapping of mapped object
     * @param [array $mapping] : mapping array as array("name" => "pseudo") for exemple
     * "name" is the name of provided data, "pseudo" is the name of the mapped attribute into object
     */
    public function validateInputs(Array $data, $object, Array $ignoreFields = null, Array $mapping = null) {
        $error = null;
        $fieldErrors = null;
        try {
            //use mapper utils to convert data table into an bean object
            MapperUtils::mapDataArrayToObject($data, $object, $mapping, $ignoreFields);
            
            //validate bean object with annotations
            $fieldErrors = $this->validateBean( $object );
            
            //call validator addon            
            $fieldErrors = array_merge($fieldErrors, $this->validate($data));
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
     * Method validate
     * 
     * Specific validation addon
     * 
     * @param array $data
     */
    public function validate(Array $data) {
    	return array();
    }
    
    /**
     * validate bean input by annotations
     *
     * @param Object $bean            
     */
    public function validateBean($bean) {
        $fieldErrors = array ();
        if (null == $bean) {
            return;
        }
        
        $reflectedbean = new ReflectionAnnotatedClass ( $bean );
        $beanName = $reflectedbean->getName();
        $beanFieldsArray = $reflectedbean->getProperties ( ReflectionProperty::IS_PRIVATE );
        
        if (CollectionUtils::isNotEmpty ( $beanFieldsArray )) {
            foreach ( $beanFieldsArray as $beanField ) {
                $beanField->setAccessible ( true );
                $beanFieldName = $beanField->getName ();
                $fieldValue = $beanField->getValue ( $bean );
                
                foreach ( $GLOBALS [ANOTATION_LIST_VAR] as $annotationName ) {
                    if ($beanField->hasAnnotation ( $annotationName )) {
                        $annotation = $beanField->getAnnotation($annotationName);
                        
                        if(!($annotation instanceof IAnnotation))
                        {
                            throw new Exception("The annotation " . $annotationName . " must implements IAnnotation interface.", "INCORRECT_ANNOTATION_IMPLEMENTATION_EXCEPTION");
                        }
                        
                        $isValid = $annotation->validate($fieldValue);
                        
                        if (!$isValid) {
                            $fieldErrors[$beanFieldName] = $annotation->getErrorMessage();
                        }
                    }
                }
            }
        }
        
        return $fieldErrors;
    }
}
?>