<?php
require_once (ROOT_DIR_SRC . 'model/utils/SafePDO.php');
require_once (ROOT_DIR_SRC . 'utils/IniManager.php');
require_once (ROOT_DIR_SRC . 'utils/LoggerUtils.php');
class GenericDao
{
	protected $database;
	protected $tableName;
    protected $logger;

	/**
	 * Constructeur
	 */
	public function GenericDao($tableName)
	{
        $this->logger = LoggerUtils::getLogger();
        
		try {
			$settings = IniManager::getInstance(ROOT_DIR_CONFIG . "config.ini");
			$host = trim($settings->database['host']);
			$port = trim($settings->database['port']);
			$dbname = trim($settings->database['schema']);
			$login = trim($settings->database['login']);
			$pwd = trim($settings->database['pwd']);
			$persistantConnection = $settings->database['persistantConnection'];
			$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

			if($persistantConnection)
			{
				$options[PDO::ATTR_PERSISTENT] = true;
			}

			$this->database = new SafePDO("mysql:host=$host;dbname=$dbname;port=$port", $login, $pwd, $options);
		} catch (Exception $e) {
			$this->logger->error("Impossible de se connecter à la base de données...", $e);
			$this->database = null;
			throw $e;
		}

		$this->tableName = $tableName;
	}

	/**
	 * function which return unique id
	 */
	public static final function getUniqueId()
	{
		return uniqid();
	}

	/**
	 * function findById
	 * @param String $id
	 * @param T $returnObject
	 * @return array<T>
	 */
	public function findById($id, $returnObject)
	{
		$query = $this->database->prepare("SELECT * FROM " . $this->tableName . " WHERE id = :id;");
		$query->execute(array( 'id' => $id ));
		$refletedObject = new ReflectionObject($returnObject);
		$query->setFetchMode(PDO::FETCH_CLASS, $refletedObject->getName());
		return $query->fetch();
	}
	
	/**
	 * function findAll
	 * @param String $id
	 * @param T $returnObject
	 * @return array<T>
	 */
	public function findAll($returnObject)
	{
		$query = $this->database->query("SELECT * FROM " . $this->tableName . ";");		
		$refletedObject = new ReflectionObject($returnObject);
		$query->setFetchMode(PDO::FETCH_CLASS, $refletedObject->getName());
		return $query->fetchAll();
	}

	/**
	 * destructeur
	 */
	public function __destruct()
	{

	}
}
?>