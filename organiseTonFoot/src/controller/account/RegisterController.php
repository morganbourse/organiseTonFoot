<?php
require_once (ROOT_DIR_SRC . 'controller/Controller.php');
require_once (ROOT_DIR_SRC . 'controller/bean/player/PlayerBean.php');
require_once (ROOT_DIR_SRC . 'model/services/player/impl/PlayerService.php');

/**
 * @author Morgan
 * @since 26 nov. 2014
 *
 * The RegisterController class
 */
class RegisterController extends Controller
{
	const TPL = "register/registerForm";
    private $playerService;
	
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::Controller();
        $this->playerService = new PlayerService();
    }
    
	/**
	 * display register page
	 */
	public function index()
	{
        echo $this->draw(self::TPL);
	}
    
    /**
     * create player account
     **/
    public function register($data)
    {        
        $playerBean = new PlayerBean();
        $playerBean->setLogin($data['login']);
        $playerBean->setPassword($data['pwd']);
        
        try
        {
            $player = $this->playerService->authenticate($playerBean);
            JsonUtils::renderSuccess("Bienvenue " . $player->getSurname() . ".<br />Vous &ecirc;tes maintenant connect&eacute;(e)");    
        }
        catch(Exception $e){
            $message = $e->getMessage();
            
            if(StringUtils::equals(IPlayerErrors::PLAYER_NOT_FOUND_BY_CREDENTIALS, $message, false))
            {
                $message = "Impossible de vous identifier.<br />Login ou mot de passe incorrect";
            }
            
            /*
             * user by credentials not found
             * display an error message
             */
            JsonUtils::renderError($message);                 
        }
    }
}
?>