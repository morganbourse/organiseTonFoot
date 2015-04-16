<?php
importUtil('mail/MailFormatException.php');
importUtil('StringUtils.php');
/**
 * Send mail utils class
 * @author Morgan
 */
class MailUtils
{
	private $expediteur;
	private $destinataire;
	private $header;
	
	const NB_TENTATIVE_MAX = 1;
	
	/**
	 * Constructor
	 * @param unknown $from
	 * @param unknown $destinataire
	 * @param string $expediteurName
	 * @throws MailFormatException
	 */
	public function MailUtils($from, $destinataire, $expediteurName = null)
	{
		if(!self::isValidMail($from))
		{
			throw new MailFormatException("L'adresse mail de l'expediteur $from est invalide.", "INVALID_MAIL");
		}
		
		if(!self::isValidMail($destinataire))
		{
			throw new MailFormatException("L'adresse mail du destinataire est $destinataire invalide.", "INVALID_MAIL");
		}
		
		$this->expediteur = $from;
		$this->destinataire = $destinataire;
		
		$headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
		
		if(StringUtils::isBlank($expediteurName))
		{
			$headers .= "From: $from\n"; // Expediteur
		}
		else
		{
			$headers .= 'From: "' . $expediteurName . '"<'.$from.'>'."\n"; // Expediteur
		}
		
		$headers .= 'Delivered-to: '.$destinataire."\n\n"; // Destinataire
		
		$this->header = $headers;
	}
	
	/**
	 * Send an email
	 * 
	 * @param String $object
	 * @param String $message
	 * @return boolean
	 */
	public function send($object, $message)
	{
		$tentative = 0;
		$envoi = false;

		While ($tentative < self::NB_TENTATIVE_MAX && !$envoi){ 
			$tentative++;
			$t0 = $this->microtime_float();
			
			$reponse = @mail($this->destinataire, $object, $message, $this->header);
			
			$t1 = $this->microtime_float();
			
			//TODO : local mock;
			$envoi = $reponse;
			
			/*$duree = $t1-$t0;
			
			if($reponse && $duree > 1.50)
			{
				$envoi = true;
			}
			else
			{
				$envoi = false;
				$pause = 0;
				
				while ($pause < 2.00){ // Ne pas descendre plus bas que 2s : moins bons résultats
					$t2 = $this->microtime_float();
					$pause = $t2-$t1;
				}
			}*/
		}

		return $envoi;
	}


	/**
	 * get timestamp
	 * @return number
	 */
	private function microtime_float(){
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

	/**
	 * Check valide email format
	 * 
	 * @param String $mail
	 * @return boolean
	 */
	public static function isValidMail($mail) 
	{
		return (!StringUtils::isBlank($mail) && preg_match("/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/i", $mail));
	}
}
?>