<?php
class CollectionUtils
{
	private function CollectionUtils(){}
	
	/**
	 * check if an array is empty
	 * 
	 * @param $array
	 */
	public static function isEmpty($array)
	{
		return ($array == null || count($array) === 0);
	}
	
	/**
	 * check if an array is not empty
	 * @param $array
	 */
	public static function isNotEmpty($array)
	{
		return ($array != null && count($array) > 0);
	}
}
?>