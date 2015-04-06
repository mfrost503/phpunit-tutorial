<?php
namespace Tutorial\Tests\Math;
use Tutorial\Math\Addition;
use \InvalidArgumentException;
use PHPUnit_Framework_TestCase;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @package Tutorial
 * @subpackage Tests 
 * @subpackage Math
 */
class AdditionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Tutorial\Math\Addition
     */
    private $addition;

    /**
     * Setup Method, runs before each test
     */
    protected function setUp()
    {
    }

    /**
     * Tear down method runs after each test
     */
    protected function tearDown()
    {
    }

    /**
     * Test to ensure that the addition class adds numbers in an array
     * successfully
     */
    public function testAdditionAddsArrayCorrectly()
    {
        // provide the body of the test to ensure the method is working correctly
    }
}
