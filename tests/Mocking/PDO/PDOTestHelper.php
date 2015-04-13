<?php
namespace Tutorial\Tests\Mocking\PDO;
use PDO;
/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @package tests
 * @subpackage Tutorial
 * @subpackage Mocking
 * @subpackage PDO
 * @license MIT http://opensource.org/licenses/MIT
 */
class PDOTestHelper extends PDO
{
    /**
     * PDO Constructor is not serializable, must override the
     * construct method in order to use for mocking
     */
    public function __construct()
    {
    }
}
