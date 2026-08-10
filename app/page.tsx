const features = [
  {
    no: "01",
    title: "20+ Botanical Oils",
    copy: "A considered blend of traditional herbs and nutrient-rich oils, selected to care for scalp and strand.",
  },
  {
    no: "02",
    title: "Root-First Ritual",
    copy: "A massage-friendly texture created to nourish the scalp without turning your self-care routine into a chore.",
  },
  {
    no: "03",
    title: "All Hair Types",
    copy: "A versatile formula for straight, wavy, curly and coily hair—made for every crown.",
  },
];

const bundles = [
  {
    qty: "1",
    name: "The Ritual",
    sub: "A first taste of Herbella",
    price: "Rs 650",
    old: "",
    badge: "START HERE",
  },
  {
    qty: "2",
    name: "The Duo",
    sub: "Share one. Keep one.",
    price: "Rs 1,100",
    old: "",
    badge: "MOST LOVED",
    featured: true,
  },
  {
    qty: "3",
    name: "The Crown Set",
    sub: "Your complete 90-day ritual",
    price: "Rs 1,650",
    old: "",
    badge: "BEST VALUE",
  },
];

const testimonials = [
  {
    quote:
      "My wash-day routine finally feels like a ritual. Herbella is rich, beautiful, and my scalp feels wonderfully cared for.",
    name: "Amina R.",
    detail: "VERIFIED CUSTOMER",
  },
  {
    quote:
      "The texture feels luxurious without being heavy. Even the bottle has become part of my bathroom décor.",
    name: "Layla M.",
    detail: "VERIFIED CUSTOMER",
  },
  {
    quote:
      "I bought the duo for my sister and me. We both love the herbal scent and how soft our hair feels after wash day.",
    name: "Sara K.",
    detail: "VERIFIED CUSTOMER",
  },
];

function CrownMark() {
  return <img className="crown-mark" src="/assets/crown-mark.svg" alt="" />;
}

