<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';
$whatsapp = preg_replace('/\D+/', '', (string)$config['whatsapp_number']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Herbella — Botanical Luxury Hair Oil</title>
  <meta name="description" content="Discover Herbella by Herbal Crown, a botanical luxury hair oil ritual blending 20+ herbs. Cash on Delivery across Pakistan.">
  <meta property="og:title" content="Herbella — Botanical Luxury Hair Oil">
  <meta property="og:description" content="Naturally stronger. Beautifully crowned.">
  <meta property="og:image" content="<?= e(rtrim($config['site_url'], '/')) ?>/assets/images/og.png">
  <link rel="canonical" href="<?= e(rtrim($config['site_url'], '/')) ?>/">
  <link rel="icon" href="assets/images/crown-mark.svg">
  <link rel="preload" as="image" href="assets/images/herbella-hero-bottle.webp?v=20260812" type="image/webp">
  <link rel="stylesheet" href="assets/css/site.min.css?v=20260813-2">
</head>
<body>
<header class="nav-wrap">
  <a class="brand" href="#top" aria-label="Herbal Crown home"><img class="crown-mark" src="assets/images/crown-mark.svg" alt=""><span>HERBAL CROWN</span></a>
  <nav aria-label="Main navigation"><a href="#formula">Formula</a><a href="#benefits">Benefits</a><a href="#bundles">Shop</a><a href="#reviews">Reviews</a><a href="#faq">FAQs</a></nav>
  <a class="nav-cta" href="#bundles">Shop Herbella <span>↗</span></a>
</header>

<main>
  <section class="hero" id="top">
    <div class="hero-glow"></div>
    <div class="hero-copy">
      <p class="eyebrow"><span></span> THE ESSENCE OF BOTANICAL LUXURY</p>
      <h1>Naturally stronger.<br>Beautifully <em>crowned.</em></h1>
      <p class="lead">A potent hair oil ritual blending 20+ herbs to nourish the scalp, support stronger-looking hair and restore your natural radiance.</p>
      <div class="hero-actions"><a class="button gold" href="#bundles">Shop Herbella <span>→</span></a><a class="text-link" href="#formula">Discover the formula <span>↓</span></a></div>
      <div class="hero-notes"><span>✦ 100% HERBAL FORMULA</span><span>✦ FOR ALL HAIR TYPES</span><span>✦ 100 ML</span></div>
    </div>
    <div class="hero-product">
      <div class="orbit orbit-one"></div><div class="orbit orbit-two"></div>
      <div class="bottle-frame"><img src="assets/images/herbella-hero-bottle.webp?v=20260812" alt="Herbella botanical luxury hair oil bottle" width="1200" height="1600"></div>
      <span class="float-label one">20+<small>HERBS</small></span><span class="float-label two">100%<small>HERBAL</small></span>
    </div>
  </section>

  <section class="marquee" aria-label="Product highlights"><div>HERBAL WISDOM <b>✦</b> MODERN RITUAL <b>✦</b> ROOT-TO-TIP CARE <b>✦</b> BOTANICAL LUXURY <b>✦</b> HERBAL WISDOM</div></section>

  <section class="formula section" id="formula">
    <div class="section-head"><p class="eyebrow dark"><span></span> WHAT'S INSIDE</p><span class="index">01 / THE FORMULA</span></div>
    <div class="formula-grid">
      <div><h2>Ancient botanicals.<br><em>Modern alchemy.</em></h2>
        <p class="body-copy">Herbella brings together a purposeful combination of over twenty herbs. Each drop honours generations of botanical hair care—refined for your modern ritual.</p>
        <a class="text-link dark-link" href="#benefits">Explore the benefits <span>→</span></a>
      </div>
      <div class="ingredient-visual"><div class="sun-disc"></div><img src="assets/images/herbella-label.webp?v=20260812" loading="lazy" alt="Herbella herbal formula label"><span class="ingredient-tag tag-a">NOURISH</span><span class="ingredient-tag tag-b">STRENGTHEN</span><span class="ingredient-tag tag-c">RESTORE</span></div>
    </div>
    <div class="feature-list">
      <article><span>01</span><h3>20+ Botanical Oils</h3><p>A considered blend of traditional herbs and nutrient-rich oils, selected to care for scalp and strand.</p></article>
      <article><span>02</span><h3>Root-First Ritual</h3><p>A massage-friendly texture created to nourish the scalp without turning your self-care routine into a chore.</p></article>
      <article><span>03</span><h3>All Hair Types</h3><p>A versatile formula for straight, wavy, curly and coily hair—made for every crown.</p></article>
    </div>
  </section>

  <section class="benefits section" id="benefits">
    <div class="section-head"><p class="eyebrow"><span></span> THE HERBELLA EFFECT</p><span class="index">02 / BENEFITS</span></div>
    <div class="benefit-title"><h2>Your crown,<br><em>beautifully cared for.</em></h2><p>One golden ritual. A world of care for the hair you live in.</p></div>
    <div class="benefit-grid">
      <article><b>01</b><div class="line-icon">↗</div><h3>Supports Stronger-Looking Hair</h3><p>Nourishing oils help reduce the appearance of breakage and keep every strand feeling resilient.</p></article>
      <article><b>02</b><div class="line-icon">◉</div><h3>Nourishes the Scalp</h3><p>Massage in from root to tip to comfort dry-feeling scalps and build the foundation for healthy-looking hair.</p></article>
      <article><b>03</b><div class="line-icon">✦</div><h3>Softness & Natural Shine</h3><p>Helps smooth the look of frizz and leaves hair feeling softer, more manageable, and beautifully luminous.</p></article>
    </div>
  </section>

  <section class="stats"><div><strong>20<sup>+</sup></strong><span>BOTANICAL INGREDIENTS</span></div><div><strong>100<sup>%</sup></strong><span>HERBAL FORMULA</span></div><div><strong>3×</strong><span>A WEEK RITUAL</span></div><div><strong>1</strong><span>BEAUTIFUL CROWN</span></div></section>

  <section class="bundles section" id="bundles">
    <div class="section-head"><p class="eyebrow dark"><span></span> CHOOSE YOUR RITUAL</p><span class="index">03 / SHOP</span></div>
    <div class="center-title"><h2>Find your perfect <em>ritual.</em></h2><p>More consistency. More care. More value.</p></div>
    <div class="bundle-grid">
      <article><div class="badge">START HERE</div><div class="mini-products"><img src="assets/images/herbella-bottle.webp?v=20260812" loading="lazy" alt=""></div><h3>The Ritual</h3><p>A first taste of Herbella</p><div class="price">Rs 800</div><a class="button outline-button" href="checkout.php?bundle=ritual">Choose single <span>→</span></a></article>
      <article class="featured"><div class="badge">MOST LOVED</div><div class="mini-products"><img src="assets/images/herbella-bottle.webp?v=20260812" loading="lazy" alt=""><img src="assets/images/herbella-bottle.webp?v=20260812" loading="lazy" alt=""></div><h3>The Duo</h3><p>Share one. Keep one.</p><div class="price">Rs 1,500</div><a class="button dark-button" href="checkout.php?bundle=duo">Choose duo <span>→</span></a></article>
      <article><div class="badge">BEST VALUE</div><div class="mini-products"><img src="assets/images/herbella-bottle.webp?v=20260812" loading="lazy" alt=""><img src="assets/images/herbella-bottle.webp?v=20260812" loading="lazy" alt=""><img src="assets/images/herbella-bottle.webp?v=20260812" loading="lazy" alt=""></div><h3>The Crown Set</h3><p>Your complete 90-day ritual</p><div class="price">Rs 2,200</div><a class="button outline-button" href="checkout.php?bundle=crown">Choose set <span>→</span></a></article>
    </div>
    <p class="shipping-note">✦ RS 300 DELIVERY ACROSS PAKISTAN</p>
  </section>

  <section class="reviews section" id="reviews">
    <div class="section-head"><p class="eyebrow"><span></span> WORDS FROM OUR COMMUNITY</p><span class="index">04 / REVIEWS</span></div>
    <div class="review-intro"><h2>Loved by <em>every crown.</em></h2><div><span class="stars">★★★★★</span><strong>4.9</strong><small>CUSTOMER EXPERIENCES</small></div></div>
    <div class="testimonial-grid">
      <blockquote><span class="quote-mark">“</span><p>My wash-day routine finally feels like a ritual. Herbella is rich, beautiful, and my scalp feels wonderfully cared for.</p><footer><span class="avatar">A</span><span><strong>Amina R.</strong><small>VERIFIED CUSTOMER</small></span></footer></blockquote>
      <blockquote><span class="quote-mark">“</span><p>The texture feels luxurious without being heavy. Even the bottle has become part of my bathroom décor.</p><footer><span class="avatar">K</span><span><strong>Komal M.</strong><small>VERIFIED CUSTOMER</small></span></footer></blockquote>
      <blockquote><span class="quote-mark">“</span><p>I bought the duo for my sister and me. We both love the herbal scent and how soft our hair feels after wash day.</p><footer><span class="avatar">S</span><span><strong>Sara K.</strong><small>VERIFIED CUSTOMER</small></span></footer></blockquote>
    </div>
  </section>

  <section class="faq section" id="faq">
    <div class="section-head"><p class="eyebrow dark"><span></span> COMMON QUESTIONS</p><span class="index">05 / FAQ</span></div>
    <div class="faq-grid"><div><h2>Everything your<br><em>ritual needs.</em></h2></div><div>
      <details open><summary>How do I use Herbella?</summary><p>Massage a small amount into the scalp and through the lengths. Leave it in as part of your preferred pre-wash routine, then shampoo thoroughly.</p></details>
      <details><summary>How often should I apply it?</summary><p>Use it according to your hair and scalp preference. Many customers include oiling two to three times weekly in their routine.</p></details>
      <details><summary>Is it suitable for all hair types?</summary><p>Herbella is designed for straight, wavy, curly and coily hair. Patch test first and discontinue use if irritation occurs.</p></details>
      <details><summary>How does Cash on Delivery work?</summary><p>Place your order online and our team will contact you to confirm it. Pay the courier when your parcel arrives.</p></details>
    </div></div>
  </section>

  <section class="contact section" id="contact">
    <div class="contact-copy"><p class="eyebrow dark"><span></span> LET'S TALK</p><h2>Your ritual<br>starts <em>here.</em></h2><p>Questions about Herbella or your order? Our care team would love to help.</p>
      <a class="button dark-button contact-action" href="https://wa.me/<?= e($whatsapp) ?>" target="_blank" rel="noopener">Chat on WhatsApp <span>↗</span></a>
    </div>
    <div class="contact-card"><span>ORDER SUPPORT</span><h3>herbalcrownhairoil@gmail.com</h3><p>For order assistance, include your order number and mobile number.</p><a href="mailto:herbalcrownhairoil@gmail.com">Send an email →</a></div>
  </section>
</main>

<a class="whatsapp-float" href="https://wa.me/<?= e($whatsapp) ?>" target="_blank" rel="noopener" aria-label="Chat with Herbal Crown on WhatsApp">WA</a>
<a class="mobile-buy" href="#bundles">Choose your Herbella ritual <span>→</span></a>

<footer class="footer"><div class="footer-top"><div class="footer-brand"><img class="crown-mark" src="assets/images/crown-mark.svg" alt=""><span>HERBAL CROWN</span><p>THE ESSENCE OF BOTANICAL LUXURY</p></div>
<div><h4>EXPLORE</h4><a href="#formula">Formula</a><a href="#benefits">Benefits</a><a href="#bundles">Shop Herbella</a></div>
<div><h4>SUPPORT</h4><a href="#faq">FAQs</a><a href="#contact">Contact</a><a href="admin/login.php">Admin</a></div>
</div><div class="footer-word"><img src="assets/images/herbella-wordmark.svg" alt="Herbella"></div>
<div class="footer-bottom"><span>© 2026 HERBAL CROWN</span><span>BOTANICAL LUXURY, BOTTLED.</span><a href="#top">BACK TO TOP ↑</a></div></footer>
</body></html>
