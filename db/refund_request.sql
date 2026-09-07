CREATE TABLE `refund_requests` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refund_id` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `refund_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `proof_image` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
