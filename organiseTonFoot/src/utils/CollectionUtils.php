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
	
	/**
	 * check if arr1 have same size of arr2
	 * @param array $arr1
	 * @param array $arr2
	 * @return boolean
	 */
	public static function collectionSameSize($arr1, $arr2)
	{
	    return (count($arr1) == count($arr2));
	}
}
?>