<?php
namespace Tutorial\Tests\Serializer;
use Tutorial\Serializer\ArraySerializer;
use PHPUnit_Framework_TestCase;
use stdClass;
 
/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @package Tutorial
 * @subpackage Tests
 * @subpackage Serializer
 */
class ArraySerializerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Tutorial\Serializer\ArraySerializer
     */
    private $arraySerializer;

    /**
     * Setup method runs before each test
     */
    protected function setUp()
    {
        $this->arraySerializer = new ArraySerializer();
    }

    /**
     * TearDown method runs after each test
     */
    protected function tearDown()
    {
        unset($this->arraySerializer);
    }

    /**
     * Test to ensure that an object is serialized to array
     */
    public function testEnsureObjectIsSerializedToArray()
    {
        $object = new stdClass;
        $object->firstName = 'Mike';
        $object->lastName = 'Jones';
        $object->email = 'test@test.com';
        $object->phone = '111-111-1111';
        $array = $this->arraySerializer->serialize($object);
        $this->assertEquals($array['firstName'], $object->firstName);
    }

    /**
     * Test to ensure that a JSON string is converted to an array
     */
    public function testEnsureJSONIsSerializedToArray()
    {
        $inputArray =
            [
                'firstName' => 'Mike',
                'lastName' => 'Jones',
                'phone' => '111-111-1111',
                'email' => 'test@test.com'
            ];
        $json = json_encode($inputArray);

        // ensure we got a valid json string
        $this->assertInternalType('string', $json);

        $array = $this->arraySerializer->serialize($json);
        $this->assertEquals(
            $array['firstName'],
            $inputArray['firstName']
        );
        $this->assertSame($array, $inputArray);

    }
}
