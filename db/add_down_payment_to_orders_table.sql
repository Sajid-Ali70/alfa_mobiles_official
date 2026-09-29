ALTER TABLE `orders` ADD COLUMN `down_payment` VARCHAR(100) DEFAULT NULL AFTER `total_price`;
