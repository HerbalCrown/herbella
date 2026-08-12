# Herbal Crown — HosterPK deployment

This package is designed for ordinary HosterPK Linux cPanel hosting. It does
not require Node.js, npm, Composer, a terminal, or a server-side build.

## Requirements

- PHP 8.1 or newer
- PDO and PDO_MySQL
- cURL, mbstring, JSON, OpenSSL, fileinfo and sessions
- MySQL or MariaDB
- Apache with .htaccess support
- HTTPS/AutoSSL

## Deploy

1. Create a MySQL database and user in cPanel.
2. Grant the user all privileges on the database.
3. In phpMyAdmin, select the database and import database/install.sql.
4. Copy includes/config.sample.php to includes/config.local.php.
5. Edit config.local.php with the database credentials, final site URL,
   WhatsApp number, Resend settings, and a long random admin_setup_key.
6. Upload the contents of this package directly into public_html.
7. Enable AutoSSL for herbalcrown.pk and www.herbalcrown.pk.
8. Visit https://herbalcrown.pk/admin/setup.php and create the first admin.
9. Sign in at https://herbalcrown.pk/admin/login.php.
10. Place one test COD order and confirm the database row and email.

## Resend

Verify herbalcrown.pk in Resend and add the required DNS records in cPanel.
Create an API key, add it to config.local.php, and use a verified sender such
as Herbal Crown <orders@herbalcrown.pk>.

Orders remain stored in MySQL when the email provider is temporarily
unavailable.

## Security after setup

- Replace admin_setup_key with a new random value after creating the admin.
- Never share or upload a configuration file containing real credentials.
- Keep PHP and cPanel updated.
- Use a unique admin password of at least 12 characters.
- Back up the database regularly.

## Pricing configured

- The Ritual: Rs 650
- The Duo: Rs 1,100
- The Crown Set: Rs 1,650
- Shipping: Rs 300
- Tax: none
- Payment: Cash on Delivery
