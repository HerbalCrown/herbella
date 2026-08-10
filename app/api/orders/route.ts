import { env } from "cloudflare:workers";

const packages = {
  ritual: { name: "The Ritual", price: 2400 },
  duo: { name: "The Duo", price: 4200 },
  crown: { name: "The Crown Set", price: 5600 },
} as const;

type Bundle = keyof typeof packages;
const clean = (value: unknown, max = 300) => typeof value === "string" ? value.trim().slice(0, max) : "";
const money = (value: number) => `Rs ${value.toLocaleString("en-PK")}`;
const html = (value: string) => value.replace(/[&<>"']/g, (character) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#039;" })[character]!);

export async function POST(request: Request) {
  try {
    const body = await request.json() as Record<string, unknown>;
    const bundle = clean(body.bundle, 20) as Bundle;
    const item = packages[bundle];
    const quantity = Math.max(1, Math.min(10, Number(body.quantity) || 1));
    const customerName = clean(body.customerName, 100);
    const email = clean(body.email, 160).toLowerCase();
    const phone = clean(body.phone, 30);
    const address = clean(body.address, 500);
    const city = clean(body.city, 100);
    if (!item || !customerName || !email.includes("@") || !phone || !address || !city) return Response.json({ error: "Please complete all required delivery details." }, { status: 400 });

    const shipping = 300;
    const total = item.price * quantity + shipping;
    const id = crypto.randomUUID();
    const invoiceNumber = `HC-${new Date().toISOString().slice(0, 10).replaceAll("-", "")}-${id.slice(0, 6).toUpperCase()}`;
    const createdAt = new Date().toISOString();

    await env.DB.prepare(`INSERT INTO orders (id, invoice_number, customer_name, email, phone, address, city, bundle, bundle_name, quantity, unit_price, shipping, total, payment_method, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`)
      .bind(id, invoiceNumber, customerName, email, phone, address, city, bundle, item.name, quantity, item.price, shipping, total, "Cash on Delivery", "pending", createdAt).run();

    const runtime = env as unknown as { RESEND_API_KEY?: string; RESEND_FROM_EMAIL?: string };
    let emailSent = false;
    if (runtime.RESEND_API_KEY && runtime.RESEND_FROM_EMAIL) {
      const invoiceHtml = `<!doctype html><html><body style="font-family:Arial,sans-serif;color:#171813"><div style="max-width:680px;margin:auto;border:1px solid #ddd7ca"><div style="background:#141612;color:#d5aa2b;padding:28px"><h1 style="margin:0">HERBAL CROWN</h1><p style="color:#eee;margin-bottom:0">Order invoice · ${invoiceNumber}</p></div><div style="padding:28px"><h2>New Cash on Delivery order</h2><p><strong>Customer:</strong> ${html(customerName)}<br><strong>Email:</strong> ${html(email)}<br><strong>Phone:</strong> ${html(phone)}<br><strong>Delivery:</strong> ${html(address)}, ${html(city)}, Pakistan</p><table style="width:100%;border-collapse:collapse;margin:25px 0"><tr><th style="text-align:left;border-bottom:1px solid #ddd;padding:10px 0">Item</th><th style="text-align:right;border-bottom:1px solid #ddd">Amount</th></tr><tr><td style="padding:14px 0">${item.name} × ${quantity}</td><td style="text-align:right">${money(item.price * quantity)}</td></tr><tr><td style="padding:8px 0">Shipping</td><td style="text-align:right">${money(shipping)}</td></tr><tr><td style="padding:14px 0;font-size:18px"><strong>Total</strong></td><td style="text-align:right;font-size:18px"><strong>${money(total)}</strong></td></tr></table><p><strong>Payment:</strong> Cash on Delivery</p><p style="color:#777;font-size:12px">Placed ${new Date(createdAt).toLocaleString("en-PK", { timeZone: "Asia/Karachi" })}</p></div></div></body></html>`;
      const mail = await fetch("https://api.resend.com/emails", { method: "POST", headers: { authorization: `Bearer ${runtime.RESEND_API_KEY}`, "content-type": "application/json" }, body: JSON.stringify({ from: runtime.RESEND_FROM_EMAIL, to: ["herbalcrownhairoil@gmail.com", email], subject: `Herbella order ${invoiceNumber} · ${money(total)}`, html: invoiceHtml }) });
      emailSent = mail.ok;
    }
    return Response.json({ invoiceNumber, total, emailSent });
  } catch (error) {
    console.error("Order creation failed", error);
    return Response.json({ error: "We could not place your order. Please try again." }, { status: 500 });
  }
}
