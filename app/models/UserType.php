<?php

class UserType
{
    private $id;
    private $type_name;

    public function __construct($id, $type_name)
    {
        $this->id = $id;
        $this->type_name = $type_name;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getTypeName() {
        return $this->type_name;
    }

    // Create User Type
    public function createUserType($db)
    {
        $sql = "INSERT INTO user_types (type_name)
                VALUES ('$this->type_name')";

        $db->query($sql);
    }

    // Read User Types
    public static function getUserTypes($db)
    {
        $sql = "SELECT * FROM user_types";

        $result = $db->query($sql);

        return $result;
    }

    // Update User Type
    public function updateUserType($db)
    {
        $sql = "UPDATE user_types
                SET type_name='$this->type_name'
                WHERE id='$this->id'";

        $db->query($sql);
    }

    // Delete User Type
    public function deleteUserType($db)
    {
        $sql = "DELETE FROM user_types WHERE id='$this->id'";

        $db->query($sql);
    }
}

?>