<?php
importController('Controller.php');

/**
 * HomeController
 * @author Morgan
 *
 */
class HomeController extends Controller
{
	const TPL = "home";
	
	/**
	 * display home page
	 */
	public function index()
	{
		$this->draw(self::TPL);
	}
}
?>