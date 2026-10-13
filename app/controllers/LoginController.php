<?php
require_once __DIR__ . '/../models/User.php';

class LoginController {
    private $db;

    public function __construct() {
        $this->db = new mysqli("localhost", "root", "", "food_ordering_system");
    }

    public function showLogin() {
        include __DIR__ . '/../views/auth/login.php';
    }

    public function login() {
        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            header("Location: index.php?action=login&error=1");
            exit;
        }

        $user = User::findByEmail($this->db, $email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']      = $user['id'];
            $_SESSION['user_type_id'] = $user['user_type_id'];
            $_SESSION['user_name']    = $user['name'];

            if ($user['user_type_id'] == 1) {
                header("Location: index.php?action=admin_dashboard");
            } else {
                header("Location: index.php?action=customer_dashboard");
            }
            exit;
        }

        header("Location: index.php?action=login&error=1");
        exit;
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }
}
