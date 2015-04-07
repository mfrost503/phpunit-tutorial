<?php
namespace Tutorial\Serializer;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @package Tutorial
 * @subpackage Serializer
 */ 
class ArraySerializer implements SerializerInterface
{
    /**
     * @param mixed $input
     * @return Array
     *
     * Serialize an input to array
     */
    public function serialize($input)
    {
        $output = [];
        if (is_object($input)) {
            return get_object_vars($input);
        }

        if (is_string($input)) {
            return ($json = json_decode($input, true)) ? $json : $output;
        }

        if (is_array($input)) {
            return $input;
        }

        return $output;
    }
}
