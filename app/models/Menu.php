<?php

class Menu
{
    private $id;
    private $name;
    private $description;

    public function __construct($id, $name, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    // Create Menu
    public function createMenu($db)
    {
        $sql = "INSERT INTO menu (name, description)
                VALUES ('$this->name', '$this->description')";

        $db->query($sql);
    }

    // Read Menus
    public static function getMenus($db)
    {
        $sql = "SELECT * FROM menu";

        $result = $db->query($sql);

        return $result;
    }

    // Update Menu
    public function updateMenu($db)
    {
        $sql = "UPDATE menu
                SET name='$this->name',
                    description='$this->description'
                WHERE id='$this->id'";

        $db->query($sql);
    }

    // Delete Menu
    public function deleteMenu($db)
    {
        $sql = "DELETE FROM menu WHERE id='$this->id'";

        $db->query($sql);
    }
}

?>