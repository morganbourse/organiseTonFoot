<?php
importModel('utils/SafePDO.php');
importUtil('IniManager.php');
importUtil('LoggerUtils.php');
importUtil('CollectionUtils.php');
class GenericDao {
    protected $database;
    protected $tableName;
    protected $logger;
    protected $hasOpenedTransaction;
    
    /**
     * Constructeur
     */
    public function GenericDao($tableName) {
        $this->logger = LoggerUtils::getLogger ();
        $this->hasOpenedTransaction = false;
        
        try {
            $settings = IniManager::getInstance ( ROOT_DIR_CONFIG . "config.ini" );
            $host = trim ( $settings->database ['host'] );
            $port = trim ( $settings->database ['port'] );
            $dbname = trim ( $settings->database ['schema'] );
            $login = trim ( $settings->database ['login'] );
            $pwd = trim ( $settings->database ['pwd'] );
            $persistantConnection = $settings->database ['persistantConnection'];
            $options = array (
                            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" 
            );
            
            if ($persistantConnection) {
                $options [PDO::ATTR_PERSISTENT] = true;
            }
            
            $this->database = new SafePDO ( "mysql:host=$host;dbname=$dbname;port=$port", $login, $pwd, $options );
        }
        catch ( Exception $e ) {
            $this->logger->error ( "Impossible de se connecter à la base de données...", $e );
            $this->database = null;
            throw $e;
        }
        
        $this->tableName = $tableName;
    }
    
    /**
     * function which return unique id
     */
    public static final function getUniqueId() {
        return uniqid ();
    }
    
    /**
     * function findById
     *
     * @param String $id            
     * @param T $returnObject            
     * @return array<T>
     */
    public function findById($id, $returnObject) {
        $query = $this->database->prepare ( "SELECT * FROM " . $this->tableName . " WHERE id = :id;" );
        $query->execute ( array (
                        'id' => $id 
        ) );
        $refletedObject = new ReflectionObject ( $returnObject );
        $query->setFetchMode ( PDO::FETCH_CLASS, $refletedObject->getName () );
        return $query->fetch ();
    }
    
    /**
     * function findAll
     *
     * @param String $id            
     * @param T $returnObject            
     * @return array<T>
     */
    public function findAll($returnObject) {
        $query = $this->database->query ( "SELECT * FROM " . $this->tableName . ";" );
        $refletedObject = new ReflectionObject ( $returnObject );
        $query->setFetchMode ( PDO::FETCH_CLASS, $refletedObject->getName () );
        return $query->fetchAll ();
    }
    
    /**
     * Method insert
     *
     * insert object in database
     *
     * @param unknown $object            
     */
    public function insert($object) {
        $query = "INSERT INTO ";
        $reflectedObject = new ReflectionObject ( $object );
        
        // get the table name linked to the entity
        $tableName = $this->extractEntityTableName ( $reflectedObject );
        
        // add table name to the query
        $query .= $tableName;
        
        $columns = "";
        $valuesPlaceholders = "";
        $values = array ();
        $count = 0;
        
        // get columns and placeholders
        $fieldsArray = $reflectedObject->getProperties ( ReflectionProperty::IS_PRIVATE );
        if (CollectionUtils::isNotEmpty ( $fieldsArray )) {
            foreach ( $fieldsArray as $field ) {
                $count ++;
                $field->setAccessible ( true );
                $columnName = $field->getName ();
                $columns .= $columnName;
                $valuesPlaceholders .= ":" . $columnName;
                
                $value = $field->getValue ( $object );
                if (is_null ( $value ) || empty ( $value )) {
                    $values [$columnName] = "null";
                }
                else {
                    $values [$columnName] = $value;
                }
                
                if ($count < count ( $fieldsArray )) {
                    $columns .= ",";
                    $valuesPlaceholders .= ",";
                }
            }
        }
        
        // add columns and placeholders to the query
        $query .= " (" . $columns . ") VALUES (" . $valuesPlaceholders . ");";
        
        // execute this query
        $query = $this->database->prepare ( $query );
        $query->execute ( $values );
    }
    
    /**
     * Extract the table name linked to the entity object
     *
     * @param ReflectionObject $refletedObject            
     *
     * @return String tableName
     */
    private function extractEntityTableName(ReflectionObject $refletedObject) {
        $phpDoc = $refletedObject->getDocComment ();
        
        // get the table name linked to the entity
        $tableName = StringUtils::extractFromStr ( '/@entity\s+(\w+)/i', $phpDoc );
        
        if (StringUtils::isBlank ( $tableName )) {
            $tableName = $refletedObject->getName ();
        }
        
        return $tableName;
    }
    
    /**
     * begin sql transaction
     */
    public function beginTransaction()
    {
        $this->database->beginTransaction();
        $this->hasOpenedTransaction = true;
    }
    
    /**
     * commit opened transaction
     */
    public function commitTransaction()
    {
        $this->checkOpenedTransaction();
        
        $this->database->commit();
    }
    
    /**
     * rollback opened transaction
     */
    public function rollbackTransaction()
    {
        $this->checkOpenedTransaction();
    
        $this->database->rollBack();
    }
    
    /**
     * Thrown an exception if no transaction opened
     * @throws Exception
     */
    private function checkOpenedTransaction()
    {
        if(!$this->hasOpenedTransaction)
        {
            throw new Exception("You tried to commit or rollback transaction, but no transaction has been opened...");
        }
    }
    
    /**
     * destructeur
     */
    public function __destruct() {
    }
}
?>