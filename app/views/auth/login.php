<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Login – Food Ordering System</title>
    <link rel="stylesheet" href="/FinalSoftware/assets/css/style.css">
</head>
<body>
<div class="login-wrap">
    <div class="login-box">
        <div class="logo">
            <h1>🍽️ FoodOrder</h1>
            <p>Sign in to your account</p>
        </div>
        <?php if (!empty($_GET['error'])): ?>
            <div class="alert alert-danger">Invalid email or password. Please try again.</div>
        <?php endif; ?>
        <form method="POST" action="index.php?action=login_post">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required placeholder="you@example.com" autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;padding:11px;font-size:1rem;margin-top:8px">
                Sign In
            </button>
        </form>
        <div style="margin-top:20px;padding:12px;background:#f8f9fa;border-radius:6px;font-size:0.82rem;color:#555">
            <strong>Demo Accounts:</strong><br>
            Admin: <code>admin@food.com</code> / <code>admin123</code><br>
            Customer: <code>ahmed@food.com</code> / <code>cust123</code>
        </div>
    </div>
</div>
</body>
</html>
