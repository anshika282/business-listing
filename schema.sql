CREATE DATABASE IF NOT EXISTS business_listing
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE business_listing;

CREATE TABLE IF NOT EXISTS businesses (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(150)  NOT NULL,
    address    VARCHAR(255)  NOT NULL,
    phone      VARCHAR(20)   NOT NULL,
    email      VARCHAR(100)  NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS ratings (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    business_id INT UNSIGNED  NOT NULL,
    name        VARCHAR(100)  NOT NULL,
    email       VARCHAR(100)  NOT NULL,
    phone       VARCHAR(20)   NOT NULL,
    rating      DECIMAL(3,1)  NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (business_id) REFERENCES businesses(id) ON DELETE CASCADE
);

-- Sample data
INSERT INTO businesses (name, address, phone, email) VALUES
('Sunrise Cafe',        '12 Mall Road, Shimla',       '9816001001', 'sunrise@cafe.com'),
('TechNest Solutions',  '45 Cart Road, Shimla',       '9816002002', 'info@technest.in'),
('Green Valley Stays',  '7 Chota Shimla, Shimla',     '9816003003', 'stay@greenvalley.com');