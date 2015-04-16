<?php
importController('Controller.php');
importBean('player/PlayerBean.php');
importModel('services/player/impl/PlayerService.php');

/**
 * AuthController
 * @author Morgan
 *
 */
class AuthController extends Controller
{
	const TPL = "auth/authenticateForm";
    private $playerService;
	
    /**
     * Constructor
     */
    public function AuthController()
    {
        parent::Controller();
        $this->playerService = new PlayerService();
    }
    
	/**
	 * display authentication page
	 */
	public function index()
	{
        echo $this->getTemplateAsString(self::TPL);
	}
    
    /**
     * try to authenticate user
     **/
    public function authentify($data)
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