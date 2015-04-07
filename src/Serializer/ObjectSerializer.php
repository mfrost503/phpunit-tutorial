<?php
namespace Tutorial\Serializer;
use InvalidArgumentException;
use stdClass;
/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @package Tutorial
 * @subpackage Serializer
 */ 
class ObjectSerializer implements SerializerInterface
{
    /**
     * @var object
     */
    private $object = null;

    /**
     * Constructor
     *
     * @param object $object
     */
    public function __construct($object = null)
    {
        if ($object !== null && !is_object($object)) {
            throw new InvalidArgumentException("An object or null must be provided to the constructor");
        }
        $this->object = $object;
    }

    /**
     * Method to serialize an input to an object
     *
     * @param mixed $input
     * @return stdClass
     */
    public function serialize($input)
    {
        $output = $this->object;
        if ($output === null) {
            $output = new stdClass;
        }

        if (is_array($input)) {
            return $this->convertArray($input, $output);
        }

        if (is_string($input)) {
            $json = json_decode($input);
            return (!is_null($json)) ? $this->convertObject($json) : $output;
        }

        if (is_object($input)) {
            return $input;
        }

        return $output;
    }

    /**
     * @param Array $input
     * @param object $output
     *
     * Method to faciliate the conversion of array to object
     */
    public function convertArray(Array $input, $output)
    {
        if (!is_object($output)) {
            return [];
        }

        foreach ($input as $key => $value) {
           $output->$key = $value;
        }
        return $output;
    } 

    /**
     * Method for converting a stdClass to the provided type
     *
     * @param stdClass $input
     * @return object
     */
    public function convertObject(stdClass $input)
    {
        if ($this->object === null) {
            return $input;
        }
        $properties = get_object_vars($input);
        $output = $this->object;
        foreach ($properties as $key => $value) {
            $output->$key = $value;
        }

        return $output;
    }
}
