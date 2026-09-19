ALTER TABLE `orders`
ADD COLUMN `rider_name` VARCHAR(255) NULL AFTER `status`,
ADD COLUMN `rider_phone` VARCHAR(20) NULL AFTER `rider_name`;
