<?php

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $user_type_id;

    public function __construct($id = null, $name = null, $email = null, $password = null, $user_type_id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->user_type_id = $user_type_id;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getUserTypeId() {
        return $this->user_type_id;
    }

    // Create User
    public function createUser($db)
    {
        $password = password_hash($this->password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password, user_type_id)
                VALUES ('$this->name', '$this->email', '$password', '$this->user_type_id')";

        $db->query($sql);
    }

    // Read Users
    public static function getUsers($db)
    {
        $sql = "SELECT u.*, ut.type_name FROM users u LEFT JOIN user_types ut ON u.user_type_id = ut.id";

        $result = $db->query($sql);

        return $result;
    }

    // Update User
    public function updateUser($db)
    {
        $sql = "UPDATE users
                SET name='$this->name',
                    email='$this->email',
                    user_type_id='$this->user_type_id'
                WHERE id='$this->id'";

        $db->query($sql);
    }

    // Delete User
    public function deleteUser($db)
    {
        $sql = "DELETE FROM users WHERE id='$this->id'";

        $db->query($sql);
    }

    // Login
    public static function findByEmail($db, $email)
    {
        $sql = "SELECT * FROM users WHERE email='$email'";

        $result = $db->query($sql);

        return $result->fetch_assoc();
    }
}

?>