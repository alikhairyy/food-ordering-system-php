<?php

session_start();

// Base constants used by views
define('BASE_URL', 'index.php');
define('ROOT', dirname(__DIR__));
define('ASSETS_URL', '/FinalSoftware/assets');

$action = $_GET['action'] ?? 'login';

// login check
if ($action != 'login' && !isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit;
}

// controllers
require_once '../app/controllers/LoginController.php';
require_once '../app/controllers/ProductController.php';
require_once '../app/controllers/OrderController.php';
require_once '../app/controllers/OrderDetailController.php';
require_once '../app/controllers/MenuController.php';
require_once '../app/controllers/UserController.php';
require_once '../app/controllers/UserTypeController.php';
require_once '../app/controllers/UserTypeMenuController.php';

// routes
switch ($action) {

    // Auth
    case 'login':
        $controller = new LoginController();
        $controller->showLogin();
        break;

    case 'login_post':
        $controller = new LoginController();
        $controller->login();
        break;

    case 'logout':
        $controller = new LoginController();
        $controller->logout();
        break;

    // Dashboards
    case 'admin_dashboard':
        require_once '../app/models/User.php';
        require_once '../app/models/Order.php';
        require_once '../app/models/Menu.php';
        require_once '../app/models/product.php';
        $db       = new mysqli("localhost", "root", "", "food_ordering_system");
        $users    = User::getUsers($db)->fetch_all(MYSQLI_ASSOC);
        $res = $db->query("SELECT o.*, u.name as user_name FROM orders o LEFT JOIN users u ON o.user_id = u.id");
        $orders = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
        $menus    = Menu::getMenus($db)->fetch_all(MYSQLI_ASSOC);
        $products = Product::getProducts($db)->fetch_all(MYSQLI_ASSOC);
        $total_revenue = array_sum(array_column($orders, 'total_price'));
        include '../app/views/admin/dashboard.php';
        break;

    case 'customer_dashboard':
        require_once '../app/models/Order.php';
        require_once '../app/models/Menu.php';
        require_once '../app/models/product.php';
        $db        = new mysqli("localhost", "root", "", "food_ordering_system");
        $uid       = $_SESSION['user_id'];
        $res       = $db->query("SELECT * FROM orders WHERE user_id='$uid'");
        $my_orders = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
        $menus     = Menu::getMenus($db)->fetch_all(MYSQLI_ASSOC);
        $products  = Product::getProducts($db)->fetch_all(MYSQLI_ASSOC);
        include '../app/views/customer/dashboard.php';
        break;

    // Products
    case 'products':
        $controller = new ProductController();
        $controller->index();
        break;

    case 'product_store':
        $controller = new ProductController();
        $controller->store();
        break;

    case 'product_update':
        $controller = new ProductController();
        $controller->update();
        break;

    case 'product_delete':
        $controller = new ProductController();
        $controller->delete();
        break;

    // Orders
    case 'orders':
        $controller = new OrderController();
        $controller->index();
        break;

    case 'order_store':
        $controller = new OrderController();
        $controller->store();
        break;

    case 'order_update':
        $controller = new OrderController();
        $controller->update();
        break;

    case 'order_delete':
        $controller = new OrderController();
        $controller->delete();
        break;

    // Order Details
    case 'order_details':
        $controller = new OrderDetailController();
        $controller->index();
        break;

    case 'order_detail_store':
        $controller = new OrderDetailController();
        $controller->store();
        break;

    case 'order_detail_update':
        $controller = new OrderDetailController();
        $controller->update();
        break;

    case 'order_detail_delete':
        $controller = new OrderDetailController();
        $controller->delete();
        break;

    // Menu
    case 'menu':
        $controller = new MenuController();
        $controller->index();
        break;

    case 'menu_store':
        $controller = new MenuController();
        $controller->store();
        break;

    case 'menu_update':
        $controller = new MenuController();
        $controller->update();
        break;

    case 'menu_delete':
        $controller = new MenuController();
        $controller->delete();
        break;

    // Browse Menu (customer)
    case 'browse_menu':
        require_once '../app/models/Menu.php';
        require_once '../app/models/product.php';
        $db       = new mysqli("localhost", "root", "", "food_ordering_system");
        $menus    = Menu::getMenus($db)->fetch_all(MYSQLI_ASSOC);
        $products = Product::getProducts($db)->fetch_all(MYSQLI_ASSOC);
        include '../app/views/customer/browse_menu.php';
        break;

    // Users
    case 'users':
        $controller = new UserController();
        $controller->index();
        break;

    case 'user_store':
        $controller = new UserController();
        $controller->store();
        break;

    case 'user_update':
        $controller = new UserController();
        $controller->update();
        break;

    case 'user_delete':
        $controller = new UserController();
        $controller->delete();
        break;

    // User Types
    case 'user_types':
        $controller = new UserTypeController();
        $controller->index();
        break;

    case 'user_type_store':
        $controller = new UserTypeController();
        $controller->store();
        break;

    case 'user_type_update':
        $controller = new UserTypeController();
        $controller->update();
        break;

    case 'user_type_delete':
        $controller = new UserTypeController();
        $controller->delete();
        break;

    // User Type Menu
    case 'usertype_menu':
        $controller = new UserTypeMenuController();
        $controller->index();
        break;

    case 'usertype_menu_store':
        $controller = new UserTypeMenuController();
        $controller->store();
        break;

    case 'usertype_menu_update':
        $controller = new UserTypeMenuController();
        $controller->update();
        break;

    case 'usertype_menu_delete':
        $controller = new UserTypeMenuController();
        $controller->delete();
        break;

    case 'print_invoice':
        require_once '../app/models/Order.php';
        require_once '../app/models/orderDetail.php';
        $db      = new mysqli("localhost", "root", "", "food_ordering_system");
        $oid     = intval($_GET['order_id'] ?? 0);
        $res     = $db->query("SELECT o.*, u.name as user_name FROM orders o LEFT JOIN users u ON o.user_id = u.id WHERE o.id='$oid'");
        $order   = $res ? $res->fetch_assoc() : [];
        $res2    = $db->query("SELECT od.*, p.name as product_name FROM order_details od LEFT JOIN products p ON od.product_id = p.id WHERE od.order_id='$oid'");
        $details = $res2 ? $res2->fetch_all(MYSQLI_ASSOC) : [];
        include '../app/views/invoice.php';
        break;

    case 'my_orders':
        require_once '../app/models/Order.php';
        $db   = new mysqli("localhost", "root", "", "food_ordering_system");
        $uid  = $_SESSION['user_id'];
        $res  = $db->query("SELECT * FROM orders WHERE user_id='$uid'");
        $my_orders = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
        include '../app/views/customer/my_orders.php';
        break;

    default:
        echo "Page Not Found";
}
