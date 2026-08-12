CREATE TABLE IF NOT EXISTS orders (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  order_number VARCHAR(32) NOT NULL,
  customer_name VARCHAR(100) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  alternate_phone VARCHAR(30) NULL,
  email VARCHAR(160) NULL,
  province VARCHAR(100) NOT NULL,
  city VARCHAR(100) NOT NULL,
  address VARCHAR(500) NOT NULL,
  landmark VARCHAR(180) NULL,
  bundle VARCHAR(20) NOT NULL,
  bundle_name VARCHAR(100) NOT NULL,
  quantity TINYINT UNSIGNED NOT NULL,
  unit_price INT UNSIGNED NOT NULL,
  shipping INT UNSIGNED NOT NULL,
  discount INT UNSIGNED NOT NULL DEFAULT 0,
  total INT UNSIGNED NOT NULL,
  payment_method VARCHAR(40) NOT NULL DEFAULT 'Cash on Delivery',
  order_status VARCHAR(30) NOT NULL DEFAULT 'pending',
  courier VARCHAR(100) NULL,
  tracking_number VARCHAR(100) NULL,
  notes VARCHAR(500) NULL,
  ip_address VARCHAR(45) NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY orders_order_number_unique (order_number),
  KEY orders_status_index (order_status),
  KEY orders_phone_index (phone),
  KEY orders_created_at_index (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS admins (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(160) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY admins_email_unique (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS rate_limits (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  action_key CHAR(64) NOT NULL,
  created_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  KEY rate_limits_action_created_index (action_key, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
