<?php
// app/views/partials/header.php
// Usage: include this at top of every page. Set $page_title and $active_nav before including.
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "?action=login");
    exit;
}
$user_type = $_SESSION['user_type_id'] ?? 0;
$is_admin   = ($user_type == 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Food Ordering System') ?></title>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/style.css">
</head>
<body>
<div class="navbar">
    <span class="brand">🍽️ FoodOrder</span>
    <nav>
        <?php if ($is_admin): ?>
            <a href="<?= BASE_URL ?>?action=admin_dashboard" class="<?= ($active_nav=='dashboard'?'active':'') ?>">Dashboard</a>
            <a href="<?= BASE_URL ?>?action=users"       class="<?= ($active_nav=='users'?'active':'') ?>">Users</a>
            <a href="<?= BASE_URL ?>?action=user_types"  class="<?= ($active_nav=='user_types'?'active':'') ?>">User Types</a>
            <a href="<?= BASE_URL ?>?action=menu"        class="<?= ($active_nav=='menu'?'active':'') ?>">Menus</a>
            <a href="<?= BASE_URL ?>?action=products"    class="<?= ($active_nav=='products'?'active':'') ?>">Products</a>
            <a href="<?= BASE_URL ?>?action=orders"      class="<?= ($active_nav=='orders'?'active':'') ?>">Orders</a>
            <a href="<?= BASE_URL ?>?action=order_details" class="<?= ($active_nav=='order_details'?'active':'') ?>">Order Details</a>
            <a href="<?= BASE_URL ?>?action=usertype_menu" class="<?= ($active_nav=='usertype_menu'?'active':'') ?>">Role-Menu Map</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>?action=customer_dashboard" class="<?= ($active_nav=='dashboard'?'active':'') ?>">Home</a>
            <a href="<?= BASE_URL ?>?action=browse_menu"        class="<?= ($active_nav=='browse'?'active':'') ?>">Browse Menu</a>
            <a href="<?= BASE_URL ?>?action=my_orders"          class="<?= ($active_nav=='my_orders'?'active':'') ?>">My Orders</a>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>?action=logout" style="background:rgba(255,255,255,0.15)">Logout</a>
    </nav>
</div>
