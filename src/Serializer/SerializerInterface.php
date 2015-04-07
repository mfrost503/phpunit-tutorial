<?php
namespace Tutorial\Serializer;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @package Tutorial
 * @subpackage Serializer
 */
interface SerializerInterface
{
    /**
     * @param mixed $input
     * @return mixed
     *
     * Serialization method to be implemented
     */
    public function serialize($input);
}    
