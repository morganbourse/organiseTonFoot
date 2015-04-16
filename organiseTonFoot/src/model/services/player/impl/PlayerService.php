<?php
importModel('services/player/IPlayerService.php');
importSrc('errors/IPlayerErrors.php');
importModel('dao/player/impl/PlayerDao.php');
importUtil('conf/ConfigUtils.php');
importController('bean/player/PlayerBean.php');
importModel('entity/player/Player.php');
importUtil('LoggerUtils.php');
importUtil('MapperUtils.php');

/**
 * PlayerService
 * 
 * @package model.services.impl.player
 * @author organiseTonFoot
 * @copyright Morgan BOURSE
 * @version 2014
 * @access public
 */
class PlayerService implements IPlayerService
{        
    private $playerDao;
    
    /**
     * PlayerService::PlayerService()
     * 
     * @return void
     */
    public function PlayerService()
    {        
        $this->playerDao = new PlayerDao();        
    }
    
    /**
     * PlayerService::authenticate()
     * 
     * @param PlayerBean $playerBean
     * @return PlayerBean
     */
    public function authenticate(PlayerBean $playerBean) {
        LoggerUtils::getLogger()->debug("user authentication...");
      
        $pwd = $playerBean->getPassword();
        $login = $playerBean->getLogin();
        
        $hashPassword = $this->hashPassword($login, $pwd);
        $player = $this->playerDao->findByCredentials($login, $hashPassword);
        if(null == $player)
        {
            LoggerUtils::getLogger()->debug("User by credentials not found");
            throw new Exception(IPlayerErrors::PLAYER_NOT_FOUND_BY_CREDENTIALS);
        }
        
        return $player;
    }
    
    /**
     * @see IPlayerService::register()
     */
    public function register(PlayerBean $playerBean)
    {
        LoggerUtils::getLogger()->debug("user registration...");       
        
        //hash the password and set into playerBean object
        $hashPassword = $this->hashPassword($playerBean->getLogin(), $playerBean->getPassword());
        $playerBean->setPassword($hashPassword);
        
        //map player bean to player entity object
        $player = new Player();
        MapperUtils::mapObjects($playerBean, $player);
        
        //open transaction
        $this->playerDao->beginTransaction();
        
        try {
            $this->playerDao->insert($player);
            
            //send confirmation mail
            
            $this->playerDao->commitTransaction();
        }
        catch (Exception $e)
        {
            $this->playerDao->rollbackTransaction();
            LoggerUtils::getLogger()->error("An error has occured during the transaction.", $e);
            throw $e;
        }
    }
    
    /**
     * PlayerService::hashPassword($pwd)
     * 
     * hash password
     * 
     * @param mixed $login
     * @param mixed $pwd
     * @return hash
     */
    private function hashPassword($login, $pwd)
    {
        $settings = ConfigUtils::loadConfigSettings();        
        $passwordSaltPrefix = trim($settings->security['passwordSaltPrefix']);        
        $passwordSaltSuffix = trim($settings->security['passwordSaltSuffix']);
                
        return hash("sha256", sha1($passwordSaltPrefix . $login) . $pwd . md5($login . $passwordSaltSuffix));
    }
}
?>