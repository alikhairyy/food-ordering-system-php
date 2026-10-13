# Food Ordering System (PHP MVC)

A role-based food ordering web app built for **Fundamentals of Software Engineering (DPRG406)** as a team project. It is written in plain PHP using **MVC** and the **Strategy design pattern** for payments.

## Features
- Login with **role-based access control** (admin, customer) and menus generated per user type
- CRUD for users, user types, products, menus, orders and order details
- Customer flow: browse menu → place order → view my orders → **invoice**
- **Pluggable payments** through the Strategy pattern: `CardPayment`, `CashPayment` and `WalletPayment` behind a shared `PaymentStrategy` interface, selected at runtime by `PaymentContext`
- `CrudInterface` to keep controllers consistent
- Passwords hashed with bcrypt, and PDO for database access

## Structure
```
app/
  controllers/   models/   views/
  Strategies/    # PaymentStrategy, PaymentContext, Card/Cash/Wallet
  interfaces/    config/
public/          # entry point (index.php)
routes/web.php
database.sql
SRS_Documentation.pdf
```

## Run it locally (XAMPP)
1. Copy the folder to `htdocs/` and import `database.sql` in phpMyAdmin.
2. Visit `public/setup.php` **once** to set the demo passwords, then delete it.
3. Open `http://localhost/food-ordering-system-php/public/`.

Full requirements and UML: [`SRS_Documentation.pdf`](SRS_Documentation.pdf)

**Stack:** PHP 8 · MySQL · PDO · MVC · Strategy pattern
