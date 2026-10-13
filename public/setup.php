<?php

require_once '../app/config/database.php';

$db = (new Database())->connect();

// users
$users = [
    'admin@food.com' => 'admin123',
    'ahmed@food.com' => 'cust123',
    'sara@food.com'  => 'cust123'
];

foreach ($users as $email => $password) {

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE users 
            SET password='$hash' 
            WHERE email='$email'";

    $db->exec($sql);

    echo "$email updated <br>";
}

echo "Done";