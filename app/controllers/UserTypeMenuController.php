<?php

require_once __DIR__ . '/../models/UserTypeMenu.php';
require_once __DIR__ . '/../models/UserType.php';
require_once __DIR__ . '/../models/Menu.php';

class UserTypeMenuController
{
    private $db;

    public function __construct()
    {
        $this->db = new mysqli("localhost", "root", "", "food_ordering_system");
    }

    // Show mappings
    public function index()
    {
        $mappings   = UserTypeMenu::getUserTypeMenus($this->db);
        $user_types = UserType::getUserTypes($this->db);
        $menus      = Menu::getMenus($this->db);

        include __DIR__ . '/../views/usertype_menu/index.php';
    }

    // Create mapping
    public function store()
    {
        $map = new UserTypeMenu(
            null,
            $_POST['user_type_id'],
            $_POST['menu_id']
        );

        $map->createUserTypeMenu($this->db);

        header("Location: index.php?action=usertype_menu");
    }

    // Update mapping
    public function update()
    {
        $map = new UserTypeMenu(
            $_POST['id'],
            $_POST['user_type_id'],
            $_POST['menu_id']
        );

        $map->updateUserTypeMenu($this->db);

        header("Location: index.php?action=usertype_menu");
    }

    // Delete mapping
    public function delete()
    {
        $map = new UserTypeMenu(
            $_GET['id'],
            0,
            0
        );

        $map->deleteUserTypeMenu($this->db);

        header("Location: index.php?action=usertype_menu");
    }
}

?>