<?php
importUtil('LoggerUtils.php');
/**
 * Safe Pdo
 * @author Morgan
 *
 */
Class SafePDO extends PDO {
	/**
	 * function exception_handler
	 * @param unknown_type $exception
	 */
	public static function exception_handler($exception) {
        LoggerUtils::getLogger()->error('Uncaught exception: ' . $exception->getMessage(), $exception);
		die('Could not connect to the database');
	}

	/**
	 * Constructeur
	 * @param unknown_type $dsn
	 * @param unknown_type $username
	 * @param unknown_type $password
	 * @param unknown_type $driver_options
	 */
	public function __construct($dsn, $username='', $password='', $driver_options=array()) {
		// Temporarily change the PHP exception handler while we . . .
		set_exception_handler(array(__CLASS__, 'exception_handler'));

		// . . . create a PDO object
		parent::__construct($dsn, $username, $password, $driver_options);

		// Change the exception handler back to whatever it was before
		restore_exception_handler();
	}

}

?>