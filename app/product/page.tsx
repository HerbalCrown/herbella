"use client";

import { FormEvent, useEffect, useMemo, useState } from "react";
import "./product.css";

const packages = {
  ritual: { id: "ritual", name: "The Ritual", units: 1, price: 650, copy: "A first taste of Herbella" },
  duo: { id: "duo", name: "The Duo", units: 2, price: 1100, copy: "Share one. Keep one." },
  crown: { id: "crown", name: "The Crown Set", units: 3, price: 1650, copy: "Your complete 90-day ritual" },
} as const;

type PackageKey = keyof typeof packages;
const money = (value: number) => `Rs ${value.toLocaleString("en-PK")}`;

export default function ProductPage() {
  const [selected, setSelected] = useState<PackageKey>("ritual");
  const [quantity, setQuantity] = useState(1);
  const [submitting, setSubmitting] = useState(false);
  const [result, setResult] = useState<{ invoiceNumber: string; total: number; emailSent: boolean } | null>(null);
  const [error, setError] = useState("");

  useEffect(() => {
    const bundle = new URLSearchParams(window.location.search).get("bundle");
    if (bundle && bundle in packages) setSelected(bundle as PackageKey);
  }, []);

  const item = packages[selected];
  const subtotal = useMemo(() => item.price * quantity, [item.price, quantity]);
  const total = subtotal + 300;

  async function submitOrder(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();
    setSubmitting(true);
    setError("");
    const form = new FormData(event.currentTarget);
    const response = await fetch("/api/orders", {
      method: "POST",
      headers: { "content-type": "application/json" },
      body: JSON.stringify({
        bundle: selected,
        quantity,
        customerName: form.get("customerName"),
        email: form.get("email"),
        phone: form.get("phone"),
        address: form.get("address"),
        city: form.get("city"),
        notes: form.get("notes"),
      }),
    });
    const data = await response.json();
    setSubmitting(false);
    if (!response.ok) return setError(data.error || "Unable to place your order.");
    setResult(data);
  }

  if (result) {
    return <main className="checkout-page"><section className="success-card"><img src="/assets/crown-mark.svg" alt="" /><p className="checkout-kicker">ORDER RECEIVED</p><h1>Thank you for choosing <em>Herbella.</em></h1><p>Your Cash on Delivery order has been recorded. Our care team will contact you to confirm delivery.</p><dl><div><dt>Invoice</dt><dd>{result.invoiceNumber}</dd></div><div><dt>Order total</dt><dd>{money(result.total)}</dd></div><div><dt>Payment</dt><dd>Cash on Delivery</dd></div></dl>{!result.emailSent && <p className="email-note">Your order is safe. The email service is awaiting final setup.</p>}<a className="checkout-button" href="/">Return home <span>→</span></a></section></main>;
  }

  return (
    <main className="checkout-page">
      <header className="checkout-nav"><a href="/" className="checkout-brand"><img src="/assets/crown-mark.svg" alt="" /><span>HERBAL CROWN</span></a><a href="/">← Continue shopping</a></header>
      <section className="product-shell">
        <div className="product-showcase"><p className="checkout-kicker">BOTANICAL LUXURY HAIR OIL</p><div className="checkout-image"><img src="/assets/herbella-bottle.png" alt="Herbella botanical hair oil" /><span>{item.units} × 100 ml</span></div><h1>{item.name}</h1><p>{item.copy}</p><div className="package-tabs" aria-label="Choose a package">{Object.values(packages).map((option) => <button type="button" className={selected === option.id ? "active" : ""} onClick={() => setSelected(option.id)} key={option.id}><span>{option.units} bottle{option.units > 1 ? "s" : ""}</span><strong>{money(option.price)}</strong></button>)}</div></div>
        <form className="checkout-form" onSubmit={submitOrder}>
          <div className="checkout-heading"><p className="checkout-kicker">SECURE CHECKOUT</p><h2>Complete your <em>ritual.</em></h2><p>Delivery across Pakistan · Pay when your order arrives.</p></div>
          <div className="quantity-row"><span>Package quantity</span><div><button type="button" aria-label="Decrease quantity" onClick={() => setQuantity(Math.max(1, quantity - 1))}>−</button><strong>{quantity}</strong><button type="button" aria-label="Increase quantity" onClick={() => setQuantity(Math.min(10, quantity + 1))}>+</button></div></div>
          <fieldset><legend>Delivery details</legend><div className="field-grid"><label>Full name<input name="customerName" required autoComplete="name" placeholder="Your full name" /></label><label>Phone number<input name="phone" required autoComplete="tel" placeholder="03XX XXXXXXX" /></label><label>Email address<input name="email" type="email" required autoComplete="email" placeholder="you@example.com" /></label><label>City<input name="city" required autoComplete="address-level2" placeholder="Your city" /></label><label className="full">Delivery address<textarea name="address" required autoComplete="street-address" rows={3} placeholder="House, street and area" /></label><label className="full">Order notes <span>(optional)</span><textarea name="notes" rows={2} placeholder="Any delivery instructions?" /></label></div></fieldset>
          <fieldset><legend>Payment method</legend><label className="payment-option"><span className="radio-dot" /><span><strong>Cash on Delivery</strong><small>Pay in cash when your Herbella order arrives.</small></span><b>COD</b></label><p className="future-payments">Card and wallet payments are coming soon.</p></fieldset>
          <div className="order-summary"><h3>Order summary</h3><div><span>{item.name} × {quantity}</span><strong>{money(subtotal)}</strong></div><div><span>Shipping</span><strong>{money(300)}</strong></div><div className="total"><span>Total</span><strong>{money(total)}</strong></div></div>
          {error && <p className="checkout-error" role="alert">{error}</p>}
          <button className="checkout-button" disabled={submitting} type="submit">{submitting ? "Placing order…" : `Place COD order · ${money(total)}`} <span>→</span></button>
          <p className="checkout-terms">By placing your order, you confirm that your delivery details are correct.</p>
        </form>
      </section>
    </main>
  );
}
