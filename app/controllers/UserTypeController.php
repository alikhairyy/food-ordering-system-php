<?php

require_once __DIR__ . '/../models/UserType.php';

class UserTypeController
{
    private $db;

    public function __construct()
    {
        $this->db = new mysqli("localhost", "root", "", "food_ordering_system");
    }

    // Show User Types
    public function index()
    {
        $types = UserType::getUserTypes($this->db);

        include __DIR__ . '/../views/user_types/index.php';
    }

    // Create User Type
    public function store()
    {
        $type = new UserType(
            null,
            $_POST['type_name']
        );

        $type->createUserType($this->db);

        header("Location: index.php?action=user_types");
    }

    // Update User Type
    public function update()
    {
        $type = new UserType(
            $_POST['id'],
            $_POST['type_name']
        );

        $type->updateUserType($this->db);

        header("Location: index.php?action=user_types");
    }

    // Delete User Type
    public function delete()
    {
        $type = new UserType(
            $_GET['id'],
            ''
        );

        $type->deleteUserType($this->db);

        header("Location: index.php?action=user_types");
    }
}

?>