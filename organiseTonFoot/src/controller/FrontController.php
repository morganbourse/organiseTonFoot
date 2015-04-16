<?php
require_once (ROOT_DIR_CONFIG . 'Routes.php');
require_once (ROOT_DIR_SRC . 'utils/HeaderUtils.php');
require_once (ROOT_DIR_SRC . 'utils/LoggerUtils.php');
require_once (ROOT_DIR_SRC . 'utils/StringUtils.php');

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
	const PHP_EXTENSION = ".php";
	const DEFAULT_URL = "/home";
	const REST_URL = "QUERY_STRING";
	
	protected $controller;
	protected $controllerPath;
    protected $validatorPath;
	protected $action;
	protected $params = array ();
    protected $validator;    
	protected $basePath = "/";
    private $logger;
	
	public function __construct() {
        $this->logger = LoggerUtils::getLogger();
       
		$this->controllerPath = DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "controller". DIRECTORY_SEPARATOR;
        $this->validatorPath = DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "controller". DIRECTORY_SEPARATOR . "validator" . DIRECTORY_SEPARATOR;
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
		
		$this->setController($routeInfo[Routes::CONTROLLER_ROUTE_INDEX], $route);
        $this->setValidator($routeInfo[Routes::VALIDATOR_ROUTE_INDEX], $route);
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
		$controllerPath = ROOT_DIR . $this->controllerPath . $controller . self::CONTROLLER_EXTENSION . self::PHP_EXTENSION;
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
    
		$validatorPath = ROOT_DIR . $this->validatorPath . $validator . self::VALIDATOR_EXTENSION . self::PHP_EXTENSION;
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
        	$isValid = call_user_func_array ( array (
        			new $this->validator(),
        			self::STANDARD_VALIDATOR_METHOD_NAME 
        	), array($this->params));
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