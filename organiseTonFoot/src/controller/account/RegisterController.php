<?php
importController('Controller.php');
importBean('player/PlayerBean.php');
importModel('services/player/impl/PlayerService.php');

/**
 *
 * @author Morgan
 * @since 26 nov. 2014
 *       
 *        The RegisterController class
 */
class RegisterController extends Controller {
    const TPL = "register/registerForm";
    private $playerService;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::Controller ();
        $this->playerService = new PlayerService ();
    }
    
    /**
     * display register page
     */
    public function index() {
        echo $this->draw ( self::TPL );
    }
    
    /**
     * create player account
     */
    public function register($data) {
        $playerBean = new PlayerBean();
        MapperUtils::mapDataArrayToObject($data, $playerBean, array("username" => "login", "mail" => "email", "cp" => "postalCode"), array("pwdConfirm"));
                
        $this->playerService->register($playerBean);
        JsonUtils::renderSuccessAndDisplayPage( "Compte créé", $this->getTemplateAsString("register/registerSuccess") );
    }
}
?>