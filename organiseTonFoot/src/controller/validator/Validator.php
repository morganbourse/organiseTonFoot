<?php
require_once (ROOT_DIR_SRC . 'controller/validator/IValidator.php');
require_once (ROOT_DIR_SRC . 'utils/JsonUtils.php');
require_once (ROOT_DIR_SRC . 'utils/HeaderUtils.php');

/**
 * Validator
 * @author Morgan
 *
 */
abstract class Validator implements IValidator
{
    protected $logger;
    
    /**
     * Constructor
     **/
    public function Validator()
    {
        $this->logger = LoggerUtils::getLogger();
    }
    
    /**
     * Call validate method and render errors as Json
     */
	public function validateInputs(Array $data)
    {
        $error = null;
        $fieldErrors = null;
        try
        {
            $fieldErrors = $this->validate($data);    
        }
        catch(Exception $ex)
        {
            $error = $ex->getMessage();
        }
        
        $isValid = (CollectionUtils::isEmpty($fieldErrors) && StringUtils::isBlank($error));
        
        if(!$isValid)
        {
            $json = array("success" => $isValid, "error" => $error, "fieldErrors" => $fieldErrors);
            JsonUtils::renderJson($json);
        }
        
        return $isValid;
    }
}
?>