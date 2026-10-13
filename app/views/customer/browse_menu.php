<?php include __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../../models/ProductAttribute.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Browse Menu</h1>
        <button class="btn btn-primary" onclick="openModal('modal-cart')">
            🛒 View Cart (<span id="cart-count">0</span>)
        </button>
    </div>

    <?php
    $by_menu = [];

    foreach($products as $p) {
        $by_menu[$p['menu_id']]['menu_name'] = $p['menu_name'];
        $by_menu[$p['menu_id']]['items'][] = $p;
    }
    ?>

    <?php foreach($by_menu as $menu_id => $group): ?>
    <div class="card" style="margin-bottom:20px">

        <h2 style="font-size:1.15rem;color:#e74c3c;margin-bottom:16px;border-bottom:2px solid #fde;padding-bottom:10px">
            🍴 <?= htmlspecialchars($group['menu_name']) ?>
        </h2>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px">

            <?php foreach($group['items'] as $item): ?>
            <div style="border:1px solid #eee;border-radius:8px;padding:16px;background:#fafafa">

                <div style="font-weight:700;font-size:1rem;margin-bottom:6px">
                    <?= htmlspecialchars($item['name']) ?>
                </div>

                <div style="color:#e74c3c;font-size:1.1rem;font-weight:700;margin-bottom:12px">
                    $<?= number_format($item['price'],2) ?>
                </div>

                <!-- EAV Attributes -->.
                <?php
                $attrs = (new ProductAttribute())->readByProduct($item['id']);
                ?>

                <?php foreach($attrs as $attr): ?>
                    <div style="font-size:12px;color:#666;margin-bottom:2px">
                        <strong><?= htmlspecialchars($attr['attribute_name']) ?>:</strong>
                        <?= htmlspecialchars($attr['value']) ?>
                    </div>
                <?php endforeach; ?>

                <br>

                <div style="display:flex;align-items:center;gap:8px">

                    <button
                        onclick="changeQty(<?= $item['id'] ?>, -1)"
                        class="btn btn-sm btn-secondary"
                        style="padding:2px 10px;font-size:1rem">
                        −
                    </button>

                    <input
                        type="number"
                        id="qty-<?= $item['id'] ?>"
                        value="0"
                        min="0"
                        max="99"
                        style="width:50px;text-align:center;border:1px solid #ddd;border-radius:4px;padding:4px"
                        onchange="updateCart(
                            <?= $item['id'] ?>,
                            '<?= addslashes($item['name']) ?>',
                            <?= $item['price'] ?>
                        )">

                    <button
                        onclick="changeQty(<?= $item['id'] ?>, 1)"
                        class="btn btn-sm btn-primary"
                        style="padding:2px 10px;font-size:1rem">
                        +
                    </button>

                </div>

            </div>
            <?php endforeach; ?>

        </div>

    </div>
    <?php endforeach; ?>

    <?php if(empty($products)): ?>
        <div class="card" style="text-align:center;color:#999;padding:40px">
            No products available yet.
        </div>
    <?php endif; ?>

</div>

<!-- Cart Modal -->
<div class="modal-overlay" id="modal-cart">
    <div class="modal" style="width:560px">

        <span class="modal-close" onclick="closeModal('modal-cart')">
            &times;
        </span>

        <h2>Your Cart</h2>

        <div id="cart-items"
             style="margin-bottom:20px;max-height:300px;overflow-y:auto">
        </div>

        <div style="border-top:2px solid #eee;padding-top:14px;display:flex;justify-content:space-between;align-items:center;font-size:1.1rem;font-weight:700;margin-bottom:20px">
            <span>Total:</span>
            <span style="color:#e74c3c">
                $<span id="cart-total">0.00</span>
            </span>
        </div>

        <form method="POST"
              action="index.php?action=place_order"
              id="order-form">

            <div id="cart-inputs"></div>

            <!-- Payment Method -->
            <div style="margin-bottom:15px;">
                <label style="display:block;margin-bottom:5px;">
                    <strong>Payment Method</strong>
                </label>

                <select
                    name="payment_method"
                    style="width:100%;padding:10px;border:1px solid #ddd;border-radius:5px;">

                    <option value="cash">Cash</option>
                    <option value="card">Credit Card</option>
                    <option value="wallet">Wallet</option>

                </select>
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end">

                <button
                    type="button"
                    class="btn btn-secondary"
                    onclick="closeModal('modal-cart')">
                    Continue Shopping
                </button>

                <button
                    type="submit"
                    class="btn btn-success"
                    id="checkout-btn"
                    disabled>
                    Place Order
                </button>

            </div>

        </form>

    </div>
</div>

<script>
var cart = {};

function changeQty(id, delta)
{
    var input = document.getElementById('qty-' + id);

    var val = parseInt(input.value) + delta;

    if (val < 0)
        val = 0;

    input.value = val;

    input.dispatchEvent(new Event('change'));
}

function updateCart(id, name, price)
{
    var qty = parseInt(
        document.getElementById('qty-' + id).value
    ) || 0;

    if (qty > 0)
    {
        cart[id] = {
            name: name,
            price: price,
            qty: qty
        };
    }
    else
    {
        delete cart[id];
    }

    renderCart();
}

function renderCart()
{
    var total = 0;
    var count = 0;
    var html = '';
    var inputs = '';

    if (Object.keys(cart).length === 0)
    {
        html =
        '<p style="text-align:center;color:#999;padding:20px">Your cart is empty.</p>';
    }
    else
    {
        html =
        '<table style="width:100%;font-size:0.9rem">' +
        '<tr><th style="text-align:left;padding:6px">Item</th><th>Qty</th><th>Price</th></tr>';

        for (var id in cart)
        {
            var item = cart[id];
            var sub = item.price * item.qty;

            total += sub;
            count += item.qty;

            html +=
                '<tr>' +
                '<td style="padding:6px">' + item.name + '</td>' +
                '<td style="text-align:center">' + item.qty + '</td>' +
                '<td style="text-align:right">$' + sub.toFixed(2) + '</td>' +
                '</tr>';

            inputs +=
                '<input type="hidden" name="cart[' +
                id +
                ']" value="' +
                item.qty +
                '">';
        }

        html += '</table>';
    }

    document.getElementById('cart-items').innerHTML = html;
    document.getElementById('cart-inputs').innerHTML = inputs;
    document.getElementById('cart-total').textContent = total.toFixed(2);
    document.getElementById('cart-count').textContent = count;
    document.getElementById('checkout-btn').disabled =
        (Object.keys(cart).length === 0);
}

renderCart();
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>