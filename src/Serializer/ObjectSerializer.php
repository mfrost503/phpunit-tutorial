<?php
namespace Tutorial\Serializer;
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
     * @param mixed $input
     * @return stdClass
     *
     * Method to serialize an input to an object
     */
    public function serialize($input)
    {
        $output = new stdClass;

        if (is_array($input)) {
            return $this->convertArray($input, $output);
        }

        if (is_string($input)) {
            $json = json_decode($input);
            return (!$json) ? $json : $output;
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
}
