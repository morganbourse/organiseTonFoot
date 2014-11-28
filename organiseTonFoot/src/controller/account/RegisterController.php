<?php
require_once (ROOT_DIR_SRC . 'controller/Controller.php');
require_once (ROOT_DIR_SRC . 'controller/bean/player/PlayerBean.php');
require_once (ROOT_DIR_SRC . 'model/services/player/impl/PlayerService.php');

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
        JsonUtils::renderSuccess ( "Compte créé" );
    }
}
?>