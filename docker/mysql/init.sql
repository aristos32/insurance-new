CREATE DATABASE IF NOT EXISTS insurance_global CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON insurance_global.* TO 'insurance'@'%';
FLUSH PRIVILEGES;
