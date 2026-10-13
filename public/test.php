<?php
require_once '../app/models/User.php';

$user = new User();
print_r($user->read());