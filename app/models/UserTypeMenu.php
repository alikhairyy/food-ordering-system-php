<?php

class UserTypeMenu
{
    private $id;
    private $user_type_id;
    private $menu_id;

    public function __construct($id, $user_type_id, $menu_id)
    {
        $this->id = $id;
        $this->user_type_id = $user_type_id;
        $this->menu_id = $menu_id;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUserTypeId() {
        return $this->user_type_id;
    }

    public function getMenuId() {
        return $this->menu_id;
    }

    // Create
    public function createUserTypeMenu($db)
    {
        $sql = "INSERT INTO usertype_menu (user_type_id, menu_id)
                VALUES ('$this->user_type_id', '$this->menu_id')";

        $db->query($sql);
    }

    // Read
    public static function getUserTypeMenus($db)
    {
        $sql = "SELECT um.*, ut.type_name, m.name as menu_name
                FROM usertype_menu um
                JOIN user_types ut ON um.user_type_id = ut.id
                JOIN menu m ON um.menu_id = m.id";

        $result = $db->query($sql);

        return $result;
    }

    // Update
    public function updateUserTypeMenu($db)
    {
        $sql = "UPDATE usertype_menu
                SET user_type_id='$this->user_type_id',
                    menu_id='$this->menu_id'
                WHERE id='$this->id'";

        $db->query($sql);
    }

    // Delete
    public function deleteUserTypeMenu($db)
    {
        $sql = "DELETE FROM usertype_menu WHERE id='$this->id'";

        $db->query($sql);
    }
}

?>