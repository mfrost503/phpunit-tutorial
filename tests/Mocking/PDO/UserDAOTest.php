<?php
namespace Tutorial\Tests\Mocking\PDO;
use PDO;
use PDOException;
use Tutorial\Mocking\PDO\UserDAO;
use PDOTestHelper;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use PDOStatement;
/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @package tests
 * @subpackage Tutorial
 * @subpackage Mocking
 * @subpackage PDO
 * @license MIT http://opensource.org/licenses/MIT
 */
class UserDAOTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PDOTestHelper
     */
    private $pdo;

    /**
     * @var PDOStatement
     */
    private $statement;

    /**
     * Set up - runs before each test
     */
    protected function setUp()
    {
        $this->pdo = $this->getMock('\Tutorial\Tests\Mocking\PDO\PDOTestHelper', ['prepare']);
        $this->statement = $this->getMock('\PDOStatement', ['execute', 'fetch', 'fetchAll']);
    }

    /**
     * Tear down method runs after each test
     */
    protected function tearDown()
    {
        unset($this->pdo);
        unset($this->statement);
    }

    /**
     * Test to ensure the retrieve method returns a response
     */
    public function testUserDAORetrieveReturnsResult()
    {
        $returnData = [
            'first_name' => 'Tim',
            'last_name' => 'Armstrong',
            'phone' => '111-111-1111',
            'email' => 'tim@testaccount.com'
        ];
        
        $expectedQuery = "SELECT first_name, last_name, phone, email from users where id = :id";
        $id = 5;

        // configure mocks
        $this->statement->expects($this->once())
            ->method('execute')
            ->with(['id' => $id])
            ->will($this->returnValue($this->statement));

        $this->statement->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue($returnData));

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with($expectedQuery)
            ->will($this->returnValue($this->statement));

        $user = new UserDAO($this->pdo);
        $response = $user->retrieve($id);

        $this->assertEquals('Tim', $response['first_name']);
        $this->assertEquals('Armstrong', $response['last_name']);
        $this->assertEquals('111-111-1111', $response['phone']);
        $this->assertEquals('tim@testaccount.com', $response['email']);
    }

    /**
     * Test to ensure retrieveAll returns multiple results
     */
    public function testRetrieveAllMethodReturnsMultipleresults()
    {
        $returnData = [
            [
                'first_name' => 'Tim',
                'last_name' => 'Armstrong',
                'phone' => '111-111-1111',
                'email' => 'tim@testaccount.com'
            ],
            [
                'first_name' => 'Mike',
                'last_name' => 'Jones',
                'phone' => '111-111-1112',
                'email' => 'mikejones@testaccount.com'
            ],
            [ 
                'first_name' => 'Lil',
                'last_name' => 'Jon',
                'phone' => '111-111-1113',
                'email' => 'liljon@testaccount.com'
            ]
        ];

        $expectedQuery = "SELECT first_name, last_name, phone, email from users";
        $this->statement->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($this->statement));

        $this->statement->expects($this->once())
            ->method('fetchAll')
            ->will($this->returnValue($returnData));

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with($expectedQuery)
            ->will($this->returnValue($this->statement));

        $user = new UserDAO($this->pdo);
        $users = $user->retrieveAll();
        $this->assertEquals(3, count($users));
        $this->assertEquals('Tim', $users[0]['first_name']);
        $this->assertEquals('Jones', $users[1]['last_name']);
        $this->assertEquals('111-111-1113', $users[2]['phone']);
        $this->assertEquals('liljon@testaccount.com', $users[2]['email']);
    }

    /**
     * Test to ensure that the user create method returns the user
     */
    public function testEnsureUserCreateReturnsUserData()
    {
        $input = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'phone' => '111-222-3123',
            'email' => 'test@testaccount.com'
        ];

        $expectedQuery = "INSERT INTO `users` (`first_name`, `last_name`, `phone`, `email`) VALUES (:first_name, :last_name, :phone, :email)";

        $this->statement->expects($this->once())
            ->method('execute')
            ->with($input)
            ->will($this->returnValue($this->statement));

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with($expectedQuery)
            ->will($this->returnValue($this->statement));

        $user = new UserDAO($this->pdo);
        $userInfo = $user->create($input);
        $this->assertEquals('Test', $userInfo['first_name']);
        $this->assertEquals('User', $userInfo['last_name']);
        $this->assertEquals('111-222-3123', $userInfo['phone']);
        $this->assertEquals('test@testaccount.com', $userInfo['email']);
    }

    /**
     * Test to ensure that the user create method returns the user
     */
    public function testEnsureUserUpdateReturnsTrue()
    {
        $input = [
            'id' => 1,
            'first_name' => 'Test',
            'last_name' => 'User',
            'phone' => '111-222-3123',
            'email' => 'test@testaccount.com'
        ];

        $expectedQuery = "UPDATE `users` SET first_name=:first_name, last_name=:last_name, phone=:phone, email=:email where id=:id";

        $this->statement->expects($this->once())
            ->method('execute')
            ->with($input)
            ->will($this->returnValue($this->statement));

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with($expectedQuery)
            ->will($this->returnValue($this->statement));

        $user = new UserDAO($this->pdo);
        $this->assertTrue($user->update($input));
    }

    /**
     * Test to ensure that user delete returns true
     */
    public function testEnsureUserDeleteReturnsTrue()
    {
        $id = 1;
        $expectedQuery = "DELETE FROM `users` WHERE id=:id";

        $this->statement->expects($this->once())
            ->method('execute')
            ->with(['id' => $id])
            ->will($this->returnValue($this->statement));

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with($expectedQuery)
            ->will($this->returnValue($this->statement));

        $user = new UserDAO($this->pdo);
        $this->assertTrue($user->delete($id));
    }

    /**
     * There are some other paths that need to be tested in the UserDAO class,
     * you have some good examples of how to write tests with Mocks. See if you
     * can write some of these tests on your own. You may need to use the following:
     * @expectedException, $this->throwException (instead of $this->returnValue)
     *
     * Also, try to use some tests to find a couple hidden bugs in this example.
     * Hint: they have to do with the array arguments in some of the classes.
     * If you find a bug, see if you can write a test to fix it and refactor the
     * code
     */
}

