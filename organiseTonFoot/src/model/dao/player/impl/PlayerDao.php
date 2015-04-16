<?php
importModel('dao/GenericDao.php');
importModel('dao/player/IPlayerDao.php');
importModel('entity/player/Player.php');
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
    public function findByCredentials($login, $pwd) {
        $query = $this->database->prepare("SELECT * FROM Players WHERE login = :login AND password = :pwd;");
        $query->execute(array( 'login' => $login, 'pwd' => $pwd ));
        $refletedObject = new ReflectionObject(new Player());
		$query->setFetchMode(PDO::FETCH_CLASS, $refletedObject->getName());
       
		return $query->fetch();
    }
        
    /**
     * @see IPlayerDao::register()
     */
    public function register(Player $player)
    {
        $this->insert($player);
    }
}
?>