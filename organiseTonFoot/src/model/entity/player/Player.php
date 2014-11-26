<?php
	class Player
	{
		private $login;
        private $password;
        private $name;
        private $surname;
        private $phone;
        private $email;
        private $address;
        private $postalCode;
        private $city;
		
        /**
         * get the player login
         */
		public function getLogin()
		{
			return $this->login;
		}
		
        /**
         * set the player login
         * @param $login : player login
         */
		public function setLogin($login)
		{
			$this->login = $login;
		}
        
        /**
         * get the player password
         */
		public function getPassword()
		{
			return $this->password;
		}
		
        /**
         * set the player password
         * @param $password : player password
         */
		public function setPassword($password)
		{
			$this->password = $password;
		}
        
        /**
         * get the player name
         */
		public function getName()
		{
			return $this->name;
		}
		
        /**
         * set the player name
         * @param $name : player name
         */
		public function setName($name)
		{
			$this->name = $name;
		}
        
        /**
         * get the player surname
         */
		public function getSurname()
		{
			return $this->surname;
		}
		
        /**
         * set the player surname
         * @param $surname : player surname
         */
		public function setSurname($surname)
		{
			$this->surname = $surname;
		}
        
        /**
         * get the player phone
         */
		public function getPhone()
		{
			return $this->phone;
		}
		
        /**
         * set the player phone
         * @param $phone : player phone
         */
		public function setPhone($phone)
		{
			$this->phone = $phone;
		}
        
        /**
         * get the player phone
         */
		public function getEmail()
		{
			return $this->email;
		}
		
        /**
         * set the player email
         * @param $email : player email
         */
		public function setEmail($email)
		{
			$this->email = $email;
		}
        
        /**
         * get the player address
         */
		public function getAddress()
		{
			return $this->address;
		}
		
        /**
         * set the player address
         * @param $address : player address
         */
		public function setAddress($address)
		{
			$this->address = $address;
		}
        
        /**
         * get the player postalCode
         */
		public function getPostalCode()
		{
			return $this->postalCode;
		}
		
        /**
         * set the player postalCode
         * @param $postalCode : player postalCode
         */
		public function setPostalCode($postalCode)
		{
			$this->postalCode = $postalCode;
		}
        
        /**
         * get the player city
         */
		public function getCity()
		{
			return $this->city;
		}
		
        /**
         * set the player city
         * @param $city : player city
         */
		public function setCity($city)
		{
			$this->city = $city;
		}
	}
?>