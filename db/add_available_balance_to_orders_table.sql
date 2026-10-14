ALTER TABLE `orders`
ADD COLUMN `available_balance` DECIMAL(12, 2) NULL AFTER `proof_image`;
