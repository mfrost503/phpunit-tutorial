<?php
namespace Tutorial\Math;
use \InvalidArgumentException;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @package Tutorial
 * @subpackage Math
 */
class Addition
{
    /**
     * @var array
     */
    private $numbers;

    /**
     * @param Array $numbers
     *
     * Constructor
     */
    public function __construct(Array $numbers)
    {
        $this->numbers = $numbers;
    }

    /**
     * @param int $offset
     * @return int
     *
     * Method to return the sum of the array, offset allows
     * allows for numbers to be added to a certain point
     */
    public function sum($offset = -1)
    {
        if (!is_int($offset)) {
            throw new InvalidArgumentException("Offset must be an integer");
        }

        // Normally we'd just use array_sum here, but lets assume we don't want
        // to make non-numeric entries default to 0.
        // Is there a way we can refactor this?
        $sum = 0;
        foreach ($this->numbers as $number) {
            if (!is_numeric($number)) {
                throw new InvalidArgumentException("All array elements must be numeric");
            }
            $sum += $number;
        } 

        return $sum;
    }
}