export default function Home() {
  return (
    <main>
      <header className="nav-wrap">
        <a className="brand" href="#top" aria-label="Herbal Crown home">
          <CrownMark />
          <span>HERBAL CROWN</span>
        </a>
        <nav aria-label="Main navigation">
          <a href="#formula">The formula</a>
          <a href="#benefits">Benefits</a>
          <a href="#bundles">Shop</a>
          <a href="#reviews">Reviews</a>
        </nav>
        <a className="nav-cta" href="#bundles">
          Shop Herbella <span>↗</span>
        </a>
      </header>

      <section className="hero" id="top">
        <div className="hero-glow" />
        <div className="hero-copy">
          <p className="eyebrow">
            <span /> THE ESSENCE OF BOTANICAL LUXURY
          </p>
          <h1>
            Rooted in nature.
            <br />
            <em>Crowned</em> in confidence.
          </h1>
          <p className="lead">
            A potent hair oil ritual blending 20+ herbs to nourish the scalp,
            support stronger-looking hair and restore your natural radiance.
          </p>
          <div className="hero-actions">
            <a className="button gold" href="#bundles">
              Shop Herbella <span>→</span>
            </a>
            <a className="text-link" href="#formula">
              Discover the formula <span>↓</span>
            </a>
          </div>
          <div className="hero-notes">
            <span>✦ 100% HERBAL FORMULA</span>
            <span>✦ FOR ALL HAIR TYPES</span>
            <span>✦ 100 ML</span>
          </div>
        </div>
        <div className="hero-product">
          <div className="orbit orbit-one" />
          <div className="orbit orbit-two" />
          <div className="bottle-frame">
            <img
              src="/assets/herbella-hero-bottle.png"
              alt="Herbella botanical luxury hair oil bottle"
            />
          </div>
          <span className="float-label one">
            20+<small>HERBS</small>
          </span>
          <span className="float-label two">
            100%<small>HERBAL</small>
          </span>
        </div>
        <div className="scroll-cue">
          SCROLL TO DISCOVER <span>↓</span>
        </div>
      </section>

      <section className="marquee" aria-label="Product highlights">
        <div>
          HERBAL WISDOM <b>✦</b> MODERN RITUAL <b>✦</b> ROOT-TO-TIP CARE{" "}
          <b>✦</b> BOTANICAL LUXURY <b>✦</b> HERBAL WISDOM
        </div>
      </section>

      <section className="formula section" id="formula">
        <div className="section-head">
          <p className="eyebrow dark">
            <span /> WHAT'S INSIDE
          </p>
          <span className="index">01 / THE FORMULA</span>
        </div>
        <div className="formula-grid">
          <div>
            <h2>
              Ancient botanicals.
              <br />
              <em>Modern alchemy.</em>
            </h2>
            <p className="body-copy">
              Herbella brings together a purposeful combination of over twenty
              herbs. Each drop honours generations of botanical hair
              care—refined for your modern ritual.
            </p>
            <a className="text-link dark-link" href="#benefits">
              Explore the benefits <span>→</span>
            </a>
          </div>
          <div className="ingredient-visual">
            <div className="sun-disc" />
            <img
              src="/assets/herbella-label.png"
              alt="Herbella hair oil label featuring its herbal formula"
            />
            <span className="ingredient-tag tag-a">NOURISH</span>
            <span className="ingredient-tag tag-b">STRENGTHEN</span>
            <span className="ingredient-tag tag-c">RESTORE</span>
          </div>
        </div>
        <div className="feature-list">
          {features.map((f) => (
            <article key={f.no}>
              <span>{f.no}</span>
              <h3>{f.title}</h3>
              <p>{f.copy}</p>
            </article>
          ))}
        </div>
      </section>

      <section className="benefits section" id="benefits">
        <div className="section-head">
          <p className="eyebrow">
            <span /> THE HERBELLA EFFECT
          </p>
          <span className="index">02 / BENEFITS</span>
        </div>
        <div className="benefit-title">
          <h2>
            Your crown,
            <br />
            <em>beautifully cared for.</em>
          </h2>
          <p>One golden ritual. A world of care for the hair you live in.</p>
        </div>
        <div className="benefit-grid">
          <article>
            <b>01</b>
            <div className="line-icon">↗</div>
            <h3>Supports Stronger-Looking Hair</h3>
            <p>
              Nourishing oils help reduce the appearance of breakage and keep
              every strand feeling resilient.
            </p>
          </article>
          <article>
            <b>02</b>
            <div className="line-icon">◎</div>
            <h3>Nourishes the Scalp</h3>
            <p>
              Massage in from root to tip to comfort dry-feeling scalps and
              build the foundation for healthy-looking hair.
            </p>
          </article>
          <article>
            <b>03</b>
            <div className="line-icon">✦</div>
            <h3>Softness & Natural Shine</h3>
            <p>
              Helps smooth the look of frizz and leaves hair feeling softer,
              more manageable, and beautifully luminous.
            </p>
          </article>
        </div>
      </section>

      <section className="stats" aria-label="Product statistics">
        <div>
          <strong>
            20<sup>+</sup>
          </strong>
          <span>BOTANICAL INGREDIENTS</span>
        </div>
        <div>
          <strong>
            100<sup>%</sup>
          </strong>
          <span>HERBAL FORMULA</span>
        </div>
        <div>
          <strong>3×</strong>
          <span>A WEEK RITUAL</span>
        </div>
        <div>
          <strong>1</strong>
          <span>BEAUTIFUL CROWN</span>
        </div>
      </section>

      <section className="bundles section" id="bundles">
        <div className="section-head">
          <p className="eyebrow dark">
            <span /> CHOOSE YOUR RITUAL
          </p>
          <span className="index">03 / SHOP</span>
        </div>
        <div className="center-title">
          <h2>
            Find your perfect <em>ritual.</em>
          </h2>
          <p>More consistency. More care. More value.</p>
        </div>
        <div className="bundle-grid">
          {bundles.map((b) => (
            <article className={b.featured ? "featured" : ""} key={b.name}>
              <div className="badge">{b.badge}</div>
              <div className="mini-products">
                {Array.from({ length: Number(b.qty) }).map((_, i) => (
                  <img key={i} src="/assets/herbella-bottle.png" alt="" />
                ))}
              </div>
              <h3>{b.name}</h3>
              <p>{b.sub}</p>
              <div className="price">
                {b.price} <del>{b.old}</del>
              </div>
              <a
                className={
                  b.featured ? "button dark-button" : "button outline-button"
                }
                href={`/product?bundle=${b.qty === "1" ? "ritual" : b.qty === "2" ? "duo" : "crown"}`}
              >
                Choose{" "}
                {b.qty === "1" ? "single" : b.qty === "2" ? "duo" : "set"}{" "}
                <span>→</span>
              </a>
            </article>
          ))}
        </div>
        <p className="shipping-note">
          ✦ COMPLIMENTARY SHIPPING ON THE CROWN SET
        </p>
      </section>

      <section className="reviews section" id="reviews">
        <div className="section-head">
          <p className="eyebrow">
            <span /> WORDS FROM OUR COMMUNITY
          </p>
          <span className="index">04 / REVIEWS</span>
        </div>
        <div className="review-intro">
          <h2>
            Loved by <em>every crown.</em>
          </h2>
          <div>
            <span className="stars">★★★★★</span>
            <strong>4.9</strong>
            <small>BASED ON 200+ RITUALS</small>
          </div>
        </div>
        <div className="testimonial-grid">
          {testimonials.map((t, i) => (
            <blockquote key={t.name}>
              <span className="quote-mark">“</span>
              <p>{t.quote}</p>
              <footer>
                <span className="avatar">{t.name[0]}</span>
                <span>
                  <strong>{t.name}</strong>
                  <small>{t.detail}</small>
                </span>
                <b>0{i + 1}</b>
              </footer>
            </blockquote>
          ))}
        </div>
      </section>

      <section className="contact section" id="contact">
        <div className="contact-copy">
          <p className="eyebrow dark">
            <span /> LET'S TALK
          </p>
          <h2>
            Your ritual
            <br />
            starts <em>here.</em>
          </h2>
          <p>
            Questions about Herbella, your order, or finding the right ritual?
            Our care team would love to help.
          </p>
          <a className="button dark-button" href="mailto:hello@herbalcrown.com">
            hello@herbalcrown.com <span>↗</span>
          </a>
        </div>
        <form
          className="contact-form"
          action="mailto:hello@herbalcrown.com"
          method="post"
          encType="text/plain"
        >
          <label>
            Name
            <input name="name" placeholder="Your name" required />
          </label>
          <label>
            Email
            <input
              name="email"
              type="email"
              placeholder="you@example.com"
              required
            />
          </label>
          <label>
            Message
            <textarea
              name="message"
              placeholder="How can we help?"
              rows={4}
              required
            />
          </label>
          <button className="button gold" type="submit">
            Send message <span>→</span>
          </button>
        </form>
      </section>

      <footer className="footer">
        <div className="footer-top">
          <div className="footer-brand">
            <CrownMark />
            <span>HERBAL CROWN</span>
            <p>THE ESSENCE OF BOTANICAL LUXURY</p>
          </div>
          <div>
            <h4>EXPLORE</h4>
            <a href="#formula">The formula</a>
            <a href="#benefits">Benefits</a>
            <a href="#bundles">Shop Herbella</a>
          </div>
          <div>
            <h4>CONNECT</h4>
            <a href="mailto:hello@herbalcrown.com">Email us</a>
            <a href="#top">Instagram</a>
            <a href="#top">TikTok</a>
          </div>
          <div className="newsletter">
            <h4>JOIN THE INNER CIRCLE</h4>
            <p>Ritual notes, botanical wisdom, and first access.</p>
            <form action="mailto:hello@herbalcrown.com">
              <input
                type="email"
                aria-label="Email address"
                placeholder="YOUR EMAIL ADDRESS"
              />
              <button aria-label="Subscribe">→</button>
            </form>
          </div>
        </div>
        <div className="footer-word">
          <img src="/assets/herbella-wordmark.svg" alt="Herbella" />
        </div>
        <div className="footer-bottom">
          <span>© 2026 HERBAL CROWN</span>
          <span>BOTANICAL LUXURY, BOTTLED.</span>
          <a href="#top">BACK TO TOP ↑</a>
        </div>
      </footer>
    </main>
  );
}
