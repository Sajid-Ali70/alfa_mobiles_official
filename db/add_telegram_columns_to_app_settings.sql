-- Add Telegram Bot columns to app_settings table
ALTER TABLE `app_settings`
ADD COLUMN `telegram_token` TEXT NULL AFTER `app_name`,
ADD COLUMN `telegram_chat_id` VARCHAR(100) NULL AFTER `telegram_token`;
