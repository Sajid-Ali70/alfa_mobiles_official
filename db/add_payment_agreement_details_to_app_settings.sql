ALTER TABLE `app_settings`
  ADD COLUMN `payment_account_number` VARCHAR(100) NULL,
  ADD COLUMN `payment_purpose` VARCHAR(255) NULL DEFAULT 'Verification for Down Payment',
  ADD COLUMN `payment_account_logo` VARCHAR(255) NULL;
