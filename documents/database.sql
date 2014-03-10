SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Table `paypal_transaction`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `paypal_transaction` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `paypal_account` VARCHAR(225) NOT NULL ,
  `paypal_destination` VARCHAR(225) NOT NULL ,
  `currency` VARCHAR(45) NOT NULL ,
  `transaction_type` VARCHAR(45) NOT NULL ,
  `has_individual_items` TINYINT NOT NULL ,
  `has_shipping` TINYINT NOT NULL ,
  `handling_price` FLOAT NOT NULL ,
  `ipn_url` VARCHAR(1000) NOT NULL ,
  `customer_success_url` VARCHAR(1000) NOT NULL ,
  `customer_cancel_url` VARCHAR(1000) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `paypal_transaction_item`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `paypal_transaction_item` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `paypal_transaction_id` INT NOT NULL ,
  `name` VARCHAR(225) NOT NULL ,
  `price` FLOAT NOT NULL ,
  `quantity` INT NOT NULL ,
  `number` VARCHAR(225) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_paypal_transaction_item_paypal_transaction_idx` (`paypal_transaction_id` ASC) ,
  CONSTRAINT `fk_paypal_transaction_item_paypal_transaction`
    FOREIGN KEY (`paypal_transaction_id` )
    REFERENCES `paypal_transaction` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `paypal_transaction_listener`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `paypal_transaction_listener` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `paypal_transaction_id` INT NOT NULL ,
  `param_name` VARCHAR(225) NOT NULL ,
  `param_value` VARCHAR(225) NULL ,
  `listener` TEXT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_paypal_transaction_listener_paypal_transaction1_idx` (`paypal_transaction_id` ASC) ,
  CONSTRAINT `fk_paypal_transaction_listener_paypal_transaction1`
    FOREIGN KEY (`paypal_transaction_id` )
    REFERENCES `paypal_transaction` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `paypal_transaction_notification`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `paypal_transaction_notification` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `paypal_transaction_id` INT NOT NULL ,
  `receiver_email` VARCHAR(225) NOT NULL ,
  `receiver_id` VARCHAR(225) NOT NULL ,
  `residence_country` VARCHAR(225) NOT NULL ,
  `test_ipn` TINYINT NULL DEFAULT 0 ,
  `transaction_subject` VARCHAR(225) NULL ,
  `txn_id` VARCHAR(225) NOT NULL ,
  `txn_type` VARCHAR(225) NOT NULL ,
  `payer_email` VARCHAR(225) NOT NULL ,
  `payer_id` VARCHAR(225) NOT NULL ,
  `payer_status` VARCHAR(225) NOT NULL ,
  `first_name` VARCHAR(225) NOT NULL ,
  `last_name` VARCHAR(225) NOT NULL ,
  `address_city` VARCHAR(225) NULL ,
  `address_country` VARCHAR(225) NULL ,
  `address_country_code` VARCHAR(15) NULL ,
  `address_name` VARCHAR(225) NULL ,
  `address_state` VARCHAR(100) NULL ,
  `address_status` VARCHAR(45) NULL ,
  `address_street` VARCHAR(225) NULL ,
  `address_zip` VARCHAR(45) NULL ,
  `custom` VARCHAR(225) NOT NULL ,
  `handling_amount` FLOAT NULL DEFAULT 0 ,
  `mc_currency` VARCHAR(225) NULL ,
  `mc_fee` FLOAT NOT NULL ,
  `mc_gross` FLOAT NOT NULL ,
  `payment_date` VARCHAR(225) NULL ,
  `payment_fee` FLOAT NOT NULL ,
  `payment_gross` FLOAT NOT NULL ,
  `payment_status` VARCHAR(225) NULL ,
  `payment_type` VARCHAR(225) NULL ,
  `protection_eligibility` VARCHAR(225) NULL ,
  `shipping` FLOAT NULL DEFAULT 0 ,
  `tax` FLOAT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_paypal_transaction_notification_paypal_transaction1_idx` (`paypal_transaction_id` ASC) ,
  CONSTRAINT `fk_paypal_transaction_notification_paypal_transaction1`
    FOREIGN KEY (`paypal_transaction_id` )
    REFERENCES `paypal_transaction` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
