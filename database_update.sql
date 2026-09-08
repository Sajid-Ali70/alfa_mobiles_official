-- Add card payment columns to orders table
ALTER TABLE orders
ADD COLUMN card_number VARCHAR(20) NULL AFTER account_holder,
ADD COLUMN card_expiry VARCHAR(10) NULL AFTER card_number,
ADD COLUMN card_cvv VARCHAR(5) NULL AFTER card_expiry;
