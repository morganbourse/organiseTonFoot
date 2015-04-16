<?php
importUtil("LoggerUtils.php");
/**
 * @author Morgan
 * @since 19 janv. 2015
 *
 * The MapperUtils class
 */
class MapperUtils
{
    /**
     * Constructor
     */
    private function MapperUtils(){
        
    }
    
    /**
     * Map received data to an object
     *
     * @param array $data : provided data
     * @param Object $object : expected object instance
     * @param [array $mapping] : mapping array as array("name" => "pseudo") for exemple
     * "name" is the name of provided data, "pseudo" is the name of the mapped attribute into object
     * @param array $ignoreFields : ignore fields mapping of mapped object
     */
    public static function mapDataArrayToObject(Array $data, &$object, Array $mapping = null, Array $ignoreFields = null)
    {
        if(CollectionUtils::isNotEmpty($data))
        {
            $reflectedObject = new ReflectionObject ( $object );
            foreach($data as $dataName => $value)
            {
                if(CollectionUtils::isNotEmpty($ignoreFields) && in_array($dataName, $ignoreFields))
                {
                    continue;
                }
    
                self::mapValue($object, $reflectedObject, $dataName, $value, $mapping);
            }
        }
    }
    
    /**
     * map bean to do object
     *
     * @param unknown $object1
     * @param unknown $object2
     */
    public static function mapObjects($object1, &$object2, Array $mapping = null, Array $ignoreFields = null) {
        $reflectedObject1 = new ReflectionObject ( $object1 );
        $object1FieldsArray = $reflectedObject1->getProperties ( ReflectionProperty::IS_PRIVATE );
    
        $reflectedObject2 = new ReflectionObject ( $object2 );
        $object2FieldsArray = $reflectedObject2->getProperties ( ReflectionProperty::IS_PRIVATE );
    
        if (CollectionUtils::isNotEmpty ( $object1FieldsArray ) && CollectionUtils::isNotEmpty ( $object2FieldsArray ) && CollectionUtils::collectionSameSize ( $object1FieldsArray, $object2FieldsArray )) {
            foreach ( $object1FieldsArray as $object1Field ) {
                $object1Field->setAccessible ( true );
                $object1FieldName = $object1Field->getName ();
    
                if(CollectionUtils::isNotEmpty($ignoreFields) && in_array($object1FieldName, $ignoreFields))
                {
                    continue;
                }
    
                self::mapValue($object2, $reflectedObject2, $object1FieldName, $object1Field->getValue ( $object1 ), $mapping);
            }
        }
    }
    
    /**
     * Method mapValue
     * 
     * @param unknown $object
     * @param unknown $reflectedObject
     * @param unknown $dataName
     * @param unknown $dataValue
     * @param unknown $mapping
     */
    private static function mapValue($object, $reflectedObject, $dataName, $dataValue, Array $mapping = null)
    {
        $objectName = $reflectedObject->getName();
        
        if ($reflectedObject->hasProperty ( $dataName )) {
            $objectProperty = $reflectedObject->getProperty ( $dataName );
            $objectProperty->setAccessible ( true );
            $objectProperty->setValue ( $object, $dataValue );
        }
        else if((CollectionUtils::isNotEmpty($mapping) && array_key_exists($dataName, $mapping)) && $reflectedObject->hasProperty ( $mapping[$dataName] ))
        {
            $objectProperty = $reflectedObject->getProperty ( $mapping[$dataName] );
            $objectProperty->setAccessible ( true );
            $objectProperty->setValue ( $object, $dataValue );
        }
        else
        {
            $msg = "Property '" . $dataName . "' does not exists in " . $objectName . " object.";
            LoggerUtils::getLogger()->error($msg);
            throw new ControllerException($msg);
        }
    }
}
?>