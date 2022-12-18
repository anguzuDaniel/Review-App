<?php

/**
 * [creates a user in the database]
 */
class User
{
    /**
     * @var [type]
     */
    public $id;

    /**
     * @var [type]
     */
    public $email;

    /**
     * userName
     *
     * @var mixed
     */
    public $userName;

    /**
     * @var [type]
     */
    public $password;

    /**
     * @param mixed $conn
     * @param mixed $username
     * @param mixed $password
     * 
     * @return [type]
     */
    public static function authenticate($conn, $email, $password)
    {
        $sql = 'SELECT * 
                FROM `user`
                WHERE email = :email ';

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');

        $stmt->execute();

        if ($user = $stmt->fetch()) {
            return password_verify($password, $user->password);
        }
    }

    /**
     * @param mixed $conn
     * @param string $columns
     * 
     * @return [type]
     */
    public function getUserInfo($conn, $columns = '*')
    {

        $sql = "SELECT $columns FROM user WHERE id = :id ";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');

        $stmt->execute();

        if ($user = $stmt->fetch()) {
            return $user;
        }
    }

    public function addUser($conn, $email, $name, $password)
    {
        $sql = 'INSERT INTO user (email, user_name, password) 
                VALUES (:email, :userName, :password)';

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':userName', $name, PDO::PARAM_STR);

        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
