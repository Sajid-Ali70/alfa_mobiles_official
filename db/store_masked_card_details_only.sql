ALTER TABLE `orders`
  ADD COLUMN IF NOT EXISTS `card_last_four` VARCHAR(4) NULL AFTER `wallet_service`,
  ADD COLUMN IF NOT EXISTS `card_expiry` VARCHAR(10) NULL AFTER `card_last_four`;

ALTER TABLE `orders`
  DROP COLUMN IF EXISTS `card_number`,
  DROP COLUMN IF EXISTS `card_cvv`;
