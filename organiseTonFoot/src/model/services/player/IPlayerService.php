<?php
interface IPlayerService
{
   /**
    * function authenticate
    * 
    * authenticate a user by login and password
    * 
    * @param PlayerBean $player : player
    * @return PlayerBean
    */
    function authenticate(PlayerBean $player);
}
?>