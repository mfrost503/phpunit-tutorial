<?php
namespace Tutorial\Mocking\PDO;
use PDO;
use InvalidArgumentException;
use PDOException;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @package Tutorial
 * @subpackage Mocking
 * @subpackage PDO
 */ 
class UserDAO
{
    /**
     * @var PDO
     */
    private $dbClient;

    /**
     * Constructor
     *
     * @param PDO $dbClient
     */
    public function __construct(PDO $dbClient)
    {
        $this->dbClient = $dbClient;
    }

    /**
     * Method to retrieve a single user from the DAO
     *
     * @param int $id
     * @return array
     * @throws PDOException
     * @throws InvalidArgumentException
     */
    public function retrieve($id)
    {
        if (! is_int($id)) {
            throw new InvalidArgumentException("Parameter must be int");
        }

        try {
            $query = "SELECT first_name, last_name, phone, email from users where id = :id";
            $statement = $this->dbClient->prepare($query);
            $statement->execute(['id' => $id]);
            $results = $statement->fetch(); 
        } catch (PDOException $e) {
            // do something with it here
        }
        return $results;
    }

    /**
     * Method to retrieve all the users
     *
     * @return Array
     * @throws PDOException
     */
    public function retrieveAll()
    {
        $query = "SELECT first_name, last_name, phone, email from users";
        try {
            $statement = $this->dbClient->prepare($query);
            $statement->execute();
            $results = $statement->fetchAll();
        } catch (PDOException $e) {
            // handle the exception
        }
        return $results;
    }

    /**
     * Method to create a new user
     *
     * @param Array $userDetails
     * @throws PDOException
     */
    public function create(Array $userDetails)
    {
        $query = "INSERT INTO `users` (`first_name`, `last_name`, `phone`, `email`) VALUES (:first_name, :last_name, :phone, :email)";
        try {
            $statement = $this->dbClient->prepare($query);
            $statement->execute([
                'first_name' => $userDetails['first_name'],
                'last_name' => $userDetails['last_name'],
                'phone' => $userDetails['phone'],
                'email' => $userDetails['email']
            ]);
        } catch (PDOException $e) {
            // handle it
            return null;
        }
        return [
            'first_name' => $userDetails['first_name'],
            'last_name' => $userDetails['last_name'],
            'phone' => $userDetails['phone'],
            'email' => $userDetails['email']
        ];
    }

    /**
     * Method to update an existing user
     *
     * @param Array $userDetails
     * @throws PDOException
     * @return boolean
     */
    public function update(Array $userDetails)
    {
        $query = "UPDATE `users` SET first_name=:first_name, last_name=:last_name, phone=:phone, email=:email where id=:id";
        try {
            $statement = $this->dbClient->prepare($query);
            $statement->execute([
                'id' => $userDetails['id'],
                'first_name' => $userDetails['first_name'],
                'last_name' => $userDetails['last_name'],
                'phone' => $userDetails['phone'],
                'email' => $userDetails['email']
            ]);
        } catch (PDOException $e) {
            //handle it
            return false;
        }
        return true;
    }

    /**
     * Method to delete an existing user
     *
     * @param int $id
     * @throws PDOException
     * @return boolean
     */
    public function delete($id)
    {
        $query = "DELETE FROM `users` WHERE id=:id";
        try {
            $statement = $this->dbClient->prepare($query);
            $statement->execute(['id' => $id]);
        } catch (PDOException $e) {
            // handle it
            return false;
        }
        return true;
    }
}
