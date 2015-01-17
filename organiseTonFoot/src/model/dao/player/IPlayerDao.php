<?php
    interface IPlayerDao
    {
       /**
        * function findByCredentials
        * 
        * Find a player by his login and password
        * 
        * @param String $login : player login
        * @param String $password : player hashed password
        * @return Player
        */
        function findByCredentials($login, $pwd);
        
        /**
         * Method register
         * 
         * Register player
         * 
         * @param Player $player
         */
        function register(Player $player);
    }
?>