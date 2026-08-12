import mysql from "mysql2/promise";

const packages = {
  ritual: { name: "The Ritual", price: 650 },
  duo: { name: "The Duo", price: 1100 },
  crown: { name: "The Crown Set", price: 1650 },
} as const;

type Bundle = keyof typeof packages;

const clean = (value: unknown, max = 300) =>
  typeof value === "string" ? value.trim().slice(0, max) : "";

const money = (value: number) => `Rs ${value.toLocaleString("en-PK")}`;

const html = (value: string) =>
  value.replace(/[&<>"']/g, (character) => {
    const entities: Record<string, string> = {
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      '"': "&quot;",
      "'": "&#039;",
    };

    return entities[character] ?? character;
  });

/**
 * Create one reusable MySQL connection pool.
 *
 * These values will be configured in:
 * cPanel -> Setup Node.js App -> Environment Variables
 */
const pool = mysql.createPool({
  host: process.env.DB_HOST || "localhost",
  port: Number(process.env.DB_PORT || "3306"),
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,

  waitForConnections: true,
  connectionLimit: 5,
  queueLimit: 0,

  charset: "utf8mb4",
});

export async function POST(request: Request) {
  try {
    /*
     * Make sure database configuration exists.
     * This produces a clearer server error if cPanel variables
     * haven't been configured correctly.
     */
    if (
      !process.env.DB_USER ||
      !process.env.DB_PASSWORD ||
      !process.env.DB_NAME
    ) {
      console.error("Missing required MySQL environment variables.");

      return Response.json(
        {
          error: "Server database configuration is incomplete.",
        },
        {
          status: 500,
        },
      );
    }

    const body = (await request.json()) as Record<string, unknown>;

    const bundle = clean(body.bundle, 20) as Bundle;
    const item = packages[bundle];

    const quantity = Math.max(1, Math.min(10, Number(body.quantity) || 1));

    const customerName = clean(body.customerName, 100);
    const email = clean(body.email, 160).toLowerCase();
    const phone = clean(body.phone, 30);
    const address = clean(body.address, 500);
    const city = clean(body.city, 100);

    if (
      !item ||
      !customerName ||
      !email ||
      !email.includes("@") ||
      !phone ||
      !address ||
      !city
    ) {
      return Response.json(
        {
          error: "Please complete all required delivery details.",
        },
        {
          status: 400,
        },
      );
    }

    const shipping = 300;
    const subtotal = item.price * quantity;
    const total = subtotal + shipping;

    const id = crypto.randomUUID();

    const invoiceNumber =
      `HC-${new Date().toISOString().slice(0, 10).replaceAll("-", "")}-` +
      id.slice(0, 6).toUpperCase();

    const createdAt = new Date();

    /*
     * Insert the order into MySQL.
     *
     * mysql2 parameter placeholders (?) protect against
     * SQL injection when values are supplied separately.
     */
    await pool.execute(
      `
        INSERT INTO orders (
          id,
          invoice_number,
          customer_name,
          email,
          phone,
          address,
          city,
          bundle,
          bundle_name,
          quantity,
          unit_price,
          shipping,
          total,
          payment_method,
          status,
          created_at
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
      `,
      [
        id,
        invoiceNumber,
        customerName,
        email,
        phone,
        address,
        city,
        bundle,
        item.name,
        quantity,
        item.price,
        shipping,
        total,
        "Cash on Delivery",
        "pending",
        createdAt,
      ],
    );

    /*
     * Send order/invoice email using Resend.
     */
    let emailSent = false;

    const resendApiKey = process.env.RESEND_API_KEY;
    const resendFromEmail = process.env.RESEND_FROM_EMAIL;

    if (resendApiKey && resendFromEmail) {
      const invoiceHtml = `
        <!doctype html>
        <html>
          <body
            style="
              font-family: Arial, sans-serif;
              color: #171813;
              margin: 0;
              padding: 20px;
            "
          >
            <div
              style="
                max-width: 680px;
                margin: auto;
                border: 1px solid #ddd7ca;
              "
            >
              <div
                style="
                  background: #141612;
                  color: #d5aa2b;
                  padding: 28px;
                "
              >
                <h1 style="margin: 0;">
                  HERBAL CROWN
                </h1>

                <p
                  style="
                    color: #eeeeee;
                    margin-bottom: 0;
                  "
                >
                  Order invoice · ${html(invoiceNumber)}
                </p>
              </div>

              <div style="padding: 28px;">
                <h2>New Cash on Delivery order</h2>

                <p>
                  <strong>Customer:</strong>
                  ${html(customerName)}
                  <br />

                  <strong>Email:</strong>
                  ${html(email)}
                  <br />

                  <strong>Phone:</strong>
                  ${html(phone)}
                  <br />

                  <strong>Delivery:</strong>
                  ${html(address)}, ${html(city)}, Pakistan
                </p>

                <table
                  style="
                    width: 100%;
                    border-collapse: collapse;
                    margin: 25px 0;
                  "
                >
                  <tr>
                    <th
                      style="
                        text-align: left;
                        border-bottom: 1px solid #dddddd;
                        padding: 10px 0;
                      "
                    >
                      Item
                    </th>

                    <th
                      style="
                        text-align: right;
                        border-bottom: 1px solid #dddddd;
                      "
                    >
                      Amount
                    </th>
                  </tr>

                  <tr>
                    <td style="padding: 14px 0;">
                      ${html(item.name)} × ${quantity}
                    </td>

                    <td style="text-align: right;">
                      ${money(subtotal)}
                    </td>
                  </tr>

                  <tr>
                    <td style="padding: 8px 0;">
                      Shipping
                    </td>

                    <td style="text-align: right;">
                      ${money(shipping)}
                    </td>
                  </tr>

                  <tr>
                    <td
                      style="
                        padding: 14px 0;
                        font-size: 18px;
                      "
                    >
                      <strong>Total</strong>
                    </td>

                    <td
                      style="
                        text-align: right;
                        font-size: 18px;
                      "
                    >
                      <strong>${money(total)}</strong>
                    </td>
                  </tr>
                </table>

                <p>
                  <strong>Payment:</strong>
                  Cash on Delivery
                </p>

                <p
                  style="
                    color: #777777;
                    font-size: 12px;
                  "
                >
                  Placed
                  ${createdAt.toLocaleString("en-PK", {
                    timeZone: "Asia/Karachi",
                  })}
                </p>
              </div>
            </div>
          </body>
        </html>
      `;

      try {
        const mail = await fetch("https://api.resend.com/emails", {
          method: "POST",

          headers: {
            Authorization: `Bearer ${resendApiKey}`,
            "Content-Type": "application/json",
          },

          body: JSON.stringify({
            from: resendFromEmail,

            to: ["herbalcrownhairoil@gmail.com", email],

            subject: `Herbal Crown order ${invoiceNumber} · ${money(total)}`,

            html: invoiceHtml,
          }),
        });

        emailSent = mail.ok;

        if (!mail.ok) {
          const mailError = await mail.text();

          console.error("Resend email failed:", mail.status, mailError);
        }
      } catch (emailError) {
        console.error("Unable to send order email:", emailError);
      }
    }

    return Response.json({
      success: true,
      invoiceNumber,
      subtotal,
      shipping,
      total,
      emailSent,
    });
  } catch (error) {
    console.error("Order creation failed:", error);

    return Response.json(
      {
        error: "We could not place your order. Please try again.",
      },
      {
        status: 500,
      },
    );
  }
}
