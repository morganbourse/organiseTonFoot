<?php
importController('Controller.php');
importBean('player/PlayerBean.php');
importModel('services/player/impl/PlayerService.php');

/**
 *
 * @author Morgan
 * @since 26 nov. 2014
 *       
 *        The AddressController class
 */
class AddressController extends Controller {
    const TPL = "address/addressList";
    const TPL_ADD = "address/addAddress";
    private $playerService;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::Controller ();
        $this->playerService = new PlayerService ();
    }
    
    /**
     * display address list page
     */
    public function index() {
        echo $this->draw ( self::TPL );
    }
    
    /**
     * display add address page
     */
    public function addPage() {
        echo $this->draw ( self::TPL_ADD );
    }
    
    /**
     * create player account
     */
    public function add($data) {
        $playerBean = new PlayerBean();
        MapperUtils::mapDataArrayToObject($data, $playerBean, array("username" => "login", "mail" => "email", "cp" => "postalCode"), array("pwdConfirm"));
                
        $this->playerService->register($playerBean);
        JsonUtils::renderSuccessAndDisplayPage( "Compte créé", $this->getTemplateAsString("register/registerSuccess") );
    }
}
?>