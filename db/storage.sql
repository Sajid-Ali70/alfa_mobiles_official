-- Create storages table
CREATE TABLE `storages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add storage_id to mobiles table
ALTER TABLE `mobiles` ADD `storage_id` bigint(20) UNSIGNED DEFAULT NULL AFTER `series_id`;

-- Add foreign key constraint
ALTER TABLE `mobiles` ADD CONSTRAINT `mobiles_ibfk_3` FOREIGN KEY (`storage_id`) REFERENCES `storages` (`id`) ON DELETE SET NULL;

-- Add storage to orders table for tracking
ALTER TABLE `orders` ADD `storage` varchar(100) DEFAULT NULL AFTER `color`;
