CREATE TABLE `mobile_variants` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mobile_id` bigint(20) UNSIGNED NOT NULL,
  `storage_id` bigint(20) UNSIGNED NOT NULL,
  `price` varchar(100) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile_variants_unique` (`mobile_id`, `storage_id`, `status`),
  KEY `mobile_variants_storage_id_index` (`storage_id`),
  CONSTRAINT `mobile_variants_mobile_id_foreign` FOREIGN KEY (`mobile_id`) REFERENCES `mobiles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mobile_variants_storage_id_foreign` FOREIGN KEY (`storage_id`) REFERENCES `storages` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `mobile_variants` (`mobile_id`, `storage_id`, `price`, `status`, `created_at`, `updated_at`)
SELECT `id`, `storage_id`, `price`, `status`, `created_at`, `updated_at`
FROM `mobiles`
WHERE `storage_id` IS NOT NULL;