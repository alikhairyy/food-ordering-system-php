<?php

require_once __DIR__ . '/../models/Menu.php';

class MenuController
{
    private $db;

    public function __construct()
    {
        $this->db = new mysqli("localhost", "root", "", "food_ordering_system");
    }

    // Show Menus
    public function index()
    {
        $menus = Menu::getMenus($this->db);

        include __DIR__ . '/../views/menu/index.php';
    }

    // Create Menu
    public function store()
    {
        $menu = new Menu(
            null,
            $_POST['name'],
            $_POST['description']
        );

        $menu->createMenu($this->db);

        header("Location: index.php?action=menu");
    }

    // Update Menu
    public function update()
    {
        $menu = new Menu(
            $_POST['id'],
            $_POST['name'],
            $_POST['description']
        );

        $menu->updateMenu($this->db);

        header("Location: index.php?action=menu");
    }

    // Delete Menu
    public function delete()
    {
        $menu = new Menu(
            $_GET['id'],
            '',
            ''
        );

        $menu->deleteMenu($this->db);

        header("Location: index.php?action=menu");
    }
}

?>