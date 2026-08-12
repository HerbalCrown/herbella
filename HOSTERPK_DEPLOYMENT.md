# HosterPK deployment

This project needs a HosterPK VPS or cPanel package that supports a persistent
Node.js application. Confirm that the account offers **Setup Node.js App** with
Node.js 22.13 or newer before deployment.

## 1. Create the MySQL database

In cPanel:

1. Create a database and database user under **MySQL Databases**.
2. Grant the user **All Privileges** on the database.
3. Open **phpMyAdmin**, select the database, choose **Import**, and import
   database/mysql-schema.sql.

## 2. Configure the Node.js application

In **Setup Node.js App**:

- Node.js version: 22.13 or newer
- Application mode: Production
- Application root: the repository/project directory
- Application URL: https://herbalcrown.pk
- Application startup file: dist/server/server.mjs

Install and build over cPanel Terminal or SSH:

    corepack enable
    pnpm install --frozen-lockfile
    pnpm run build:node

The server uses the PORT assigned by cPanel automatically.

## 3. Add environment variables

Add these values in **Setup Node.js App > Environment Variables**:

    NODE_ENV=production
    DB_HOST=localhost
    DB_PORT=3306
    DB_USER=<cpanel database user>
    DB_PASSWORD=<database password>
    DB_NAME=<cpanel database name>
    RESEND_API_KEY=<resend API key>
    RESEND_FROM_EMAIL=Herbal Crown <orders@herbalcrown.pk>

Do not commit real passwords or API keys to Git.

## 4. Configure email

Add and verify herbalcrown.pk in Resend. Copy Resend's SPF and DKIM records
into the HosterPK DNS zone, then create an API key and add it to the Node.js
application environment.

Orders are saved even if email delivery temporarily fails. The confirmation
page will indicate when email is not configured.

## 5. Domain and SSL

The root domain and www hostname must point to the HosterPK account. Enable
AutoSSL for both:

- herbalcrown.pk
- www.herbalcrown.pk

After the first deployment, restart the Node.js application and test:

1. Home page and product page
2. One Cash on Delivery test order
3. The new row in the MySQL orders table
4. Email receipt at herbalcrownhairoil@gmail.com
5. Mobile layout and HTTPS redirect
