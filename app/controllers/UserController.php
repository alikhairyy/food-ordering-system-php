<?php

require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $db;

    public function __construct()
    {
        $this->db = new mysqli("localhost", "root", "", "food_ordering_system");
    }

    // Show Users
    public function index()
    {
        require_once __DIR__ . '/../models/UserType.php';
        $users      = User::getUsers($this->db)->fetch_all(MYSQLI_ASSOC);
        $user_types = UserType::getUserTypes($this->db)->fetch_all(MYSQLI_ASSOC);

        include __DIR__ . '/../views/users/index.php';
    }

    // Create User
    public function store()
    {
        $user = new User(
            null,
            $_POST['name'],
            $_POST['email'],
            $_POST['password'],
            $_POST['user_type_id']
        );

        $user->createUser($this->db);

        header("Location: index.php?action=users");
    }

    // Update User
    public function update()
    {
        $user = new User(
            $_POST['id'],
            $_POST['name'],
            $_POST['email'],
            '',
            $_POST['user_type_id']
        );

        $user->updateUser($this->db);

        header("Location: index.php?action=users");
    }

    // Delete User
    public function delete()
    {
        $user = new User(
            $_GET['id'],
            '',
            '',
            '',
            0
        );

        $user->deleteUser($this->db);

        header("Location: index.php?action=users");
    }
}

?>