<?php
importConfig('Routes.php');
importUtil('HeaderUtils.php');
importUtil('LoggerUtils.php');
importUtil('StringUtils.php');

/**
 * Dispatch request for call controller method
 * 
 * @author Morgan
 *
 */
class FrontController {
	const CONTROLLER_EXTENSION = "Controller";
    const VALIDATOR_EXTENSION = "Validator";
    const STANDARD_VALIDATOR_METHOD_NAME = "validateInputs";
	const DEFAULT_URL = "/home";
	const REST_URL = "QUERY_STRING";
	const DEFAULT_BEAN_VALIDATOR = "bean/Bean";
	
	protected $controller;
	protected $action;
	protected $params = array ();
    protected $validator;
    protected $bean;
    protected $autoValidator = false;
	protected $basePath = "/";
    private $logger;
	
	public function __construct() {
        $this->logger = LoggerUtils::getLogger();
       
		$this->parseUri ();
		$this->run ();
	}
	
	/**
	 * parse the uri for determinate route
	 */
	protected function parseUri() {
		$route = htmlspecialchars ( $_SERVER [self::REST_URL] );		

		if(StringUtils::isBlank($route))
		{
			$route = self::DEFAULT_URL;
		}
		
        $this->logger->debug("Called route : " . $route);
        
		$routeInfo = Routes::getInstance()->match($route);
		if(CollectionUtils::isEmpty($routeInfo))
		{
			HeaderUtils::setHeader(404);
			return;
		}
		
		//auto validation enabled ?
		$validatorName = $routeInfo[Routes::VALIDATOR_ROUTE_INDEX];
		$beanName = $routeInfo[Routes::BEAN_ROUTE_INDEX];
		$this->autoValidator = StringUtils::isBlank($validatorName) && !StringUtils::isBlank($beanName);
		if($this->autoValidator)
		{
		    $validatorName = self::DEFAULT_BEAN_VALIDATOR;
		}
		
	    $this->setBean($beanName, $route); 
        $this->setValidator($validatorName, $route);
		$this->setController($routeInfo[Routes::CONTROLLER_ROUTE_INDEX], $route);
		$this->setAction($routeInfo[Routes::METHOD_ROUTE_INDEX]);
		$this->setParams($routeInfo[Routes::PARAMS_ROUTE_INDEX]);
	}
	
	/**
	 * set the controller
	 * 
	 * @param unknown $controller
	 * @param unknown $route
	 * @throws InvalidArgumentException
	 */
	protected function setController($controller, $route) {
		$controllerPath = ROOT_DIR_CONTROLLERS . $controller . self::CONTROLLER_EXTENSION . PHP_EXTENSION;
		$controller = ucfirst(basename($controller)) . self::CONTROLLER_EXTENSION;		
		
		if (!is_file ( $controllerPath )) {
			throw new InvalidArgumentException ( "The controller cannot be found for route $route." );
		}
		
		require_once ($controllerPath);
		
		if (! class_exists ( $controller )) {
			throw new InvalidArgumentException ( "The controller cannot be found for route $route." );
		}
		$this->controller = $controller;
	}
    
    /**
	 * set the validator if is specified
	 * 
	 * @param unknown $validator
	 * @param unknown $route
	 * @throws InvalidArgumentException
	 */
	protected function setValidator($validator, $route) {
        if(StringUtils::isBlank($validator))
        {
            return;
        }
    
		$validatorPath = ROOT_DIR_VALIDATORS . $validator . self::VALIDATOR_EXTENSION . PHP_EXTENSION;
		$validator = ucfirst(basename($validator)) . self::VALIDATOR_EXTENSION;		
		
		if (!is_file ( $validatorPath )) {
			throw new InvalidArgumentException ( "The validator cannot be found for route $route." );
		}
		
		require_once ($validatorPath);
		
		if (! class_exists ( $validator )) {
			throw new InvalidArgumentException ( "The validator cannot be found for route $route." );
		}
		$this->validator = $validator;
        
        $reflector = new ReflectionClass ( $this->validator );
        if (!$reflector->hasMethod ( self::STANDARD_VALIDATOR_METHOD_NAME )) {
			throw new InvalidArgumentException ( "The validator does not respect the standard and has no named 'validate' method" );
		}
	}
	
	/**
	 * set the bean if is specified
	 *
	 * @param unknown $bean
	 * @param unknown $route
	 * @throws InvalidArgumentException
	 */
	protected function setBean($bean, $route) {
	    if(StringUtils::isBlank($bean))
	    {
	        return;
	    }
	
	    $beanPath = ROOT_DIR_BEANS . $bean . PHP_EXTENSION;
	    $bean = ucfirst(basename($bean));
	
	    if (!is_file ( $beanPath )) {
	        throw new InvalidArgumentException ( "The bean cannot be found for route $route." );
	    }
	
	    require_once ($beanPath);
	
	    if (! class_exists ( $bean )) {
	        throw new InvalidArgumentException ( "The bean cannot be found for route $route." );
	    }
	    $this->bean = $bean;
	}
	
	/**
	 * set the called method in controller
	 * 
	 * @param unknown $action
	 * @throws InvalidArgumentException
	 */
	protected function setAction($action) {
		$reflector = new ReflectionClass ( $this->controller );
		if (! $reflector->hasMethod ( $action )) {
			throw new InvalidArgumentException ( "The controller action '$action' has been not defined." );
		}
		$this->action = $action;
	}
	
	/**
	 * set array params passed to the controller
	 * 
	 * @param array $params
	 */
	protected function setParams(Array $params = null) {
		if($params == null)
		{
			$params = array();
		}
		
		$this->params = $params;
	}
	
	/**
	 * run controller method
	 */
	protected function run() {
        $isValid = true;
        if(!StringUtils::isBlank($this->validator))
        {
            $methodParams = array($this->params);
            if(!StringUtils::isBlank($this->bean))
            {
                $bean = new $this->bean();
                $methodParams[] = $bean;
            }
            
        	$isValid = call_user_func_array ( array (
        			new $this->validator(),
        			self::STANDARD_VALIDATOR_METHOD_NAME 
        	), $methodParams);
        }
        
        if(!StringUtils::isBlank($this->controller) && $isValid)
        {
        	call_user_func_array ( array (
        			new $this->controller(),
        			$this->action 
        	), array($this->params));
        }
	}
}

?>