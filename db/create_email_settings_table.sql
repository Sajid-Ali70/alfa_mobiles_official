CREATE TABLE IF NOT EXISTS `email_settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `mail_driver` varchar(50) NOT NULL DEFAULT 'smtp',
  `mail_host` varchar(255) NULL,
  `mail_port` varchar(10) NULL,
  `mail_username` varchar(255) NULL,
  `mail_password` varchar(255) NULL,
  `mail_encryption` varchar(50) NULL,
  `mail_from_address` varchar(255) NULL,
  `mail_from_name` varchar(255) NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Optional: Insert default or placeholder row for ID 1
INSERT INTO `email_settings` (`id`, `mail_driver`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from_address`, `mail_from_name`, `created_at`, `updated_at`)
VALUES (1, 'smtp', 'smtp.mailtrap.io', '2525', '', '', 'tlsv1.2', 'info@alfamobiles.com', 'Alfa Mobiles', NOW(), NOW())
ON DUPLICATE KEY UPDATE `id`=`id`;
