<?php
interface IPlayerService
{
   /**
    * function authenticate
    * 
    * authenticate a user by login and password
    * 
    * @param PlayerBean $playerBean : player
    * @return PlayerBean
    */
    function authenticate(PlayerBean $playerBean);
    
    /**
     * Method register
     * 
     * Register player
     * 
     * @param PlayerBean $playerBean
     */
    function register(PlayerBean $playerBean);
}
?>