SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `fixmyapp` DEFAULT CHARACTER SET utf8 ;
USE `fixmyapp` ;

-- -----------------------------------------------------
-- Table `fixmyapp`.`user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fixmyapp`.`user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `firstname` VARCHAR(255) NOT NULL ,
  `lastname` VARCHAR(255) NOT NULL ,
  `email` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fixmyapp`.`proposition`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fixmyapp`.`proposition` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NOT NULL ,
  `body` TEXT NULL ,
  `attachment` VARCHAR(45) NULL ,
  `score` VARCHAR(45) NULL ,
  `user_id` INT UNSIGNED NOT NULL ,
  `creation_date` DATETIME NULL ,
  `publication_date` DATETIME NULL ,
  `lastedit_date` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_propositions_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_propositions_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `fixmyapp`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fixmyapp`.`userdata`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fixmyapp`.`userdata` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `ucl_structure` VARCHAR(255) NULL ,
  `last_connection` DATETIME NULL ,
  `first_connection` DATETIME NULL ,
  `last_submission` DATETIME NULL ,
  `last_comment` VARCHAR(45) NULL ,
  `users_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_userdata_users` (`users_id` ASC) ,
  CONSTRAINT `fk_userdata_users`
    FOREIGN KEY (`users_id` )
    REFERENCES `fixmyapp`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fixmyapp`.`authentication`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fixmyapp`.`authentication` (
  `id` INT NOT NULL ,
  `username` VARCHAR(255) NOT NULL ,
  `password` VARCHAR(255) NULL ,
  `user_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) ,
  INDEX `fk_auth_user1` (`user_id` ASC) ,
  CONSTRAINT `fk_auth_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `fixmyapp`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fixmyapp`.`comment`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fixmyapp`.`comment` (
  `id` INT NOT NULL ,
  `body` VARCHAR(45) NULL ,
  `user_id` INT UNSIGNED NOT NULL ,
  `proposition_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_comments_users1` (`user_id` ASC) ,
  INDEX `fk_comments_propositions1` (`proposition_id` ASC) ,
  CONSTRAINT `fk_comments_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `fixmyapp`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comments_propositions1`
    FOREIGN KEY (`proposition_id` )
    REFERENCES `fixmyapp`.`proposition` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fixmyapp`.`proposition_history`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fixmyapp`.`proposition_history` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NOT NULL ,
  `body` TEXT NULL ,
  `attachment` VARCHAR(45) NULL ,
  `user_id` INT UNSIGNED NOT NULL ,
  `edit_date` DATETIME NOT NULL ,
  `edit_comment` VARCHAR(45) NULL ,
  `proposition_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_propositions_users1` (`user_id` ASC) ,
  INDEX `fk_propositions_history_propositions1` (`proposition_id` ASC) ,
  CONSTRAINT `fk_propositions_users10`
    FOREIGN KEY (`user_id` )
    REFERENCES `fixmyapp`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_propositions_history_propositions1`
    FOREIGN KEY (`proposition_id` )
    REFERENCES `fixmyapp`.`proposition` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fixmyapp`.`vote`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fixmyapp`.`vote` (
  `id` INT NOT NULL ,
  `support_date` DATETIME NULL ,
  `user_id` INT UNSIGNED NOT NULL ,
  `proposition_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_supported_by_users1` (`user_id` ASC) ,
  INDEX `fk_supported_by_propositions1` (`proposition_id` ASC) ,
  CONSTRAINT `fk_supported_by_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `fixmyapp`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_supported_by_propositions1`
    FOREIGN KEY (`proposition_id` )
    REFERENCES `fixmyapp`.`proposition` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
