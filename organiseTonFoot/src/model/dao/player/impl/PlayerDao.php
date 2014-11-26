<?php
require_once (ROOT_DIR_SRC . 'model/dao/GenericDao.php');
require_once (ROOT_DIR_SRC . 'model/dao/player/IPlayerDao.php');
require_once (ROOT_DIR_SRC . 'model/entity/player/Player.php');
class PlayerDao extends GenericDao implements IPlayerDao
{
    const TABLE_NAME = "Players";

	/**
	 * Constructeur
	 */	
	public function PlayerDao()
	{
	   parent::GenericDao(self::TABLE_NAME);
	}
    
    /**
     * @see IPlayerDao::findByCredentials($login, $pwd)
     */
    function findByCredentials($login, $pwd) {
        $query = $this->database->prepare("SELECT * FROM Players WHERE login = :login AND password = :pwd;");
        $query->execute(array( 'login' => $login, 'pwd' => $pwd ));
        $refletedObject = new ReflectionObject(new Player());
		$query->setFetchMode(PDO::FETCH_CLASS, $refletedObject->getName());
       
		return $query->fetch();
    }	
}
?>