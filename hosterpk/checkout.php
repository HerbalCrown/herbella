<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$allPackages = packages();
$selectedKey = (string)($_GET['bundle'] ?? 'ritual');
if (!isset($allPackages[$selectedKey])) {
    $selectedKey = 'ritual';
}
$shipping = (int)$config['shipping_fee'];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Checkout — Herbella by Herbal Crown</title>
  <meta name="robots" content="noindex">
  <link rel="icon" href="assets/images/crown-mark.svg">
  <link rel="stylesheet" href="assets/css/checkout.min.css">
</head>
<body class="checkout-page">
<header class="checkout-nav">
  <a href="index.php" class="checkout-brand"><img src="assets/images/crown-mark.svg" alt=""><span>HERBAL CROWN</span></a>
  <a href="index.php#bundles">&larr; Continue shopping</a>
</header>
<main class="product-shell" data-shipping="<?= $shipping ?>">
  <section class="product-showcase">
    <p class="checkout-kicker">BOTANICAL LUXURY HAIR OIL</p>
    <div class="checkout-image">
      <img src="assets/images/herbella-bottle.webp" alt="Herbella botanical hair oil">
      <span id="unit-label"><?= (int)$allPackages[$selectedKey]['units'] ?> &times; 100 ml</span>
    </div>
    <h1 id="package-name"><?= e($allPackages[$selectedKey]['name']) ?></h1>
    <p id="package-copy"><?= e($allPackages[$selectedKey]['copy']) ?></p>
    <div class="package-tabs" aria-label="Choose a package">
      <?php foreach ($allPackages as $key => $package): ?>
        <button type="button" data-package="<?= e($key) ?>" data-price="<?= (int)$package['price'] ?>" data-units="<?= (int)$package['units'] ?>" data-name="<?= e($package['name']) ?>" data-copy="<?= e($package['copy']) ?>" class="<?= $key === $selectedKey ? 'active' : '' ?>">
          <span><?= (int)$package['units'] ?> bottle<?= $package['units'] > 1 ? 's' : '' ?></span>
          <strong><?= money((int)$package['price']) ?></strong>
        </button>
      <?php endforeach; ?>
    </div>
  </section>

  <form class="checkout-form" method="post" action="process-order.php" novalidate>
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="bundle" id="bundle" value="<?= e($selectedKey) ?>">
    <label class="website-field" aria-hidden="true">Website<input name="website" tabindex="-1" autocomplete="off"></label>

    <div class="checkout-heading">
      <p class="checkout-kicker">SECURE CHECKOUT</p>
      <h2>Complete your <em>ritual.</em></h2>
      <p>Delivery across Pakistan &middot; Pay when your order arrives.</p>
    </div>

    <?php if (!empty($_SESSION['checkout_error'])): ?>
      <p class="checkout-error" role="alert"><?= e((string)$_SESSION['checkout_error']) ?></p>
      <?php unset($_SESSION['checkout_error']); ?>
    <?php endif; ?>

    <div class="quantity-row">
      <span>Package quantity</span>
      <div>
        <button type="button" id="quantity-minus" aria-label="Decrease quantity">&minus;</button>
        <strong id="quantity-value">1</strong>
        <button type="button" id="quantity-plus" aria-label="Increase quantity">+</button>
        <input type="hidden" name="quantity" id="quantity" value="1">
      </div>
    </div>

    <fieldset>
      <legend>Delivery details</legend>
      <div class="field-grid">
        <label>Full name *<input name="customer_name" maxlength="100" required autocomplete="name"></label>
        <label>Mobile number *<input name="phone" maxlength="30" required inputmode="tel" placeholder="03XX XXXXXXX"></label>
        <label>Alternate number<input name="alternate_phone" maxlength="30" inputmode="tel"></label>
        <label>Email address<input name="email" type="email" maxlength="160" autocomplete="email"></label>
        <label>Province *<select name="province" required>
          <option value="">Select province</option>
          <option>Punjab</option><option>Sindh</option><option>Khyber Pakhtunkhwa</option>
          <option>Balochistan</option><option>Islamabad Capital Territory</option>
          <option>Gilgit-Baltistan</option><option>Azad Jammu & Kashmir</option>
        </select></label>
        <label>City *<input name="city" maxlength="100" required autocomplete="address-level2"></label>
        <label class="full">Complete delivery address *<textarea name="address" maxlength="500" rows="3" required autocomplete="street-address"></textarea></label>
        <label class="full">Landmark<input name="landmark" maxlength="180" placeholder="Nearby landmark (optional)"></label>
        <label class="full">Order notes<textarea name="notes" maxlength="500" rows="2" placeholder="Any delivery instructions?"></textarea></label>
      </div>
    </fieldset>

    <fieldset>
      <legend>Payment method</legend>
      <label class="payment-option"><span class="radio-dot"></span><span><strong>Cash on Delivery</strong><small>Pay in cash when your Herbella order arrives.</small></span><b>COD</b></label>
      <p class="future-payments">JazzCash, Easypaisa and card payments can be added later.</p>
    </fieldset>

    <div class="order-summary">
      <h3>Order summary</h3>
      <div><span id="summary-name"><?= e($allPackages[$selectedKey]['name']) ?> &times; 1</span><strong id="summary-subtotal"><?= money((int)$allPackages[$selectedKey]['price']) ?></strong></div>
      <div><span>Shipping</span><strong><?= money($shipping) ?></strong></div>
      <div class="total"><span>Total COD amount</span><strong id="summary-total"><?= money((int)$allPackages[$selectedKey]['price'] + $shipping) ?></strong></div>
    </div>
    <button class="checkout-button" type="submit">Place COD order <span>&rarr;</span></button>
    <p class="checkout-terms">By placing your order, you confirm that your delivery details are correct.</p>
  </form>
</main>
<script src="assets/js/checkout.min.js" defer></script>
</body>
</html>
