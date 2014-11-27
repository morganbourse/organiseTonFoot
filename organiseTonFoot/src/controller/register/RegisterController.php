<?php
require_once (ROOT_DIR_SRC . 'controller/Controller.php'); 

/**
 * RegisterController
 * @author Morgan
 *
 */
class RegisterController extends Controller
{
	const TPL = "register/registerForm";
	
	/**
	 * display register page
	 */
	public function index()
	{
		$this->draw(self::TPL);
	}
	
	/**
	 * register user
	 * 
	 * @param Array $data
	 */
	public function register($data)
	{
	    JsonUtils::renderSuccess("Utilisateur créé !!");
	}
}
?>