<?php
require_once (ROOT_DIR_SRC . 'utils/CollectionUtils.php');
require_once (ROOT_DIR_SRC . 'utils/StringUtils.php');
require_once (ROOT_DIR_SRC . 'controller/ControllerException.php');
require_once (ROOT_DIR_SRC . 'utils/JsonUtils.php');
require_once (ROOT_DIR_SRC . 'utils/HeaderUtils.php');
require_once (ROOT_DIR_SRC . 'utils/LoggerUtils.php');
require_once (ROOT_DIR_SRC . 'utils/TplEngineUtils.php');

/**
 * Base Controller
 * 
 * @author Morgan
 *        
 */
abstract class Controller {
    protected $logger;
    
    /**
     * Constructor
     */
    public function Controller() {
        $this->logger = LoggerUtils::getLogger ();
    }
    
    /**
     * draw the template in the response
     * 
     * @param String $templateName            
     * @param array $variables            
     * @throws ControllerException
     */
    public function draw($templateName, Array $variables = null) {
        try {
            TplEngineUtils::renderTpl ( $templateName, $variables, false );
        }
        catch ( Exception $ex ) {
            throw new ControllerException ( $ex->getMessage (), $ex->getCode (), $ex->getPrevious () );
        }
    }
    
    /**
     * get the template as string
     * 
     * @param String $templateName            
     * @param array $variables            
     * @throws ControllerException
     */
    public function getTemplateAsString($templateName, Array $variables = null) {
        try {
            return TplEngineUtils::renderTpl ( $templateName, $variables, true );
        }
        catch ( Exception $ex ) {
            throw new ControllerException ( $ex->getMessage (), $ex->getCode (), $ex->getPrevious () );
        }
    }
    
    /**
     * renderJson
     *
     * @param array $jsonArray            
     */
    public function renderJson(Array $jsonArray, $httpCode = 200) {
        JsonUtils::renderJson ( $jsonArray, $httpCode );
    }
    
    /**
     * Map received data to an bean object
     * 
     * @param array $data : provided data
     * @param Object $bean : expected bean object instance
     * @param [array $mapping] : mapping array as array("name" => "pseudo") for exemple
     * "name" is the name of provided data, "pseudo" is the name of the mapped attribute into bean object
     * @ array $ignoreFields : ignore fields mapping of mapped object
     */
    protected function mapDataArrayToBean(Array $data, &$bean, Array $mapping = null, Array $ignoreFields = null)
    {
        if(CollectionUtils::isNotEmpty($data))
        {
            $reflectedBeanObject = new ReflectionObject ( $bean );
            $beanName = $reflectedBeanObject->getName();
            foreach($data as $dataName => $value)
            {
                if(in_array($dataName, $ignoreFields))
                {
                    continue;
                }
                
                if ($reflectedBeanObject->hasProperty ( $dataName )) {
                    $beanProperty = $reflectedBeanObject->getProperty ( $dataName );
                    $beanProperty->setAccessible ( true );
                    $beanProperty->setValue ( $bean, $value );
                }
                else if((CollectionUtils::isNotEmpty($mapping) && array_key_exists($dataName, $mapping)) && $reflectedBeanObject->hasProperty ( $mapping[$dataName] ))
                {
                    $beanProperty = $reflectedBeanObject->getProperty ( $mapping[$dataName] );
                    $beanProperty->setAccessible ( true );
                    $beanProperty->setValue ( $bean, $value );
                }
                else 
                {
                    $msg = "Property '" . $dataName . "' does not exists in " . $beanName . " object.";
                    $this->logger->error($msg);
                    throw new ControllerException($msg);
                }
            }
        }
    }
    
    /**
     * Default controller function
     */
    abstract function index();
}
?>